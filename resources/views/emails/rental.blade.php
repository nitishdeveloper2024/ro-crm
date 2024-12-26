<!-- resources/views/emails/complaint.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Submitted || Drinktech- NEXTGEN RO</title>
</head>
<body>
    <h2>Dear {{ $rental->name }},</h2>
    <p>Thank you for submitting your rental. Your Rental ID is <strong>{{ $rental->rental_id }}</strong>.</p>
    <p>We have attached a PDF with the details of your rental.</p>
    <p>Our team will contact you soon regarding the status of your rental.</p>
    <p>Regards,<br>Support Team</p>
</body>
</html>
