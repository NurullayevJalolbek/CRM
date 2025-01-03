<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ArchiveStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        $students = Student::where('status', 'archive')->orderByDesc('archived_at') // Order groups by creation date in descending order
        ->get();
        return view('admin.archive_students.index', compact('students', 'subjects'))->with('user', auth()->user());
    }

public function searchArchiveStudent(Request $request)
{
    $nameQuery = $request->input('name_query');
    $subject_id = $request->input('subject_id');
    $archivedDate = $request->input('archived_date');  // Get the archived date input

    // Query for archived students
    $studentsQuery = Student::where('status', 'archive');

    // Filter by name
    if ($nameQuery) {
        $studentsQuery->where('name', 'like', "%$nameQuery%");
    }

    // Filter by subject_id via group
    if ($subject_id) {
        $studentsQuery->whereHas('groups', function ($query) use ($subject_id) {
            $query->where('subject_id', $subject_id);
        });
    }

    // Filter by archived_date (in YYYY-MM format)
    if ($archivedDate) {
        $year = substr($archivedDate, 0, 4); // Extract the year (YYYY)
        $month = substr($archivedDate, 5, 2); // Extract the month (MM)

        $studentsQuery->whereYear('archived_at', $year)  // Filter by year
                       ->whereMonth('archived_at', $month);  // Filter by month
    }

    $students = $studentsQuery->get();

    // Fetch all subjects for the dropdown
    $subjects = Subject::all();

    return view('admin.archive_students.index', compact('students', 'subjects'))->with('user', auth()->user());
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
