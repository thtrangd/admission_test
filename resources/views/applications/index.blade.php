<!DOCTYPE html>
<html>
<head>
    <title>Applications List</title>
</head>
<body>
    <h1>All Applications</h1>
    <ul>
        @foreach($applications as $application)
            <li>{{ $application->application_id }} - {{ $application->applicant_name }} - {{ $application->status }}</li>
        @endforeach
    </ul>
</body>
</html>
