<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Boarder;
use App\Models\Referral;
class ApplicationController extends Controller
{
    public function create()
    {
        return view('auth.application-form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:applications,email',
            'referral_code' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && !Boarder::where('referral_code', $value)->exists()) {
                        session()->flash('error', 'Invalid referral code. Please enter a valid one.');
                        $fail('Invalid referral code.');
                    }
                }
            ]
        ]);

        Application::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'referral_code' => $request->referral_code,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully and is pending approval!');
    }



    public function manageApplicants()
    {
        $applications = Application::all();
        return view('applicants.index', compact('applications'));
    }


    public function updateStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $previousStatus = $application->status;
        $application->status = $request->status;
        $application->save();

        if ($request->status == 'approved' && $application->referral_code) {
            $referrer = Boarder::where('referral_code', $application->referral_code)->first();
            if ($referrer) {
                Referral::updateOrCreate(
                    [
                        'referrer_id' => $referrer->boarder_id,
                        'referred_application_id' => $application->id
                    ],
                    ['points' => 10]
                );
            }
        }

        if ($previousStatus == 'approved' && $request->status == 'pending') {
            Referral::where('referred_application_id', $application->id)->delete();
        }

        return redirect()->back()->with('success', 'Applicant status updated successfully!');
    }


}

