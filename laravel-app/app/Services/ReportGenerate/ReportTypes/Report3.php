<?php


namespace App\Services\ReportGenerate\ReportTypes;


use App\Contracts\ReportTypeInterface;
use Illuminate\Support\Carbon;


/**
 * Range: One Month, Interval: Daily
 *
 */
class Report3 extends BaseReport implements ReportTypeInterface
{
    /**
     * @throws \JsonException
     */
    public function process(): array
    {
        return $this->getReportData();
    }

    public function getCarbonInterval(): string
    {
        return '1 day';
    }

    public function getStartDate(): Carbon
    {
        return Carbon::parse($this->report->created_at)->subMonths(1);
    }


}
