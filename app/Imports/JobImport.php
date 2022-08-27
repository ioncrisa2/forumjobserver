<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Jobs;
use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class JobImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function headingRow(): int
    {
        return 5;
    }

    public function model(array $row)
    {
        // dd($this->getCompanyId($row['company']));

        $jobs = Jobs::create([
            'user_id' => auth('api')->user()->id,
            'company_id' => $this->getCompanyId($row['company']),
            'job_name' => $row['job_name'],
            'job_description' => $row['job_description'],
            'job_type' => $row['job_type'],
            'end_date' => $this->getEndDate($row['end_date']),
        ]);

        return $jobs;
    }

    private function getEndDate($date){
        return Carbon::instance(Date::excelToDateTimeObject($date));
    }

    private function getCompanyId($company)
    {
        $companyList = Company::select('id', 'name')->get();
        //insert company list to a new array
        $name = $companyList->where('name',$company)->first();
        return $name->id;
    }

    public function rules(): array
    {
        return [
            'company'           => 'required',
            'job_name'          => 'required',
            'job_description'   => 'required',
            'job_type'          => 'required',
            'end_date'          => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'company.required'          => 'Company is required',
            'job_name.required'         => 'Job name is required',
            'job_description.required'  => 'Job description is required',
            'job_type.required'         => 'Job type is required',
            'end_date.required'         => 'End date is required',
        ];
    }

}
