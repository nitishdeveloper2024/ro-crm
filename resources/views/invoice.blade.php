<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice/Bill</title>
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

<div class="container">

    <!-- Company Information -->
    <div class="company-info">
        <h1>Drinktech</h1>
        <h2>ISO Certified 9001:2015</h2>
        <p>Head Office: F-18/189 Outer Ring Rd, Nagavara, Bengaluru
            Karnataka 560045 INDIA</p>
        <p>Phone: +91 9625718007 | Email: info@drinktech.ltd</p>
    </div>

    <!-- Bill and Customer Information -->
    <div class="bill-info">
        <div>
            <h3>Bill To:</h3>
            <p><strong>Customer Name:</strong> {{ $sale->c_name }}</p>
            {{-- <p><strong>Customer Name:</strong> {{ $product_mrp }}</p> --}}
            <p><strong>Email:</strong> {{ $sale->c_email}}</p>
            <p><strong>Address:</strong> {{ $sale->c_address}}</p>
            <p><strong>Pincode:</strong> {{ $sale->c_pin_code}}</p>
            <p><strong>Mobile No:</strong> {{$sale->c_mobile}}</p>
            <p><strong>Alternate Mobile No:</strong> {{$sale->c_alt_mobile}}</p>
        </div>
        <div>
            <h3>Transaction Info:</h3>
            <p><strong>Date:</strong> {{$sale->billed_date}}</p>
            <p><strong>Invoice No:</strong> {{$sale->invoicenumber}}</p>
            <p><strong>Payment Method:</strong> {{$sale->payment}}</p>
        </div>
    </div>

    <!-- Product Details Table -->
    <table class="table-container">
        <thead>
            <tr>
                <th class="left-align">Product Name</th>
                <th>MRP</th>
                <th>Sale Price</th>
                <th>Discount</th>
                <th>Quantity</th>
                <th>Final Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Product 1</td>
                <td>{{$sale->mrp}}</td>
                <td>{{$sale->price}}</td>
                <td>{{$sale->discount}}</td>
                <td>{{$sale->qty}}</td>
                <td>{{$sale->final_amt}}</td>
            </tr>
        </tbody>
    </table>

    <div class="total-summary">
        <div><strong>Total MRP:</strong> {{$sale->mrp}}</div>
        <div><strong>Total Sale Price:</strong> {{$sale->price}}</div>
        <div><strong>Total Discount:</strong> {{$sale->discount}}</div>
        <div><strong>Total Quantity:</strong> {{$sale->qty}}</div>
        <div><strong>Total Billed Price:</strong> {{$sale->final_amt}}</div>
    </div>


    <!-- Footer Information -->
    <div class="footer">
        <p>Thank you for shopping with DrinkTECH!</p>
        <p>For any inquiries, please contact our support team at info@drinktech.ltd  or +91 9625718007.</p>
    </div>

</div>

</body>
</html>
