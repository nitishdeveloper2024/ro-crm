<!-- resources/views/emails/complaint.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Submitted</title>
</head>
<body>
    <h2>Dear {{ $complaint->name }},</h2>
    <p>Thank you for submitting your complaint. Your complaint ID is <strong>{{ $complaint->complaint_id }}</strong>.</p>
    <p>We have attached a PDF with the details of your complaint.</p>
    <p>Our team will contact you soon regarding the status of your complaint.</p>
    <p>Regards,<br>Support Team</p>
</body>
</html>
