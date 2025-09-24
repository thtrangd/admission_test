<!DOCTYPE html>
<html>
<head><title>Application Detail</title></head>
<body>
    <h1>{{ $application->program }} - {{ $application->status }}</h1>
    <h2>Registrations</h2>
    <ul>
        @foreach($application->registrations as $reg)
            <li>{{ $reg->course_name }} at {{ $reg->registered_at }}</li>
        @endforeach
    </ul>
    <form method="POST" action="{{ route('registrations.store') }}">
        @csrf
        <input type="hidden" name="application_id" value="{{ $application->id }}">
        <label>Course:</label>
        <input type="text" name="course_name" required>
        <button type="submit">Add Registration</button>
    </form>

    <h2>Status Logs</h2>
    <ul>
        @foreach($application->statusLogs as $log)
            <li>{{ $log->status }} at {{ $log->changed_at }}</li>
        @endforeach
    </ul>

    <h2>Send Reminder</h2>
    <form method="POST" action="{{ route('reminders.send') }}">
        @csrf
        <input type="hidden" name="application_id" value="{{ $application->id }}">
        <textarea name="message" required></textarea>
        <button type="submit">Send</button>
    </form>
</body>
</html>
