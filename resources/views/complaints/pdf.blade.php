<!-- resources/views/complaints/pdf.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint PDF</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        .header, .footer {
            text-align: center;
        }
        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .company-info h1 {
            margin: 0;
        }
        .company-info p {
            margin: 5px 0;
        }
        .bill-info, .customer-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .bill-info div, .customer-info div {
            width: 48%;
        }
        .customer-info {
            margin-top: 20px;
        }
        .table-container {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-container th, .table-container td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .table-container th {
            background-color: #f2f2f2;
        }
        .table-container td {
            text-align: right;
        }
        .table-container .left-align {
            text-align: left;
        }
        .total-summary {
            margin-top: 20px;
            text-align: right;
        }
        .total-summary div {
            margin: 5px 0;
        }
        .footer {
            margin-top: 40px;
            font-size: 12px;
        }
    
    </style>
</head>
<body>
    <!-- Company Information -->
    <div class="company-info">
        <h1>Drinktech</h1>
        <h2>ISO Certified 9001:2015</h2>
        <p>Head Office: F-18/189 Outer Ring Rd, Nagavara, Bengaluru
            Karnataka 560045 INDIA</p>
        <p>Phone: +91 9625718007 | Email: info@drinktech.ltd</p>
    </div>

    <div class="header">Complaint Details</div>

    <div class="complaint-info">
        <table>
            <tr>
                <th>Complaint ID</th>
                <td>{{ $complaint->complaint_id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $complaint->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $complaint->email }}</td>
            </tr>
            <tr>
                <th>Contact</th>
                <td>{{ $complaint->contact }}</td>
            </tr>
            <tr>
                <th>Alternate Contact</th>
                <td>{{ $complaint->alt_contact }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $complaint->description }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $complaint->status }}</td>
            </tr>
        </table>
    </div>
     <!-- Footer Information -->
     <div class="footer">
        <p>Thank you for shopping with DrinkTECH!</p>
        <p>For any inquiries, please contact our support team at info@drinktech.ltd  or +91 9625718007.</p>
    </div>

</body>
</html>
