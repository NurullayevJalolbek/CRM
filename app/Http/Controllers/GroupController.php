<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;



class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
         $groups = Group::where('status', 1)
             ->orderByDesc('created_at') // Order groups by creation date in descending order
             ->get();

         $groups->each(function ($group) {
             $group->numberOfStudents = $group->students()->where('status', 'active')->count();
         });

         return view('admin.groups.index', compact('groups'))->with('user', auth()->user());
     }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        $teachers = User::role('Teacher')->get();

        return view('admin.groups.create', compact('subjects', 'teachers'))->with('user', auth()->user());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        // dd($request->all());
        // Validate the incoming request
        $validatedData = $request->validated();

        $validatedData['created_by'] = auth()->id();

        // Create a new group with the validated data
        Group::create($validatedData);

        // Redirect to the index page with a success message
        return redirect()->route('groups.index')->with('success', 'Guruh muvaffaqiyatli yaratildi');
    }

    public function show(string $id, Request $request)
    {
        $group = Group::findOrFail($id);

        $monthNames = [
            1 => 'Yanvar', 2 => 'Fevral', 3 => 'Mart', 4 => 'Aprel',
            5 => 'May', 6 => 'Iyun', 7 => 'Iyul', 8 => 'Avgust',
            9 => 'Sentyabr', 10 => 'Oktyabr', 11 => 'Noyabr', 12 => 'Dekabr'
        ];

        $selectedMonth = [
            'year' => $request->input('year'),
            'month' => $request->input('month'),
        ];

        if (isset($selectedMonth['month']) && $selectedMonth['month'] !== '') {
            $monthName = $monthNames[$selectedMonth['month']];
        } else {
            // Handle the case where the 'month' key is not set or empty
            $monthName = 'Unknown'; // You can set a default value or handle the error accordingly
        }

        // Retrieve distinct attendance dates for the selected year and month
        $distinctDates = Attendance::where('group_id', $group->id)
            ->whereYear('attendance_date', $selectedMonth['year'])
            ->whereMonth('attendance_date', $selectedMonth['month'])
            ->pluck('attendance_date')
            ->unique()
            ->sort()
            ->toArray();

        // Fetch active students belonging to the group
        $students = [];
        if ($group->id && $selectedMonth['year'] && $selectedMonth['month']) {
            $students = $group->students()
                            ->where('status', 'active')
                            ->get();
        }

        $student = Student::first();
        $payments = Payment::where('group_id', $id)->latest()->paginate(20);
        return view('admin.groups.show', compact('group', 'students', 'distinctDates', 'selectedMonth', 'monthName', 'payments', 'student'))->with('user', auth()->user());
    }


    public function archiveShow(string $id, Request $request)
    {
        $group = Group::findOrFail($id);

        $monthNames = [
            1 => 'Yanvar', 2 => 'Fevral', 3 => 'Mart', 4 => 'Aprel',
            5 => 'May', 6 => 'Iyun', 7 => 'Iyul', 8 => 'Avgust',
            9 => 'Sentyabr', 10 => 'Oktyabr', 11 => 'Noyabr', 12 => 'Dekabr'
        ];

        $selectedMonth = [
            'year' => $request->input('year'),
            'month' => $request->input('month'),
        ];

        if (isset($selectedMonth['month']) && $selectedMonth['month'] !== '') {
            $monthName = $monthNames[$selectedMonth['month']];
        } else {
            // Handle the case where the 'month' key is not set or empty
            $monthName = 'Unknown'; // You can set a default value or handle the error accordingly
        }

        // Retrieve distinct attendance dates for the selected year and month
        $distinctDates = Attendance::where('group_id', $group->id)
            ->whereYear('attendance_date', $selectedMonth['year'])
            ->whereMonth('attendance_date', $selectedMonth['month'])
            ->pluck('attendance_date')
            ->unique()
            ->sort()
            ->toArray();

        // Fetch students belonging to the group
        $students = [];
        if ($group->id && $selectedMonth['year'] && $selectedMonth['month']) {
            $students = $group->students()->get();
        }

        $student = Student::first();
        $payments = Payment::where('group_id', $id)->latest()->paginate(20);
        return view('admin.groups.archiveShow', compact('group', 'students', 'distinctDates', 'selectedMonth', 'monthName', 'payments', 'student'))->with('user', auth()->user());
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subjects = Subject::all();
        $teachers = User::role('teacher')->get();
        $group = Group::where('status', 1)->findOrFail($id);
        return view('admin.groups.edit', compact('group', 'subjects', 'teachers'))->with('user', auth()->user());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, string $id)
    {
        $group = Group::findOrFail($id);

        // Validate the incoming request
        $validatedData = $request->validated();

        // Update the group with the validated data
        $group->update($validatedData);

        // Redirect to the index page with a success message
        return redirect()->route('groups.index')->with('success', 'Guruh muvaffaqiyatli yangilandi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::findOrFail($id);

        // Get all students of the group
        $students = $group->students;

        // Check if any student is assigned to only one group
        $studentsWithSingleGroup = $students->filter(function ($student) {
            return $student->groups->count() === 1;
        });

        // Update status to 'archive' only for students with a single group assignment
        $studentsWithSingleGroup->each(function ($student) {
            $student->update(['status' => 'archive']);
        });

        $group->status = 0;
        $group->archived_at = now();
        $group->save();

        return redirect()->route('groups.index')->with('success', 'Guruh muvaffaqiyatli o\'chirildi');
    }




    public function archive()
    {
        $groups = Group::where('status', 0)->get();
        return view('admin.groups.archive', compact('groups'))->with('user', auth()->user());
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Perform the search using the query
        $groups = Group::where('status', 1)
            ->where('name', 'like', "%$query%")
            ->get();

        // Pass the search results to the view
        return view('admin.groups.index', compact('groups'))->with('user', auth()->user());
    }
}
