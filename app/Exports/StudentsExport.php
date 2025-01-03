<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Student::where('status', 'active')->with(['groups', 'subject'])->get()->map(function ($student) {
            $groupSubjectNames = $student->groups->pluck('subject.name')->unique()->filter()->implode(', ');
            $groupNames = $student->groups->pluck('name')->implode(', ');

            return [
                'id' => $student->id,
                'name' => $student->name,
                'number' => $student->number,
                'parent_name' => $student->parent_name,
                'parent_number' => $student->parent_number,
                'subject' => $groupSubjectNames,
                'groups' => $groupNames,
                'started_date' => $student->started_date,
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
            'Ism familiya',
            'Telefon raqam',
            'Ota-ona ismi',
            'Ota-ona raqami',
            'Fan',
            'Guruh',
            'Boshlagan vaqti',
            'Status',
        ];
    }
}
