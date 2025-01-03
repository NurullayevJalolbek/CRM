<?php

namespace App\Exports;

use App\Models\Group;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArchiveGroupsExport implements FromCollection, WithHeadings
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Group::where('status', 0)
            ->with('subject')
            ->get()
            ->map(function ($group) {
                return [
                    'id' => $group->id,
                    'name' => $group->name,
                    'price' => number_format($group->price, 0, ',', ' ') . ' so\'m',
                    'user_id' => $group->user->name,
                    'subject' => $group->subject ? $group->subject->name : '',
                    'started_date' => $group->started_date,
                    'archived_at' => $group->archived_at ? date('Y.m.d', strtotime($group->archived_at)) : '',
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
            'Finished date',
        ];
    }
}
