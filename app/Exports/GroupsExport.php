<?php

namespace App\Exports;

use App\Models\Group;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GroupsExport implements FromCollection, WithHeadings
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Group::where('status', 1)->with('subject')->get()->map(function ($group) {
            return [
                'id' => $group->id,
                'name' => $group->name,
                'price' => number_format($group->price, 0, ',', ' ') . ' so\'m',
                'user_id' => $group->user->name,
                'subject_id' => $group->subject->name,
                'started_date' => $group->started_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'id',
            'Name',
            'Price',
            'Teacher',
            'Subject',
            'Started date',
        ];
    }
}
