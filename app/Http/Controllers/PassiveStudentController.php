<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\SocialLink;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class PassiveStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        $groups = Group::all();
        $passiveStudents = Student::where('status', 'passive')->with('subject')->orderByDesc('created_at')->get();
        return view('admin.passive_students.index', compact('passiveStudents', 'groups', 'subjects'))->with('user', auth()->user());
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $socialLinks = SocialLink::all();
        $subjects = Subject::all();
        return view('admin.passive_students.create', compact('socialLinks', 'subjects'))->with('user', auth()->user());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'number' => 'required|string',
            'notes' => 'nullable',
            'social_id' => 'nullable',
            'subject_id' => 'nullable',
        ]);

        $validatedData['status'] = 'passive';

        Student::create($validatedData);

        return redirect()->route('passive-students.index')->with('success', 'Mijoz muvaffaqiyatli yaratildi');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $passiveStudent = Student::findOrFail($id);
        return view('admin.passive_students.show', compact('passiveStudent'))->with('user', auth()->user());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $socialLinks = SocialLink::all();
        $subjects = Subject::all();
        $passiveStudent = Student::findOrFail($id);
        return view('admin.passive_students.edit', compact('passiveStudent', 'subjects', 'socialLinks'))->with('user', auth()->user());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $passiveStudent = Student::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string',
            'number' => 'required|string',
            'social_id' => 'nullable',
            'notes' => 'nullable',
            'subject_id' => 'nullable',
        ]);

        $passiveStudent->update($validatedData);

        return redirect()->route('passive-students.index')->with('success', 'Mijoz muvaffaqiyatli yangilandi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function activation($id)
    {
        $subjects = Subject::all();
        $groups = Group::where('status', 1)->get();
        $passiveStudent = Student::findOrFail($id);
        return view('admin.passive_students.activate', compact('passiveStudent', 'subjects', 'groups'))->with('user', auth()->user());
    }

    public function activate(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required',
        'number' => 'required',
        'parent_name' => 'required',
        'parent_number' => 'required',
        'started_date' => 'required',
        'notes' => 'nullable',
    ]);

    $activeStudent = Student::findOrFail($id);
    $validatedData['status'] = 'active';
    $activeStudent->update($validatedData);

    // Attach the group ID to the student
    $activeStudent->groups()->attach($request->input('group_id'));

    return redirect()->route('passive-students.index')->with('success', 'Mijoz muvaffaqiyatli aktivlantirildi');
}


    public function searchPassiveStudent(Request $request)
    {
        $nameQuery = $request->input('name_query');
        $subjectId = $request->input('subject_id');

        $passiveStudentsQuery = Student::where('status', 'passive'); // Filtering passive students

        if ($nameQuery) {
            $passiveStudentsQuery->where('name', 'like', "%$nameQuery%");
        }

        if ($subjectId) {
            $passiveStudentsQuery->whereHas('subject', function ($query) use ($subjectId) {
                $query->where('id', $subjectId);
            });
        }

        $passiveStudents = $passiveStudentsQuery->get(); // Fetching passive students

        $subjects = Subject::all();
        return view('admin.passive_students.index', compact('passiveStudents', 'subjects'))->with('user', auth()->user());
    }

    public function destroy($id)
    {
        $passiveStudent = Student::findOrFail($id);

        // Deleting the student
        $passiveStudent->delete();

        return redirect()->route('passive-students.index')->with('success', 'Mijoz muvaffaqiyatli o‘chirildi');
    }
}
