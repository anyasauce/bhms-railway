<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Boarder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
date_default_timezone_set('Asia/Manila');
use Illuminate\Support\Str;
use App\Models\Documents;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Referral;
class BoarderController extends Controller
{
    public function show($id)
    {
        $room = Room::with('boarders')->find($id);

        if (!$room) {
            return abort(404, 'Room not found');
        }

        $boarders = $room->boarders;

        return view('boarder.index', compact('room', 'boarders'));
    }

    public function index()
    {
        $rooms = Room::all();

        $boarders = Boarder::with(['documents', 'referrals.application'])->get();

        foreach ($boarders as $boarder) {
            $boarder->referredPeople = Referral::where('referrer_id', $boarder->boarder_id)
                ->with('application')
                ->get();

            $boarder->totalReferrals = $boarder->referredPeople->count();
            $boarder->totalPoints = $boarder->referredPeople->sum('points');
        }

        return view('boarders.index', compact('boarders', 'rooms'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:boarders,email',
            'guardian_name' => 'required',
            'guardian_phone_number' => 'required',
            'address' => 'required',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $room = Room::find($request->room_id);
        if (!$room || $room->slots <= 0) {
            return redirect()->route('boarders.index')->with('error', 'The selected room has no available slots.');
        }

        $boarder_id = 'B-' . strtoupper(Str::random(6));
        $password = $request->last_name;

        do {
            $referral_code = 'BH' . mt_rand(1000, 9999);
        } while (Boarder::where('referral_code', $referral_code)->exists());

        $boarder = Boarder::create([
            'boarder_id' => $boarder_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make($password),
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'guardian_name' => $request->guardian_name,
            'guardian_phone_number' => $request->guardian_phone_number,
            'address' => $request->address,
            'room_id' => $request->room_id,
            'referral_code' => $referral_code,
        ]);

        $room->slots -= 1;
        if ($room->slots == 0) {
            $room->status = 'occupied';
        }
        $room->save();

        $this->sendWelcomeEmail($boarder->email, $boarder->first_name, $password);

        return redirect()->route('boarders.index')->with('success', 'Boarder added successfully with referral code and email sent.');
    }


    private function sendWelcomeEmail($email, $first_name, $password)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('josiahdanielle09gallenero@gmail.com', 'Admin');
            $mail->addAddress($email, $first_name);

            $mail->isHTML(true);
            $mail->Subject = 'Welcome to the Boarding House Management System';
            $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        font-family: 'Arial', sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f4f4f4;
                        width: 100%;
                        height: 100%;
                    }
                    .container {
                        width: 100%;
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #ffffff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    }
                    .header {
                        text-align: center;
                        padding-bottom: 20px;
                    }
                    .header img {
                        width: 200px;
                        height: auto;
                        margin-bottom: 15px;
                    }
                    .content {
                        margin-top: 20px;
                        font-size: 16px;
                        line-height: 1.8;
                        color: #555;
                    }
                    .footer {
                        text-align: center;
                        margin-top: 30px;
                        font-size: 14px;
                        color: #888;
                    }
                    .footer p {
                        margin: 5px 0;
                    }
                    .footer a {
                        color: #2e87d7;
                        text-decoration: none;
                    }
                    @media (max-width: 600px) {
                        .container {
                            padding: 15px;
                        }
                        .header img {
                            width: 180px;
                        }
                        .content {
                            font-size: 14px;
                        }
                        .footer {
                            font-size: 12px;
                        }
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <img src='logo.png' alt='Your Logo'>
                    </div>
                    <div class='content'>
                        <p>Dear <strong>{$first_name},</strong></p>
                        <p>Welcome! You can log in to your portal to manage your payments, track balances, and print payment history.</p>
                        <p><strong>Login Details:</strong></p>
                        <p>Email: {$email}</p>
                        <p>Password: {$password}</p>
                        <p><a href='http://127.0.0.1:8000/login'>Click here to login</a></p>
                        <p>Thank you!</p>
                    </div>
                    <div class='footer'>
                        <p>Note: This is a system-generated email. Please do not reply to this email.</p>
                        <p>Best regards, <br> Your Support Team</p>
                    </div>
                </div>
            </body>
            </html>
            ";

            $mail->send();
        } catch (Exception $e) {

        }
    }



    public function edit(Boarder $boarder)
    {
        return response()->json($boarder);
    }

    public function update(Request $request, Boarder $boarder)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
            'guardian_name' => 'required',
            'guardian_phone_number' => 'required',
            'address' => 'required',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $currentRoom = $boarder->room;
        $newRoom = Room::findOrFail($request->room_id);

        if ($currentRoom->id != $newRoom->id) {
            $currentRoom->slots += 1;
            if ($currentRoom->slots > 0) {
                $currentRoom->status = 'available';
            }
            $currentRoom->save();

            if ($newRoom->slots > 0) {
                $newRoom->slots -= 1;
                if ($newRoom->slots == 0) {
                    $newRoom->status = 'occupied';
                }
                $newRoom->save();
            } else {
                return redirect()->route('boarders.index')->with('error', 'The selected room has no available slots.');
            }
        }

        $boarder->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'guardian_name' => $request->guardian_name,
            'guardian_phone_number' => $request->guardian_phone_number,
            'address' => $request->address,
            'room_id' => $request->room_id,
        ]);

        return redirect()->route('boarders.index')->with('success', 'Boarder updated successfully.');
    }

    public function destroy(Boarder $boarder)
    {
        $room = $boarder->room;

        $boarder->delete();

        $room->slots += 1;
        if ($room->slots > 0) {
            $room->status = 'available';
        }
        $room->save();

        return redirect()->route('boarders.index')->with('success', 'Boarder deleted successfully.');
    }

}
