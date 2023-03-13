<?php

namespace App\Repositories;
use App\Models\Device;

class DeviceRepository
{

    /**
     * @param Device $model
     */
    public function __construct(private Device $model)
    {
        //..
    }

    public function getDeviceByUuid(string $uuid): mixed
    {
        return $this->model
            ->where('uuid', $uuid)
            ->first();
    }

    public function existDeviceByClientToken(string $clientToken): bool
    {
        return $this->model
            ->where('client_token', $clientToken)
            ->exists();
    }

    public function getDeviceByClientToken(string $clientToken): mixed
    {
        return $this->model
            ->where('client_token', $clientToken)
            ->first();
    }

    public function createDevice(Device $device): mixed
    {
        return $device->save();
    }

}
