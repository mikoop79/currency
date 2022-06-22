<?php


namespace App\Contracts;



use Illuminate\Support\Carbon;

interface ReportTypeInterface
{
    public function process():array;
    public function getCarbonInterval():string;
    public function getStartDate(): Carbon;
    public function insertData(array $data);

}
