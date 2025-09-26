<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('search')) {
            $query->where('applicant_name', 'like', '%'.$request->search.'%');
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'applicant_name' => 'required|string',
            'programme' => 'required|string',
            'intake' => 'required|string',
            'email' => 'required|email|unique:applications,email',
        ]);

        $year = now()->year;
        $seq = str_pad(Application::count() + 1, 4, '0', STR_PAD_LEFT);
        $data['application_id'] = "APP-{$year}-{$seq}";
        $data['status'] = 'Submitted';
        $data['payment_status'] = 'unpaid';

        $application = Application::create($data);

        return response()->json($application, 201);
    }

    public function show($id)
    {
        $application = Application::findOrFail($id);
        return response()->json($application);
    }

    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        $data = $request->validate([
            'applicant_name' => 'string',
            'programme' => 'string',
            'intake' => 'string',
            'payment_status' => 'in:unpaid,partial,paid',
        ]);

        $application->update($data);

        return response()->json($application);
    }

    public function updateStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Submitted,Accepted,Rejected',
        ]);

        $oldStatus = $application->status ?? 'Submitted';
        if ($oldStatus === $request->status) {
            return response()->json(['message' => 'Status unchanged'], 200);
        }

        $application->status = $request->status;
        $application->save();

        ApplicationStatusLog::create([
            'application_id' => $application->id,
            'from_status' => $oldStatus,
            'to_status' => $application->status,
            'changed_by' => 'Admissions Officer',
            'changed_at' => now(),
        ]);

        if ($application->status === 'Accepted') {
            Mail::raw(
                "Dear {$application->applicant_name}, your application for {$application->programme} has been Accepted.",
                function ($message) use ($application) {
                    $message->to($application->email)
                            ->subject('Application Accepted');
                }
            );
        }

        return response()->json($application);
    }

    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();

        return response()->json(['message' => 'Application deleted']);
    }
}
