<?php


namespace App\Services\ReportGenerate\ReportTypes;


use App\Models\Report;
use App\Services\ApiRequestService;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class BaseReport
{
    public const DEFAULT_SOURCE = 'USD';
    public const DEFAULT_FORMAT = 'Y-m-d';

    /*
     * @var Report $report
     * */
    protected Report $report;
    protected ApiRequestService $service;

    public function __construct(Report $report)
    {
        $this->report = $report;
        $this->service = new ApiRequestService();
    }

    public function getData(): ?array
    {
        return $this->report->data ?? null;
    }

    /**
     * @param  array $params
     * @return array
     */
    public static function getIntervals(array $params): array
    {
        $dates = [];

        foreach (CarbonPeriod::create($params['start_date'], $params['carbon_interval'], $params['end_date']) as $date) {
            $dates[] = $date->format(self::DEFAULT_FORMAT);
        }

        return $dates;
    }


    public static function getDataByDates($quotes, array $dates): array
    {
        $data = [];
        foreach ($dates as $date){
            $data[$date] = $quotes[$date];
        }
        return $data;
    }

    public function insertData(array $data)
    {
        $this->report->update(['data'=>$data]);
    }

    protected function getParams()
    {
        return [
            'end_date' =>  Carbon::parse($this->report->created_at)->format(self::DEFAULT_FORMAT),
            'start_date' => $this->getStartDate()->format(self::DEFAULT_FORMAT),
            'source' => self::DEFAULT_SOURCE,
            'currencies' => $this->report->currency
        ];
    }

    /**
     * @return array
     * @throws \JsonException
     */
    public function getReportData(): array
    {
        $params = $this->getParams();

        $data = json_decode($this->service->get('timeframe', $params), true, 512, JSON_THROW_ON_ERROR);


        if (empty($data['quotes'])) {
            throw new \JsonException('Error with endpoint');
        }

        $dates = self::getIntervals(
            array_merge(
                $params, [
                'carbon_interval' => $this->getCarbonInterval()
                ]
            )
        );

        return self::getDataByDates($data['quotes'], $dates);
    }

}
