<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Due Reminder</title>
</head>
<body>
    <p>Your task <strong>{{ $task->title }}</strong> is due in 24 hours.</p>
    <p>Please make sure to complete it before the due date.</p>
    <p><a href="{{ url('/tasks/' . $task->id) }}">View Task</a></p>
</body>
</html>
