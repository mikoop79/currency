<?php


namespace App\Services;


use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ReformatResponseService
{
    /**
     * @param  array $items
     * @return array
     */
    public static function reformatCurrencyString(array $items, string $value): array
    {
        $outputData = [];

        foreach ($items as $currency) {
            $outputData[] = json_decode($currency, true)['value'];
        }

        return [
            $value => implode(',', $outputData)
        ];

    }

    /**
     * @param  array $response
     * @return array
     */
    public static function reformatConversionResponse(array $response): array
    {
        $data = [];
        foreach ($response as $key => $item) {
            $data[] = [
                'currency' => substr($key, 3, 3),
                'source' => substr($key, 0, 3),
                'amount' => number_format($response[$key], 2)
            ];
        }
        return $data;
    }

}
