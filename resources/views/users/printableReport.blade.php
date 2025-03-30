<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fortnight Tasks Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f3f3f3;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Fortnight Tasks Report</h2>
    <h3 style="text-align:center;">
      ({{ \Carbon\Carbon::parse($fortnight->start_date)->format('F j, Y') }} - 
       {{ \Carbon\Carbon::parse($fortnight->end_date)->format('F j, Y') }})
    </h3>
  
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Employee Name</th>
                <th>All Tasks</th>
                <th>Pending</th>
                <th>Progress</th>
                <th>Completed</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->all_tasks }}</td>
                    <td>{{ $user->pending_tasks }}</td>
                    <td>{{ $user->progress_tasks }}</td>
                    <td>{{ $user->completed_tasks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
