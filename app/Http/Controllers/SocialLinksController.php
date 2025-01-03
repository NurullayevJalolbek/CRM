<?php

namespace App\Http\Controllers;

use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $socialLinks = SocialLink::all();
        return view('admin.social_links.index', compact('socialLinks'))->with('user', auth()->user());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.social_links.create')->with('user', auth()->user());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $socialLink = SocialLink::create($validatedData);
        return redirect()->route('socialLinks.index')->with('success', 'Social link muvaffaqiyatli yaratildi');
    }

    public function destroy($id)
    {
        $socialLink = SocialLink::find($id);
    
        if (!$socialLink) {
            return redirect()->route('socialLinks.index')->with('error', 'Mavjud emas');
        }
    
        $socialLink->delete();
    
        return redirect()->route('socialLinks.index')->with('success', 'Social link muvaffaqiyatli o\'chirildi');
    }
}
