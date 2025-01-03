<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class passiveStudentExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Student::where('status', 'passive')->get()->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'number' => $student->number,
                'created_at' => $student->created_at->format('Y.m.d'),
                'status' => $student->status,
            ];
        });
    }

    /**
     * Define the headings for the export file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Number',
            'Created date',
            'Status',
        ];
    }
}
