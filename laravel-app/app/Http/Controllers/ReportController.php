<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReportResource;
use App\Models\Report;
use App\Models\User;
use App\Services\ReportGenerate\ReportGenerateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function store(Request $request)
    {

        try {
            /* @var User $user */
            $user = Auth::user();
            $validator = Validator::make($request->all(), [
                'currency' => 'required',
                'type' => 'required',
            ]);

            if ($validator->fails()) {
                throw new \Exception(implode(',', $validator->errors()->all()), 422);
            }

            $params = array_merge($request->all(), ['user_id' => $user->getKey(), 'status_id' => Report::REPORT_STATUSES['pending']]);

            $report = Report::create($params);


        } catch (\Exception $exception) {
            Log::error('error', [$exception, $exception->getCode()]);
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }

        return response()->json(['message' => 'Report scheduled to generate! ', 'report' => $report->toArray()], 200);

    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function my(Request $request)
    {
        $myReports = $request->user()->reports()->ofStatus(Report::REPORT_STATUSES['completed'])->get();
        return ReportResource::collection($myReports);
    }


    /**
     * End point for report types to select to generate the report
     *
     * @return array
     */
    public function types(): array
    {
        $types = [];

        foreach(Report::REPORT_TYPES as $key => $reportType){
            $types[] = ['label' => $reportType['label'], 'value' => $key];
        }

        return $types;
    }

    /**
     * End point for report types to select to generate the report
     *
     * @return array
     */
    public function types2(): array
    {
        $types = [];

        foreach(Report::REPORT_TYPES as $key => $reportType){
            $types[] = ['label' => $reportType['label'], 'value' => $key];
        }

        return $types;
    }
}
