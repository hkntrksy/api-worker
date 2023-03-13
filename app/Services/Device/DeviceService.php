<?php

namespace App\Services\Device;

use App\Exceptions\ServiceException;
use App\Models\Device;
use App\Models\Subscription;
use App\Repositories\DeviceRepository;
use App\Repositories\SubscriptionRepository;
use App\Services\Payment\PaymentFactory;
use Exception;

class DeviceService
{

    public function __construct(
        private DeviceRepository $deviceRepository,
        private SubscriptionRepository $subscriptionRepository
    )
    {
        //..
    }

    /**
     * @param Device $device
     * @return string
     */
    public function register(Device $device): string
    {

        $getDevice = $this->deviceRepository->getDeviceByUuid($device->uuid);

        if ($getDevice) {
            $device = $getDevice;
        } else {
            $device->client_token = $this->generateToken();
            $this->deviceRepository->createDevice($device);
        }

        return $device->client_token;

    }

    /**
     * @param string $receipt
     * @param string $clientToken
     * @return string[]
     * @throws ServiceException
     */
    public function purchase(string $receipt, string $clientToken): array
    {

        $getDevice = $this->deviceRepository->getDeviceByClientToken($clientToken);

        if (!$getDevice) {
            throw new ServiceException(400, 'Device not found.');
        }

        $checkSubscription = $this->subscriptionRepository->checkSubscriptionByDeviceId($getDevice->id);

        if ($checkSubscription) {
            throw new ServiceException(400, 'Subscription already exists.');
        }

        try {

            $paymentPlatform = PaymentFactory::createPaymentPlatform($getDevice->operating_system);
            $paymentResponse = $paymentPlatform->validateReceipt($receipt);

            if (!$paymentResponse->status){
                throw new ServiceException(400, 'Invalid receipt.');
            }

            $subscription = new Subscription();
            $subscription->device_id = $getDevice->id;
            $subscription->receipt = $receipt;
            $subscription->status = $paymentResponse->status;
            $subscription->expire_date = $paymentResponse->expire_date;

            $this->subscriptionRepository->createSubscription($subscription);

        }catch (Exception $e) {
            throw new ServiceException(400, $e->getMessage());
        }

        return [
            $paymentResponse->status,
            $paymentResponse->expire_date
        ];

    }

    /**
     * @param string $clientToken
     * @return mixed
     * @throws ServiceException
     */
    public function checkSubscription(string $clientToken): mixed
    {
        $getDevice = $this->deviceRepository->getDeviceByClientToken($clientToken);

        if (!$getDevice) {
            throw new ServiceException(400, 'Device not found.');
        }

        $getSubscription = $this->subscriptionRepository->checkSubscriptionByDeviceId($getDevice->id);

        if (!$getSubscription) {
            throw new ServiceException(400, 'Subscription not found.');
        }

        return [
            (bool) $getSubscription->status,
            $getSubscription->expire_date
        ];

    }

    private function generateToken(): string
    {
        return md5(uniqid(rand(), true));
    }

}
