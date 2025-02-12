<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
date_default_timezone_set('Asia/Manila');

class UserController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function boarders()
    {
        return view('boarders');
    }

    public function rooms()
    {
        return view('rooms');
    }

    public function payments()
    {
        return view('payments');
    }

    public function create()
    {
        $password = '123123123';
        $hashedPassword = Hash::make($password);

        DB::table('users')->insert([
            'name' => 'Josiah Danielle Gallenero',
            'email' => 'josiahdanielle09gallenero@gmail.com',
            'password' => $hashedPassword,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return 'User has been added!';
    }

    public function showProfile()
    {
        $user = Auth::user();

        return view('profile', compact('user'));
    }

    public function updateAdminProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
        return redirect()->route('profile')->with('success', 'Admin Profile updated successfully.');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout successful!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        Auth::logout();
        return redirect('/auth')->with('success-delete', 'Account deleted successfully.');
    }


    public function sendContactMessage(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|numeric',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

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
            $mail->addAddress('josiahdanielle09gallenero@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = $request->subject;

            $mail->Body = '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; padding: 20px; }
                    .email-container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
                    .email-header { background-color: #0046d5; color: white; padding: 10px 15px; text-align: center; border-radius: 8px 8px 0 0; }
                    .email-content { margin-top: 20px; }
                    .email-content p { margin: 10px 0; }
                    .email-content .label { font-weight: bold; }
                    .footer { margin-top: 20px; text-align: center; font-size: 12px; color: #aaa; }
                    .footer a { color: #0046d5; text-decoration: none; }
                </style>
            </head>
            <body>
                <div class="email-container">
                    <div class="email-header">
                        <h2>New Contact Message</h2>
                    </div>
                    <div class="email-content">
                        <p><span class="label">Full Name:</span> ' . $request->fullname . '</p>
                        <p><span class="label">Email:</span> ' . $request->email . '</p>
                        <p><span class="label">Phone:</span> ' . $request->phone . '</p>
                        <p><span class="label">Subject:</span> ' . $request->subject . '</p>
                        <p><span class="label">Message:</span><br>' . nl2br(e($request->message)) . '</p>
                    </div>
                    <div class="footer">
                        <p>Thank you for reaching out to us!</p>
                    </div>
                </div>
            </body>
            </html>';

            $mail->send();

            return back()->with('success', 'Your message has been sent!');
        } catch (Exception $e) {
            return back()->with('error', 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        }
    }


    public function showContactForm()
    {
        return view('main.contact');
    }

}
