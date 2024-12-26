<!DOCTYPE html>
<html>
<head>
    <title>Recharge {{$status}} Notice</title>
</head>
<body>
    <h1>Rental Recharge {{$status}} Notice</h1>
    <p><strong>Rental ID:</strong> {{ $recharge->rental_id }}</p>
    <p><strong>Name:</strong> {{ $recharge->name }}</p>
    <p><strong>Email:</strong> {{ $recharge->email }}</p>
    <p>The recharge for your rental has {{$status}}. Please take action accordingly.</p>
</body>
</html>
