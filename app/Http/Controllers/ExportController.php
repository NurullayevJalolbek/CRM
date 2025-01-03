<?php

namespace App\Http\Controllers;

use App\Exports\ArchiveGroupsExport;
use App\Exports\archiveStudentExport;
use App\Exports\AttendanceExport;
use App\Exports\GroupsExport;
use App\Exports\passiveStudentExport;
use App\Exports\StudentsExport;
use App\Exports\TeachersExport;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export()
    {
        return Excel::download(new GroupsExport, 'groups.xlsx');
    }

    public function archiveExport()
    {
        return Excel::download(new ArchiveGroupsExport(), 'archive_groups.xlsx');
    }

    public function teacherExport()
    {
        return Excel::download(new TeachersExport(), 'teachers.xlsx');
    }

    public function studentExport()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }

    public function passiveStudentExport()
    {
        return Excel::download(new passiveStudentExport, 'passive-students.xlsx');
    }

    public function archiveStudentExport()
    {
        return Excel::download(new archiveStudentExport, 'archive-students.xlsx');
    }

}
