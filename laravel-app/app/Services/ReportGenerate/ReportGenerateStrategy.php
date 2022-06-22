<?php


namespace App\Services\ReportGenerate;


use App\Contracts\ReportTypeInterface;
use App\Models\Report;

class ReportGenerateStrategy
{
    private ReportTypeInterface $reportType;

    public function __construct(ReportTypeInterface $reportType)
    {
        $this->reportType = $reportType;
    }

    public function generate(): void
    {
        $this->reportType->insertData($this->reportType->process());
    }

    public function updateStatus(): void
    {
        if(!empty($this->reportType->getData())) {
            $this->reportType->updateReportStatus(Report::REPORT_STATUSES['completed']);
        }
    }
}
