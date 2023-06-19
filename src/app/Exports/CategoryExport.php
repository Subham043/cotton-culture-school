<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoryExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Id',
            'Name',
            'Created_at',
            'Updated_at'
        ];
    }
    public function map($data): array
    {
         return[
             $data->id,
             $data->name,
             $data->created_at,
             $data->updated_at,
         ];
    }
    public function collection()
    {
        return Category::all();
    }
}
