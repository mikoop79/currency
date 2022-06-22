<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiRequestService;
use App\Services\ReformatResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    /**
     *
     * @param  Request $request
     * @return array|mixed
     */
    public function list(Request $request)
    {
        return response()->json($this->service->get('list', $request->all())->json());
    }

    /**
     * @param  Request $request
     * @return JsonResponse
     */
    public function convert(Request $request): JsonResponse
    {
        return response()->json($this->service->get('convert', $request->all())->json());
    }

    /**
     * @param  Request $request
     * @return JsonResponse
     */
    public function change(Request $request): JsonResponse
    {
        return response()->json($this->service->get('change', $request->all())->json());
    }

    /**
     * @param  Request $request
     * @return JsonResponse
     */
    public function historical(Request $request): JsonResponse
    {
        return response()->json($this->service->get('historical', $request->all())->json());
    }

    /**
     * @param  Request $request
     * @return JsonResponse
     */
    public function live(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(), [
            'currencies' => 'required|array',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                'errors' => $validator->errors()->all()
                ], 422
            );
        }

        $requestParams = ReformatResponseService::reformatCurrencyString($request->get('currencies'), 'currencies');

        $response = $this->service->get('live', $requestParams)->json()['quotes'];

        return response()->json(['data' => ReformatResponseService::reformatConversionResponse($response)]);
    }
}
