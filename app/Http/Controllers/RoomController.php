<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'))->with('user', auth()->user());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create')->with('user', auth()->user());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Room::create($validatedData);
        return redirect()->route('rooms.index')->with('success', 'Xona muvaffaqiyatli yaratildi');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $room = Room::find($id);

        if (!$room) {
            return redirect()->route('rooms.index')->with('error', 'Xona topilmadi');
        }

        return view('admin.rooms.show', compact('room'))->with('user', auth()->user());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $room = Room::find($id);

        if (!$room) {
            return redirect()->route('rooms.index')->with('error', 'Xona topilmadi');
        }

        return view('admin.rooms.edit', compact('room'))->with('user', auth()->user());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $room = Room::find($id);

        if (!$room) {
            return redirect()->route('rooms.index')->with('error', 'Xona topilmadi');
        }

        $room->update($validatedData);
        return redirect()->route('rooms.index')->with('success', 'Xona muvaffaqiyatli yangilandi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room = Room::find($id);

        if (!$room) {
            return redirect()->route('rooms.index')->with('error', 'Xona topilmadi');
        }

        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Xona muvaffaqiyatli o\'chirildi');
    }
}
