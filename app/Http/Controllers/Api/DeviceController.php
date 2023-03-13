<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ServiceException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Device\PurchaseRequest;
use App\Http\Requests\Api\Device\RegisterRequest;
use App\Models\Device;
use App\Services\Device\DeviceService;

class DeviceController extends Controller
{

    /**
     * @param DeviceService $deviceService
     */
    public function __construct(private DeviceService $deviceService)
    {
        //..
    }

    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {

        try {

            $device = new Device();
            $device->uuid = $request->uuid;
            $device->app_id = $request->app_id;
            $device->language = $request->language;
            $device->operating_system = $request->operating_system;

            $token = $this->deviceService->register($device);

            return responseBuilder()
                ->result('client_token', $token)
                ->ok();

        }catch (ServiceException $e) {
            return responseBuilder()
                ->message('error', $e->getMessage())
                ->get($e->getStatusCode());

        }

    }

    public function purchase(PurchaseRequest $request): \Illuminate\Http\JsonResponse
    {

        try {

            $receipt = $request->receipt;
            $client_token = $request->header('Client-Token');

            list($status, $expireDate) = $this->deviceService->purchase($receipt, $client_token);

            return responseBuilder()
                ->result('status', $status)
                ->result('expire_date', $expireDate)
                ->ok();

        }catch (ServiceException $e) {

            return responseBuilder()
                ->message('error', $e->getMessage())
                ->get($e->getStatusCode());

        }
    }

    public function checkSubscription(): \Illuminate\Http\JsonResponse
    {

        try {

            $client_token = request()->header('Client-Token');

            list($status, $expireDate) = $this->deviceService->checkSubscription($client_token);

            return responseBuilder()
                ->result('status', $status)
                ->result('expire_date', $expireDate)
                ->ok();

        }catch (ServiceException $e) {

            return responseBuilder()
                ->message('error', $e->getMessage())
                ->get($e->getStatusCode());

        }

    }

}
