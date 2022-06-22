<?php

namespace App\Console\Commands;

use App\Jobs\GenerateReportJob;
use App\Models\Report;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class collectJobsToGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:collect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collect the jobs to Generate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle()
    {
        // get any reports with status pending..
        $reports = Report::where('status_id', Report::REPORT_STATUSES['pending'])->get();

        if (empty( $reports->count()) ){
            Log::stack(['stdout'])->info('No jobs to generate.');
            return false;
        }

        foreach ($reports as $report){
            GenerateReportJob::dispatch($report);
        }

        Log::stack(['stdout'])->info(sprintf('%s report/s generated', $reports->count()), []);

        return true;
    }
}
