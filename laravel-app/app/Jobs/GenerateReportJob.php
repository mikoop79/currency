<?php

namespace App\Jobs;

use App\Models\Report;
use App\Services\ReportGenerate\ReportGenerateService;
use App\Services\ReportGenerate\ReportGenerateStrategy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Report $report;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ReportGenerateService $reportGenerateService)
    {
        /* @var $reportGenerateStrategy ReportGenerateStrategy */
        $reportGenerateStrategy = $reportGenerateService::getReportStrategy($this->report);

        $reportGenerateStrategy->generate();
        $reportGenerateStrategy->updateStatus();


        Log::info('report data count', [count($this->report->data)]);
    }
}
