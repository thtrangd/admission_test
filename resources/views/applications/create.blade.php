<!DOCTYPE html>
<html>
<head><title>Create Application</title></head>
<body>
    <h1>Create Application</h1>
    <form method="POST" action="{{ route('applications.store') }}">
        @csrf
        <label>Program:</label>
        <input type="text" name="program" required>
        <label>Status:</label>
        <input type="text" name="status" required>
        <button type="submit">Save</button>
    </form>
</body>
</html>
