<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'price',
        'subject_id',
        'user_id',
        'created_by',
        'started_date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'group_student');
    }


    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($group) {
            $group->status = 0;
            $group->save();
        });
    }


    public function attendancePercentage($selectedMonth, $selectedYear)
    {
        // Retrieve attendance records for the student in the selected group and month
        $attendances = $this->attendances()
            ->whereYear('attendance_date', $selectedMonth)
            ->whereMonth('attendance_date', $selectedYear)
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
