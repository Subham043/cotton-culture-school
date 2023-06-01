<?php

namespace App\Exports;

use App\Models\School;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SchoolExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Id',
            'Name',
            'Submission End Date',
            'Created_at',
            'Updated_at'
        ];
    }
    public function map($data): array
    {
         return[
             $data->id,
             $data->name,
             $data->submission_end_date,
             $data->created_at,
             $data->updated_at,
         ];
    }
    public function collection()
    {
        return School::all();
    }
}
