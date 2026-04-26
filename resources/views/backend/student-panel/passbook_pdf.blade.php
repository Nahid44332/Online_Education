<!DOCTYPE html>
<html>
<head>
    <title>Student Passbook</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .text-success { color: green; }
        .text-danger { color: red; }
        .footer { margin-top: 50px; font-size: 12px; text-align: center; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Lina Digital E-Learning Platform</h2>
        <p>Passbook Statement for <strong>{{ $student->name }}</strong></p>
        <p>Date: {{ date('d M, Y') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Type</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($all_history as $item)
            <tr>
                <td>{{ date('d M, Y', strtotime($item->created_at)) }}</td>
                <td>{{ $item->reason }}</td>
                <td>{{ $item->type }}</td>
                <td class="{{ $item->type == 'Credit' ? 'text-success' : 'text-danger' }}">
                    {{ $item->type == 'Credit' ? '+' : '-' }} {{ number_format($item->amount, 0) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This is a computer-generated statement. No signature required.</p>
        <p>&copy; 2026 Lina Digital E-Learning Platfrom</p>
    </div>
</body>
</html>