<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Request Cancelled</title>
</head>
<body style="font-family: Arial; background:#f8f8f8; padding:20px;">

<div style="max-width:600px; margin:auto; background:#fff; padding:20px; border-radius:10px;">
    
    <h2 style="color:#800000;">Blood Donation Request Cancelled</h2>

    <p>Hello {{ $donationRequest->user->name }},</p>

    <p>
        We regret to inform you that your donation request has been <strong>cancelled</strong>.
    </p>

    @if(!empty($donationRequest->notes))
    <p>
        <strong>Reason:</strong><br>
        {{ $donationRequest->notes }}
    </p>
    @endif

    <p>Please feel free to submit a new request or contact the hospital for more details.</p>

    <br>

    <p>— BloodConnect Team</p>

</div>

</body>
</html>