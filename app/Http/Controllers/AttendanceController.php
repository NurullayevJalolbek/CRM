<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Group;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $groupId = $request->input('group_id');
    $attendanceDate = $request->input('attendance_date');

    // Validate attendance date format
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $attendanceDate)) {
        // Convert to 'YYYY-MM' format for payment month
        $selectedDate = Carbon::createFromFormat('Y-m-d', $attendanceDate);
        $paymentMonth = $selectedDate->format('Y-m');
    } else {
        $paymentMonth = null; // Handle invalid date format
    }

    // Fetch all subjects
    $subjects = Subject::all();

  // Fetch groups based on user role
        $user = auth()->user();
        $groups = $user->hasRole('Teacher') 
            ? $user->groups()->where('status', 1)->with('user')->orderBy('name')->get() // Only groups for the teacher
            : Group::where('status', 1)
                ->leftJoin('users', 'groups.user_id', '=', 'users.id') 
                ->orderBy('users.name') 
                ->orderBy('groups.name')
                ->select('groups.*')
                ->with('user')
                ->get(); // All groups for admin/super admin

    // Fetch students assigned to the selected group
    $students = Student::where('status', 'active')->whereHas('groups', function ($query) use ($groupId) {
        $query->where('id', $groupId);
    })->get();

    // Fetch attendance data and group by student
    $attendance = Attendance::where('group_id', $groupId)
        ->where('attendance_date', $attendanceDate)
        ->get()
        ->groupBy('student_id')
        ->map(function ($attendances) {
            return $attendances->pluck('status', 'attendance_date')->toArray();
        })->toArray();

    // Get the group instance and fetch the price
    $group = Group::find($groupId);

    // Get group price or default to 0 if group not found
    $groupPrice = $group ? $group->price : 0;

    return view('admin.attendance.index', compact('subjects', 'groups', 'students', 'groupId', 'attendanceDate', 'attendance', 'paymentMonth', 'groupPrice'))->with('user', auth()->user());
}



    public function store(Request $request)
    {
        $subjects = Subject::all();

        // Validate the request data
        $validatedData = $request->validate([
            'group_id' => 'required',
            'attendance_date' => 'required|date',
            'created_by' => 'required|exists:users,id',
        ]);

        // Get the attendance data from the request
        $attendanceData = $request->input('attendance');

        foreach ($attendanceData as $studentId => $attendanceDateStatus) {
            foreach ($attendanceDateStatus as $date => $status) {
                // Convert 1 to true, 0 to false for status
                $status = $status == 1 ? true : false;

                // Find the existing attendance record for the student and date
                $existingAttendance = Attendance::where([
                    'group_id' => $request->group_id,
                    'student_id' => $studentId,
                    'attendance_date' => $date,
                ])->first();

                if ($existingAttendance) {
                    // If an attendance record exists, update it with the new status
                    $existingAttendance->status = $status;
                    $existingAttendance->save();
                } else {
                    // If no attendance record exists, create a new one
                    Attendance::create([
                        'group_id' => $request->group_id,
                        'student_id' => $studentId,
                        'attendance_date' => $date,
                        'status' => $status,
                        'created_by' => $request->created_by,
                    ]);

                }
            }
        }

        // Redirect back with success message
        return back()->with('success', 'Davomat muvaffaqiyatli qayd etildi');
    }


   public function report(Request $request)
{
    $subjects = Subject::all();
    
 // Fetch groups based on user role
        $user = auth()->user();
        $groups = $user->hasRole('Teacher')
            ? $user->groups()->where('status', 1)->with('user')->orderBy('name')->get() // Only groups for the teacher
            : Group::where('status', 1)
                ->with('user')
                ->join('users', 'groups.user_id', '=', 'users.id')
                ->orderBy('users.name')
                ->orderBy('groups.name')
                ->select('groups.*')
                ->get(); // All groups for admin/super admin

    $monthNames = [
        1 => 'Yanvar', 2 => 'Fevral', 3 => 'Mart', 4 => 'Aprel',
        5 => 'May', 6 => 'Iyun', 7 => 'Iyul', 8 => 'Avgust',
        9 => 'Sentyabr', 10 => 'Oktyabr', 11 => 'Noyabr', 12 => 'Dekabr'
    ];

    $selectedMonth = [
        'year' => $request->input('year'),
        'month' => $request->input('month'),
    ];

    // Retrieve the month name
    $selectedMonthName = '';
    if (isset($selectedMonth['month']) && isset($monthNames[$selectedMonth['month']])) {
        $selectedMonthName = $monthNames[$selectedMonth['month']];
    }

    // Retrieve selected group ID from the request
    $selectedGroupId = $request->input('group_id');
    $selectedGroup = Group::find($selectedGroupId);

    // Fetch students belonging to the selected group
    $students = Student::where('status', 'active')->whereHas('groups', function ($query) use ($selectedGroupId) {
        $query->where('id', $selectedGroupId);
    })->get();

    // Fetch attendance records for the selected group, year, and month
    $attendances = Attendance::where('group_id', $selectedGroupId)
        ->whereYear('attendance_date', $request->input('year'))
        ->whereMonth('attendance_date', $request->input('month'))
        ->get();

    // Retrieve distinct dates from attendance records
    $distinctDates = $attendances->pluck('attendance_date')->unique()->toArray();
    sort($distinctDates);

    return view('admin.attendance.report', compact('attendances', 'subjects', 'groups', 'students', 'distinctDates', 'selectedMonth', 'selectedGroup', 'selectedMonthName', 'selectedGroupId'))->with('user', auth()->user());
}

public function downloadPdfReport(Request $request)
    {
        // Validate the input
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'year' => 'required|integer|min:2022|max:' . now()->year,
            'month' => 'required|integer|min:1|max:12',
        ]);
    
        // Fetch the required group and month details
        $selectedGroupId = $request->input('group_id');
        $selectedMonth = [
            'year' => $request->input('year'),
            'month' => $request->input('month'),
        ];
    
        // Month names array for displaying in report
        $monthNames = [
            1 => 'Yanvar', 2 => 'Fevral', 3 => 'Mart', 4 => 'Aprel',
            5 => 'May', 6 => 'Iyun', 7 => 'Iyul', 8 => 'Avgust',
            9 => 'Sentyabr', 10 => 'Oktyabr', 11 => 'Noyabr', 12 => 'Dekabr'
        ];
    
        $selectedMonthName = $monthNames[$selectedMonth['month']] ?? '';
    
        // Retrieve the selected group
        $selectedGroup = Group::with('user')->findOrFail($selectedGroupId);
    
        // Fetch active students in the selected group
        $students = Student::where('status', 'active')
            ->whereHas('groups', function ($query) use ($selectedGroupId) {
                $query->where('id', $selectedGroupId);
            })
            ->orderBy('name', 'asc')
            ->get();
    
        // Fetch attendance records for the selected group, month, and year
        $attendances = Attendance::where('group_id', $selectedGroupId)
            ->whereYear('attendance_date', $selectedMonth['year'])
            ->whereMonth('attendance_date', $selectedMonth['month'])
            ->get();
    
        // Get unique attendance dates for this month
        $distinctDates = $attendances->pluck('attendance_date')->unique()->sort()->toArray();
    
        // Calculate each student's attendance percentage and relevant info
        foreach ($students as $student) {
            $studentAttendance = $attendances->where('student_id', $student->id);
            $presentDays = $studentAttendance->where('status', 1)->count();
            $totalDays = count($distinctDates);
            $student->attendance_percentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 2) : 0;
        }
    
        // Load the PDF view, passing necessary data
        $pdf = Pdf::loadView('admin.attendance.pdf-report', compact(
            'students', 'distinctDates', 'selectedMonth', 'selectedMonthName', 'selectedGroup'
        ))->setPaper('a4', 'landscape');  // Set A4 paper and landscape orientation
    
        // Stream the PDF for download
        return $pdf->download('attendance-report-' . $selectedGroup->name . '-' . $selectedMonthName . '.pdf');
    }

}
