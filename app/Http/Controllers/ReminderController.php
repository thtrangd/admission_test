<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\CommunicationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReminderController extends Controller
{
    public function sendReminder(Request $request, $id)
    {
        $data = $request->validate([
            'template' => 'required|string',
            'sent_to' => 'required|email',
        ]);

        $application = Application::findOrFail($id);

        $body = str_replace(
            ['{{student_name}}', '{{programme}}', '{{intake}}'],
            [$application->applicant_name, $application->programme, $application->intake],
            $data['template']
        );

        Mail::raw($body, function ($msg) use ($data) {
            $msg->to($data['sent_to'])->subject('Application Reminder');
        });

        CommunicationLog::create([
            'application_id' => $application->id,
            'action' => 'send_reminder',
            'template' => $data['template'],
            'sent_to' => $data['sent_to'],
            'sent_at' => now(),
        ]);

        return response()->json(['message' => 'Reminder sent successfully']);
    }
}
