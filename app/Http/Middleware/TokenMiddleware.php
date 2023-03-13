<?php

namespace App\Http\Middleware;

use App\Repositories\DeviceRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenMiddleware
{

    public function __construct(private DeviceRepository $deviceRepository)
    {
        //..
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(empty($request->header('Client-Token')) || !$this->deviceRepository->existDeviceByClientToken($request->header('Client-Token'))){

            return responseBuilder()
                ->message('error', 'Client Token error.')
                ->get(403);

        }

        return $next($request);
    }
}
