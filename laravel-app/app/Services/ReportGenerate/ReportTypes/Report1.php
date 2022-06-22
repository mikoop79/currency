<?php

namespace App\Services\ReportGenerate\ReportTypes;

use App\Contracts\ReportTypeInterface;
use App\Models\Report;
use Illuminate\Support\Carbon;

/**
 * Range: One Year, Interval: Monthly
 *
 * Class Report1
 *
 * @package App\Services\ReportGenerate\ReportTypes
 */
class Report1 extends BaseReport implements ReportTypeInterface
{
    protected Report $report;

    /**
     * @throws \JsonException
     */
    public function process(): array
    {
        return $this->getReportData();
    }

    public function getCarbonInterval(): string
    {
        return '1 month';
    }

    public function getStartDate(): Carbon
    {
        return Carbon::parse($this->report->created_at)->subYears(1);
    }
}
