<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Id',
            'Name',
            'Price',
            'Category',
            'School/Class',
            'Created_at',
            'Updated_at'
        ];
    }
    public function map($data): array
    {
         return[
             $data->id,
             $data->name,
             $data->price,
             $data->category->name,
             $data->schoolAndclass->school->name.' / '.$data->schoolAndclass->class->name,
             $data->created_at,
             $data->updated_at,
         ];
    }
    public function collection()
    {
        return Product::with(['category', 'schoolAndclass'])->get();
    }
}
