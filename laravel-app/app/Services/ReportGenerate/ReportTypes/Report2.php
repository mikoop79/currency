<?php
namespace App\Services\ReportGenerate\ReportTypes;

use App\Contracts\ReportTypeInterface;
use Illuminate\Support\Carbon;

/**
 * Range: Six Months, Interval: Weekly
 */
class Report2 extends BaseReport implements ReportTypeInterface
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
        return '1 week';
    }

    public function getStartDate(): Carbon
    {
        return Carbon::parse($this->report->created_at)->subMonths(6);
    }
}
