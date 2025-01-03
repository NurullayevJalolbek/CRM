<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class archiveStudentExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Student::where('status', 'archive')->with(['group', 'subject'])->get()->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'number' => $student->number,
                'subject' => $student->subject->name,
                'group' => optional($student->group)->name,
                'parent_name' => $student->parent_name,
                'parent_number' => $student->parent_number,
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
            'Name',
            'Number',
            'Subject',
            'Group',
            'Parent Name',
            'Parent Number',
            'Started Date',
            'Status',
        ];
    }
}
