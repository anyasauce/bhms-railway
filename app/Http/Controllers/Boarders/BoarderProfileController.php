<?php

namespace App\Http\Controllers\Boarders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BoarderProfileController extends Controller
{
    public function show()
    {
        $boarder = Auth::user();
        return view('boarders.profile', compact('boarder'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8',
        ]);

        $boarder = Auth::user();
        $boarder->first_name = $request->first_name;
        $boarder->last_name = $request->last_name;
        $boarder->email = $request->email;

        if ($request->filled('password')) {
            $boarder->password = Hash::make($request->password);
        }

        $boarder->save();
        return redirect()->route('boarders.profile')->with('success', 'Boarders Profile updated successfully.');
    }

}
