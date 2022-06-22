<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public const CURRENCY_NUMBER = 5;

    use Authenticatable;

    public function store(Request $request)
    {
        try {

            $user = Auth::user();

            $validator = Validator::make(
                $request->all(), [
                'currencies' => sprintf('required|array|size:%s', self::CURRENCY_NUMBER)
                ]
            );
            if ($validator->fails()) {
                return json_encode($validator->errors());
            }

            Setting::updateOrCreate(
                ['user_id' => $user->getKey()], ['currencies' => json_encode($request->currencies),
                'user_id' => $user->getKey()]
            );

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }

        $access_token = $user->tokens->first()->token;

        return response()->json(['message' => 'Settings Updated', 'user' => $user, 'access_token' => $access_token], 200);

    }

    /**
     * Get the users Currencies selected
     *
     * @param  Request $request
     * @return array
     */
    public function currencies(Request $request)
    {
        if (empty($request->user()->my_currencies)) {
            return response()->json(['data' => []], 200);
        }
        $currencies = json_decode($request->user()->my_currencies, true);
        $currencies = json_decode($currencies, true);


        $data = [];
        foreach ($currencies as $currency){
            $data[] = [
                'label' => sprintf('%s - [%s]', $currency['label'], $currency['value']),
                'value' => $currency['value'],
            ];
        }


        return response()->json(['data' => $data], 200);
    }
}
