<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Id',
            'Name',
            'Email',
            'Phone',
            'Created_at',
            'Updated_at'
        ];
    }
    public function map($user): array
    {
         return[
             $user->id,
             $user->name,
             $user->email,
             $user->phone,
             $user->created_at,
             $user->updated_at,
         ];
    }
    public function collection()
    {
        return Client::all();
    }
}
