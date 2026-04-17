<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Notification' }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #0f0f0f;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #f8f8f8;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(255, 105, 180, 0.3);
        }
        .header {
            background: linear-gradient(90deg, #800000, #b30000);
            color: #fff;
            text-align: center;
            padding: 20px 10px;
            font-size: 1.5rem;
            letter-spacing: 1px;
            font-weight: bold;
        }
        .content {
            padding: 30px;
            line-height: 1.6;
        }
        .content h2 {
            color: #800000;
            margin-bottom: 10px;
        }
        .content p {
            color: #0f0f0f;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            padding: 15px;
            background-color: #f8f8f8;
            color: #0f0f0f;
            font-size: 0.9rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            text-align: center;
        }
        th {
            background-color: #800000;
            color: #fff;
            padding: 12px;
            font-weight: bold;
        }
        td {
            border: 1px solid #d9a3a3;
            padding: 10px;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #fbeaea;
        }
        tr:nth-child(odd) {
            background-color: #fff;
        }
    </style>
</head>
<body>
@php
    $latestDonation = collect($donationRequest->donations ?? [])->sortByDesc('id')->first();
@endphp

    <div class="email-container">
        <div class="header">
            {{ $header ?? 'BloodConnect Notification' }}
        </div>
        <div class="content">
            <h2>Hello, {{ $donationRequest->name ?? 'User' }}!</h2>

            <p>
                Your <strong>Blood Donation Schedule Reschedule Request</strong> has been successfully submitted through <strong>BloodConnect</strong>.
            </p>

            <p>
                We’ve notified the concerned hospital or blood bank about your new preferred schedule. They will review your request and confirm or suggest a new appointment time soon.
            </p>

            <p>
                Thank you for keeping your commitment to donate — your flexibility and continued support mean a lot in our shared mission to save lives.
            </p>

            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Previous Date</td>
                        <td>{{ $latestDonation?->latestActiveSchedule?->date ?? now()->format('Y-m-d') }}</td>
                        <td>{{ $latestDonation?->latestActiveSchedule?->status ?? 'Pending' }}</td>
                    </tr>
                    <tr>
                        <td>Requested Date</td>
                        <td>{{ $latestDonation?->latestRescheduleRequest?->date ?? now()->format('Y-m-d') }}</td>
                        <td>{{ $latestDonation?->latestRescheduleRequest?->status ?? 'Pending' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} BloodConnect. All rights reserved.
        </div>
    </div>
</body>
</html>