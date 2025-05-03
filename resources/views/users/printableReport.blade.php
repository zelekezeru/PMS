<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $user->name }} - Fortnight Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
            color: #333;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        .report-header {
            margin-bottom: 30px;
        }
        .header-info {
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #bbb;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>
<body>
    <div class="report-header">
        <h1>{{ $user->name }}'s Fortnight Report</h1>
        <div class="header-info">
            ({{ \Carbon\Carbon::parse($currentFortnight->start_date)->format('F j, Y') }}
            &ndash;
            {{ \Carbon\Carbon::parse($currentFortnight->end_date)->format('F j, Y') }})
        </div>
    </div>

    <!-- Stats Table -->
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pending</td>
                <td>{{ $stats['pending'] }}</td>
            </tr>
            <tr>
                <td>In Progress</td>
                <td>{{ $stats['in progress'] }}</td>
            </tr>
            <tr>
                <td>Completed</td>
                <td>{{ $stats['completed'] }}</td>
            </tr>
            <tr>
                <td>Approved</td>
                <td>{{ $stats['approved'] }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Deliverables Table -->
    <h2>Deliverables & Comments</h2>
    <table>
        <thead>
            <tr>
                <th>Deliverable Name</th>
                <th>Comments</th>
                <th>Commented By</th>
            </tr>
        </thead>
        <tbody>
            @forelse($deliverables as $deliverable)
                <tr>
                    <td>{{ $deliverable->name }}</td>
                    <td>{{ $deliverable->comment ?? 'N/A' }}</td>
                    <td>{{ $deliverable->commented_by ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">No deliverables found for this period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
