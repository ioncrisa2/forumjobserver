<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class CompaniesExport implements FromCollection, WithCustomStartCell, WithHeadings
{
    use Exportable;

    public function collection()
    {
        return DB::table('companies')->select('name','description','established','website_url','company_field')->get();
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            'Name',
            'Description',
            'Established',
            'Website URL',
            'Company Field'
        ];
    }
}


