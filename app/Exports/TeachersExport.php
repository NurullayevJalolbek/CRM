<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeachersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Retrieve users with the teacher role
        $teachers = User::role('teacher')->with('subject')->get();

        // Map the users to the desired format for export
        return $teachers->map(function ($teacher) {
            return [
                'ID' => $teacher->id,
                'Ism familiya ' => $teacher->name,
                'Telefon raqam' => $teacher->number,
                'Email' => $teacher->email,
                'Fan' => optional($teacher->subject)->name,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Ism familiya',
            'Telefon raqam',
            'Email',
            'Fan',
        ];
    }
}
