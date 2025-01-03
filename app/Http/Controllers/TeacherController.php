<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Teacher;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Exports\TeachersExport;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = User::role('teacher')->get();
        return view('admin.teachers.index', compact('teachers'))->with('user', auth()->user());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        $rooms = Room::all();
        return view('admin.teachers.create', compact('subjects', 'rooms'))->with('user', auth()->user());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required',
            'email' => 'required|string|max:255|unique:' . User::class,
            'password' => 'required',
            'subject_id' => 'nullable|exists:subjects,id',
            'room_id' => 'nullable|exists:rooms,id',
            'image' => 'nullable|image',
        ]);


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->subject_id = $request->subject_id;
        $user->room_id = $request->room_id;
        $user->number = $request->number;
        $user->password = Hash::make($request->password);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $user->image = 'images/' . $imageName; // This assumes your public disk is set to store images in the 'public' directory
        }


        $user->save();

        $user->assignRole('teacher');

        return redirect()->route('teachers.index')->with('success', 'Ustoz muvofaqiyatli qo\'shildi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the teacher with their groups and active students
        $teacher = User::with(['groups.students' => function ($query) {
            $query->where('status', 'active');
        }])->findOrFail($id);

        // Count the number of groups assigned to the teacher
        $totalGroupsCount = $teacher->groups()->where('status', 1)->count();

        // Count the number of soft deleted groups assigned to the teacher
        $softDeletedGroupsCount =  $teacher->groups()->where('status', 0)->count();

        // Calculate the total number of active students studying in the groups assigned to the teacher
        $totalActiveStudents = $teacher->groups->flatMap->students->count();

        // Calculate the total number of archived students studying in the groups assigned to the teacher
        $totalArchivedStudents = $teacher->groups->flatMap->students->where('status', 'archive')->count();

        return view('admin.teachers.show', [
            'teacher' => $teacher,
            'totalGroupsCount' => $totalGroupsCount,
            'softDeletedGroupsCount' => $softDeletedGroupsCount,
            'totalActiveStudents' => $totalActiveStudents,
            'totalArchivedStudents' => $totalArchivedStudents,
        ])->with('user', auth()->user());
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subjects = Subject::all();
        $rooms = Room::all();
        $teacher = User::findOrFail($id);
        return view('admin.teachers.edit', compact('teacher', 'subjects', 'rooms'))->with('user', auth()->user());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|max:255',
            'subject_id' => 'nullable|exists:subjects,id',
            'room_id' => 'nullable|exists:rooms,id',
            'number' => 'nullable|string|max:255',
            'image' => 'nullable|image',
        ]);


        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'subject_id' => $request->subject_id,
            'room_id' => $request->room_id,
            'number' => $request->number,
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $user->image = 'images/' . $imageName;
        }

        // Save the changes to the user
        $user->save();

        // You can remove this line if you want to keep existing roles
        $user->roles()->detach();

        // Assign the teacher role
        $user->assignRole('teacher');

        return redirect()->route('teachers.index')->with('success', 'Ustoz muvofaqiyatli yangilandi');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('teachers.index')->with('success', 'Ustoz muvofaqiyatli o\'chirildi');
    }

    public function searchTeacher(Request $request)
    {
        $query = $request->input('query');

        $teachers = User::role('teacher');
        if ($query) {
            $teachers->where('name', 'like', "%$query%");
        }

        $teachers = $teachers->get();

        return view('admin.teachers.index', compact('teachers'))->with('user', auth()->user());
    }
}
