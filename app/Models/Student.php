<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'number',
        'parent_name',
        'parent_number',
        'started_date',
        'birthday',
        'subject_id',
        'social_id',
        'status',
        'payment_status',
        'notes',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_student');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function social_links()
    {
        return $this->belongsTo(SocialLink::class, 'social_id');
    }


    public function attendanceDates()
    {
        // Eager load the attendances relationship
        $this->load('attendances');

        // Extract the attendance dates if attendances are loaded
        if ($this->relationLoaded('attendances')) {
            return $this->attendances->pluck('attendance_date')->toArray();
        } else {
            return [];
        }
    }



    public function attendancePercentage($selectedGroup, $selectedMonth)
    {
        // Retrieve attendance records for the student in the selected group and month
        $attendances = $this->attendances()
            ->where('group_id', $selectedGroup->id)
            ->whereYear('attendance_date', $selectedMonth['year'])
            ->whereMonth('attendance_date', $selectedMonth['month'])
            ->get();

        // Count total attendance records and present attendance records
        $totalAttendanceRecords = $attendances->count();
        $presentAttendanceRecords = $attendances->where('status', true)->count();

        // Calculate the attendance percentage for the selected group and month
        if ($totalAttendanceRecords > 0) {
            $attendancePercentage = ($presentAttendanceRecords / $totalAttendanceRecords) * 100;
        } else {
            $attendancePercentage = 0; // Default to 0 if there are no attendance records
        }

        // Format the attendance percentage with one decimal point
        $formattedPercentage = number_format($attendancePercentage);

        return $formattedPercentage;
    }




    /**
     * Define a relationship with the Attendance model.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
