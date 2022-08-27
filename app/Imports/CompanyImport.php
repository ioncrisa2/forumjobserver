<?php

namespace App\Imports;

use App\Models\Company;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Validation\Rule;

class CompanyImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function headingRow(): int
    {
        return 5;
    }

    public function model(array $row)
    {
        //insert company data with location data
        $company = Company::create([
            'name' => $row['name'],
            'description' => $row['description'],
            'established' => Carbon::instance(Date::excelToDateTimeObject($row['established'])),
            'website_url' => $row['website_url'],
            'company_field' => $row['company_field'],
        ]);
        //insert location data
        $company->location()->create([
            'street_address' => $row['street_address'],
            'country' => $row['country'],
            'state' => $row['state'],
            'city' => $row['city'],
            'zip_code' => $row['zip_code'],
        ]);

       return $company;
    }

    public function rules(): array
    {
        return[
            '*.name' => Rule::unique('companies','name'),
        ];
    }

    public function customValidationMessages()
    {
        return[
            'name' => 'Company Name is already registerd',
        ];
    }
}
