<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

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
            'status' => 'in:Submitted,Accepted,Rejected',
            'payment_status' => 'in:unpaid,partial,paid',
        ]);

        $application->update($data);

        return response()->json($application);
    }

    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();

        return response()->json(['message' => 'Application deleted']);
    }
    
}
    