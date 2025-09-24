<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Application;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_name' => 'required|string',
            'programme' => 'required|string',
            'intake' => 'required|string',
            'email' => 'required|email|unique:registrations,email',
            'phone' => 'required|string',
        ]);

        $registration = Registration::create($data);

        $application = Application::create([
            'application_id' => 'APP-' . date('Y') . '-' . rand(1000, 9999),
            'applicant_name' => $data['student_name'],
            'programme' => $data['programme'],
            'intake' => $data['intake'],
            'status' => 'Submitted',
            'payment_status' => 'unpaid',
        ]);

        return response()->json([
            'registration' => $registration,
            'application' => $application,
        ], 201);
    }
}
