<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationStatusLog;
use Illuminate\Http\Request;

class ApplicationStatusController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'to_status' => 'required|in:Submitted,Accepted,Rejected',
            'changed_by' => 'required|string',
        ]);

        $application = Application::findOrFail($id);

        $fromStatus = $application->status;
        $toStatus = $request->to_status;

        if ($fromStatus === $toStatus) {
            return response()->json(['error' => 'Status already set'], 400);
        }

        $application->status = $toStatus;
        $application->save();

        ApplicationStatusLog::create([
            'application_id' => $application->id,
            'from_status' => $fromStatus,
            'to_status' => $toStatus,
            'changed_by' => $request->changed_by,
            'changed_at' => now(),
        ]);

        return response()->json(['message' => 'Status updated successfully']);
    }
}
