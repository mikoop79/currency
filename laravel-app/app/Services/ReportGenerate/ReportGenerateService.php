<?php


namespace App\Services\ReportGenerate;

use App\Models\Report;
use App\Services\ReportGenerate\ReportTypes\Report1;
use App\Services\ReportGenerate\ReportTypes\Report2;
use App\Services\ReportGenerate\ReportTypes\Report3;

class ReportGenerateService
{


    /**
     * @param Report $report
     * @return ReportGenerateStrategy|null
     */
    public static function getReportStrategy(Report $report): ?ReportGenerateStrategy
    {
        $reportGeneratorType = null;

        switch ($report->type)
        {
            case 1  :
                $reportGeneratorType = new ReportGenerateStrategy(new Report1($report));
                break;
            case 2 :
                $reportGeneratorType = new ReportGenerateStrategy(new Report2($report));
                break;
            case 3 :
                $reportGeneratorType = new ReportGenerateStrategy(new Report3($report));
                break;

        }

        return $reportGeneratorType;
    }
}
