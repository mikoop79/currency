<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurrencyApiController extends Controller
{
    /**
     * @var ApiRequestService
     */
    private ApiRequestService $service;

    public function __construct(ApiRequestService $service)
    {
        $this->service = $service;
    }

    /**v
     * @param Request $request
     * @return array|mixed
     */
    public function list(Request $request)
    {
        return response()->json($this->service->get('list', $request->all())->json());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function convert(Request $request): JsonResponse
    {
        return response()->json($this->service->get('convert', $request->all())->json());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function change(Request $request): JsonResponse
    {
        return response()->json($this->service->get('change', $request->all())->json());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function historical(Request $request): JsonResponse
    {
        return response()->json($this->service->get('historical', $request->all())->json());
    }

}
