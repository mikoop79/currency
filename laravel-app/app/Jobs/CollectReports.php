<?php

namespace App\Jobs;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CollectReports implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get any reports with status pending..
        $reports = Report::where('status_id', Report::REPORT_STATUSES['pending'])->get();

        if (empty($reports) ) {
            Log::info('No jobs to generate.');
            return;
        }

        foreach ($reports as $report){
            GenerateReportJob::dispatch($report);
        }
    }
}
