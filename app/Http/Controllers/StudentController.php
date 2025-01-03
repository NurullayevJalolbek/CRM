<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use App\Models\Group;
use App\Models\Payment;
use App\Models\Subject;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        $groups = Group::where('status', 1)->get();
        $students = Student::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(40);
        return view('admin.students.index', compact('students', 'subjects', 'groups'))->with('user', auth()->user());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::with('groups')->get();
        $groups = Group::where('status', 1)->get();
        return view('admin.students.create', compact('subjects', 'groups'))->with('user', auth()->user());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['status'] = 'active';

        // Create a new student
        $student = Student::create($validatedData);

        // Attach the student to the groups
        $student->groups()->attach($request->input('group_id'));

        return redirect()->route('students.index')->with('success', 'Talaba muvaffaqiyatli yaratildi');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::findOrFail($id);
        $payments = Payment::where('student_id', $id)->latest()->paginate(20);;
        return view('admin.students.show', compact('student', 'payments'))->with('user', auth()->user());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subjects = Subject::all();
        $groups = Group::where('status', 1)->get();
        $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student', 'subjects', 'groups'))->with('user', auth()->user());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, $id)
    {
        // Find the student by their ID
        $student = Student::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validated();

        // Update the student's basic information
        $student->update([
            'name' => $validatedData['name'],
            'number' => $validatedData['number'],
            'parent_name' => $validatedData['parent_name'],
            'parent_number' => $validatedData['parent_number'],
            'started_date' => $validatedData['started_date'],
            'notes' => $validatedData['notes'],
            'status' => 'active',
        ]);

        // Sync the student's groups based on the input
        $student->groups()->sync($request->input('group_id'));

        // Redirect to the appropriate route with a success message
        return redirect()->route('students.index')->with('success', 'Talaba muvaffaqiyatli yangilandi');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->status = 'archive';
        $student->archived_at = Carbon::now();
        $student->save();
        return redirect()->route('students.index')->with('success', 'Talaba muvaffaqiyatli o\'chirildi');
    }



    public function searchStudent(Request $request)
    {
        $nameQuery = $request->input('name_query');
        $groupId = $request->input('group_id');
        $subject_id = $request->input('subject_id');
        $createdDate = $request->input('createdDate');  // Get the created date input


        // Start with an instance of the Student model
        $studentsQuery = Student::where('status', 'active');

        // Filter by name if provided
        if ($nameQuery) {
            $studentsQuery->where('name', 'like', "%$nameQuery%");
        }

        // Filter by group if provided
        if ($groupId) {
            // Assuming 'group_student' is the pivot table name
            $studentsQuery->whereHas('groups', function ($query) use ($groupId) {
                $query->where('groups.id', $groupId)
                    ->where('groups.status', 1);
            });
        }

        // Filter by subject_id via group
        if ($subject_id) {
            $studentsQuery->whereHas('groups', function ($query) use ($subject_id) {
                $query->where('subject_id', $subject_id);
            });
        }

        // Filter by archived_date (in YYYY-MM format)
        if ($createdDate) {
            $year = substr($createdDate, 0, 4); // Extract the year (YYYY)
            $month = substr($createdDate, 5, 2); // Extract the month (MM)

            $studentsQuery->whereYear('created_at', $year)  // Filter by year
                ->whereMonth('created_at', $month);  // Filter by month
        }

        // Paginate the query results
        $students = $studentsQuery->paginate(50);
        $subjects = Subject::all();
        $groups = Group::where('status', 1)->get();

        return view('admin.students.index', compact('students', 'groups', 'subjects'))->with('user', auth()->user());
    }
}
