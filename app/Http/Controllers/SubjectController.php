<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();
        return view('admin.subjects.index', compact('subjects', 'teachers'))->with('user', auth()->user());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.create')->with('user', auth()->user());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        $validatedData = $request->validated();
        Subject::create($validatedData);
        return redirect()->route('subjects.index')->with('success', 'Yangi fan muvofaqiyatli yaratildi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subject = Subject::with('groups')->findOrFail($id);
        $groups = $subject->groups()->where('status', 1)->get()->toArray();
        return response()->json($groups);
    }

    public function showHtml(string $id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.subjects.show', compact('subject'))->with('user', auth()->user());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.subjects.edit', compact('subject'))->with('user', auth()->user());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, string $id)
    {
        $subject = Subject::findOrFail($id);
        $validatedData = $request->validated();
        $subject->update($validatedData);
        return redirect()->route('subjects.index')->with('success', 'Fan muvofaqiyatli yangilandi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Fan muvofaqiyatli o\'chirildi');
    }

    public function searchSubject(Request $request)
    {
        $query = $request->input('query');
        $subjects = Subject::where('name', 'like', "%$query%")->get();
        return view('admin.subjects.index', compact('subjects'))->with('user', auth()->user());
    }
}
