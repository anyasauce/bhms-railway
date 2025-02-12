<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Boarder;
use Illuminate\Http\Request;
date_default_timezone_set('Asia/Manila');

class RoomsController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function displayRooms()
    {
        $rooms = Room::all();
        return view('main.room', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_name' => 'required|string|max:255',
            'slots' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'room_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('room_image')) {
            $roomFolder = 'rooms/' . strtolower(str_replace(' ', '_', $validatedData['room_name']));
            $imageName = 'room.png';

            $imagePath = $request->file('room_image')->storeAs($roomFolder, $imageName, 'public');
        }

        Room::create([
            'room_name' => $validatedData['room_name'],
            'slots' => $validatedData['slots'],
            'price' => $validatedData['price'],
            'room_image' => 'room.png',
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully');
    }


    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'room_name' => 'required|string|max:255',
            'slots' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'room_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $room = Room::findOrFail($id);

        if ($request->hasFile('room_image')) {
            $roomFolder = 'rooms/' . strtolower(str_replace(' ', '_', $validatedData['room_name']));
            $imageName = 'room.png';

            $request->file('room_image')->storeAs($roomFolder, $imageName, 'public');

            $room->room_image = $imageName;
        }

        $room->update([
            'room_name' => $validatedData['room_name'],
            'slots' => $validatedData['slots'],
            'price' => $validatedData['price'],
            'room_image' => $room->room_image,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully');
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        $boarders = $room->boarders;

        return view('rooms.show', compact('room', 'boarders'));
    }
}
