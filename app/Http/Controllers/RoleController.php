<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.roles.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('admin.roles.create', compact('subjects'))->with('user', auth()->user());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:' . User::class,
            'password' => 'required',
            'role' => 'required|in:admin,teacher,supperadmin',
            'subject_id' => 'nullable|exists:subjects,id',
            'number' => 'required',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject_id' => $request->subject_id,
            'number' => $request->number,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('roles.index')->with('success', 'Xodim muvaffaqiyatli yaratildi');
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
        $user = User::findOrFail($id);
        $subjects = Subject::all();
        return view('admin.roles.edit', compact('user', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required',
            'subject_id' => 'nullable|exists:subjects,id',
            'number' => 'nullable|string|max:255',
            'image' => 'nullable|image',

        ]);

        if ($user->image) {
            // Delete the existing image
            Storage::delete('public/' . $user->image);
        }

        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'subject_id' => $request->subject_id,
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

        $user->roles()->detach();

        $user->assignRole($request->role);

        return redirect()->route('roles.index')->with('success', 'Xodim muvaffaqiyatli yangilandi');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('roles.index')->with('success', 'Xodim muvaffaqiyatli o\'chirildi');
    }
}
