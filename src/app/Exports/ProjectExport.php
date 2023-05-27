<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjectExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Id',
            'Project Name',
            'Project Number',
            'Project Facing',
            'Project Site Measurement',
            'Project Type',
            'Project Room Type',
            'Project Availibility',
            'Created_at',
            'Updated_at'
        ];
    }
    public function map($user): array
    {
         return[
             $user->id,
             $user->name,
             $user->number,
             $user->facing,
             $user->site_measurement,
             $user->project_type->value,
             $user->type->value,
             $user->availibility->value,
             $user->created_at,
             $user->updated_at,
         ];
    }
    public function collection()
    {
        return Project::all();
    }
}
