<!DOCTYPE html>
<html>
<head>
    <title>Recharge {{$status}} Notice</title>
</head>
<body>
    <h1>Dear {{ $recharge->name }}</h1>
    <p>We regret to inform you that your rental recharge has {{$status}}. Please find the details in the attached PDF.</p>
    <p>Best Regards, <br> Rental Support</p>
</body>
</html>
