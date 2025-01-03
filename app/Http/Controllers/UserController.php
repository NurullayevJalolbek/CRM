<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.roles.list', compact('users'))->with('user', auth()->user());
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|same:password_confirmation',
            'roles' => 'required',
            'image' => 'nullable|image',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->subject_id = $request->subject_id;
        $user->number = $request->number;
        $user->password = Hash::make($request->password);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $user->image = 'images/' . $imageName; // This assumes your public disk is set to store images in the 'public' directory
        }

        $user->save();
        $user->assignRole($request->input('roles'));

        return redirect()->route('roles.index')->with('success', 'Account created successfully');
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
    public function edit()
    {
        $subjects = Subject::all();
        return view('admin.settings.index', compact('subjects'))->with('user', auth()->user());
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request)
    {
        // Validate the data submitted by user
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required',
            'number' => 'required',
            'image' => 'nullable|image',

        ]);


        $userDetails = Auth::user();  // To get the logged-in user details
        $user = User::find($userDetails->id);

        if ($user->image) {
            // Delete the existing image
            Storage::delete('public/' . $user->image);
        }

        $user->name = $request->input('name');
        $user->number = $request->input('number');
        $user->email = $request->input('email');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $user->image = 'images/' . $imageName;
        }
        // Save user to database
        $user->save();

        // Redirect to route
        return redirect()->route('user.edit')->with('success', 'Malumotlar muvaffaqiyatli yangilandi');
    }


    public function changePassword()
    {
        return view('admin.settings.password')->with('user', auth()->user());
    }

    public function changePasswordSave(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|confirmed|string',
            'new_password_confirmation' => 'required|same:new_password'
        ]);
        $auth = Auth::user();

        // The passwords matches
        if (!Hash::check($request->get('current_password'), $auth->password)) {
            return back()->with('error', "Hozirgi parol xato kitirildi");
        }

        // Current password and new password same
        if (strcmp($request->get('current_password'), $request->new_password) == 0) {
            return redirect()->back()->with("error", "Yangi parol eskisi bilan bir hil bo'la olmaydi");
        }

        $user =  User::find($auth->id);
        $user->password =  Hash::make($request->new_password);
        $user->save();
        return redirect()->route('user.edit')->with('success', "Parol muvofaqiyatli o'zgartirildi");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        return redirect()->route('roles.index')->with('success', 'Account deleted successfully');
    }
}
