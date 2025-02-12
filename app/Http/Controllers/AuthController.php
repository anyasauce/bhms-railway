<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Str;
use App\Models\Boarder;
use Laravel\Socialite\Facades\Socialite;


date_default_timezone_set('Asia/Manila');

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $boarder = Boarder::where('email', $googleUser->getEmail())->first();

        if ($boarder) {
            Auth::guard('boarders')->login($boarder);
            return redirect()->intended('/boarderdashboard')->with('success', 'Welcome Boarder!');
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            Auth::guard('web')->login($user);
            return redirect()->intended('/dashboard')->with('success', 'Welcome Admin!');
        }

        return redirect()->route('login')->with('error', 'Email not registered with us.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->intended('/dashboard')->with('success', 'Welcome Admin!');
        }

        if (Auth::guard('boarders')->attempt($credentials)) {
            return redirect()->intended('/boarderdashboard')->with('success', 'Welcome Boarder!');
        }

        return redirect()->route('login')->with('error', 'The email or password you entered is incorrect. Please try again.');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = Boarder::where('email', $request->email)->first();
        }

        if ($user) {
            $token = Str::random(60);

            if ($user instanceof User) {
                $user->update(['reset_token' => $token]);
            } elseif ($user instanceof Boarder) {
                $user->update(['reset_token' => $token]);
            }


            try {
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = env('MAIL_USERNAME');
                $mail->Password = env('MAIL_PASSWORD');
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('josiahdanielle09gallenero@gmail.com', 'Admin');
                $mail->addAddress($user->email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';

                $mail->Body = '
                    <html>
                        <head>
                            <style>
                                body {
                                    font-family: Arial, sans-serif;
                                    background-color: #f3f4f6;
                                    padding: 20px;
                                }
                                .email-container {
                                    width: 100%;
                                    max-width: 600px;
                                    margin: 0 auto;
                                    background-color: #ffffff;
                                    border-radius: 8px;
                                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                    padding: 30px;
                                }
                                h2 {
                                    color: #333;
                                    text-align: center;
                                }
                                p {
                                    font-size: 13px;
                                    color: #555;
                                    line-height: 1.5;
                                }
                                .button {
                                    display: inline-block;
                                    background-color: #4CAF50;
                                    color: #ffffff;
                                    padding: 12px 25px;
                                    text-decoration: none;
                                    border-radius: 4px;
                                    text-align: center;
                                    font-size: 13px;
                                    margin: 20px 0;
                                    transition: background-color 0.3s;
                                }
                                .button:hover {
                                    background-color: #45a049;
                                }
                                .footer {
                                    text-align: center;
                                    font-size: 10px;
                                    color: #aaa;
                                    margin-top: 20px;
                                }
                                @media only screen and (max-width: 768px) {
                                    .email-container {
                                        width: 300px;
                                        padding: 20px;
                                    }
                                }
                                @media only screen and (min-width: 769px) {
                                .email-container {
                                    margin-left: 0;
                                    margin-right: 0;
                                    width: 100%; /* Take full width */
                                }
                            }
                            </style>
                        </head>
                        <body>
                            <div class="email-container">
                                <h2>Password Reset Request</h2>
                                <p>Hello,</p>
                                <p>We received a request to reset your password. Click the button below to reset it:</p>
                                <a href="' . route('reset.password.form', ['token' => $token, 'email' => $request->email]) . '" class="button">Reset Your Password</a>
                                <p>If you did not request a password reset, please ignore this email. Your password will not be changed.</p>
                                <div class="footer">
                                    <p>&copy; ' . date('Y') . ' Boarding House. All rights reserved.</p>
                                </div>
                            </div>
                        </body>
                    </html>
                ';

                $mail->send();

                return back()->with('success', 'Password reset link has been sent to your email!');
            } catch (Exception $e) {
                return back()->with(['error' => 'Unable to send the reset email. Please try again later.']);
            }
        }

        return back()->with(['error' => 'User not found.']);
    }

    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('auth.reset-password', ['email' => $email, 'token' => $token]);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $user = User::where('reset_token', $request->token)->first();

        if (!$user) {
            $user = Boarder::where('reset_token', $request->token)->first();
        }

        if (!$user) {
            return redirect()->route('login')->withErrors(['token' => 'This password reset link is invalid or expired.']);
        }

        $user->password = Hash::make($request->password);
        $user->reset_token = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Your password has been reset successfully!');
    }


}

