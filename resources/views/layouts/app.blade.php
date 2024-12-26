<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        {{-- <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'> --}}
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css'>
        <link rel='stylesheet' href='https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css'>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script>
            // Function to generate a unique Complaint ID
            function generateComplaintId() {
                // Get current timestamp (in milliseconds)
                const timestamp = new Date().getTime();
    
                // Generate a random number between 1000 and 9999 (4-digit random number)
                const randomNum = Math.floor(Math.random() * 9000) + 1000;
    
                // Combine timestamp and random number to create a unique ID
                const complaintId = `CID-${timestamp}-${randomNum}`;
    
                return complaintId;
            }
    
            // Function to generate the Complaint ID when the page loads
            // window.onload = function() {
                // Generate the Complaint ID
            //    };
        </script>
    
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js'></script>
    <script src='https://cdn.datatables.net/2.1.8/js/dataTables.js'></script>
    <script src='https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js'></script>
    <script>
    	$(document).ready(function() {
	//Only needed for the filename of export files.
	//Normally set in the title tag of your page.
	document.title='Drinktech';
	// DataTable initialisation
	$('#example').DataTable(
		{
			"dom": '<"dt-buttons"Bf><"clear">lirtp',
			"paging": false,
			"autoWidth": true,
			"buttons": [
				'colvis',
				'copyHtml5',
        'csvHtml5',
				'excelHtml5',
        'pdfHtml5',
				'print'
			]
		}
	);
});

    </script>
    <script>
        // On product selection change, fetch the price, MRP, and Sale Price via AJAX
        $('#part').on('change', function() {
            var productId = $(this).val();
    
            if (productId) {
                $.ajax({
                    url: '{{ route("getPartPrice") }}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#mrp').val(response.mrp);
                            $('#price').val(response.price);
                        } else {
                            alert(response.message);
                        }
                    }
                });
            } else {
                $('#mrp').val('');
                $('#price').val('');
            }
        });

        $('#product').on('change', function() {
            var productId = $(this).val();
    
            if (productId) {
                $.ajax({
                    url: '{{ route("getProductPrice") }}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#mrp').val(response.mrp);
                            $('#price').val(response.price);
                        } else {
                            alert(response.message);
                        }
                    }
                });
            } else {
                $('#mrp').val('');
                $('#price').val('');
            }
        });
    </script>
    <script>
        // Function to calculate the final amount
        function calculateFinalAmount() {
            // Get the values from the form
            let price = parseFloat(document.getElementById('price').value) || 0;
            let qty = parseInt(document.getElementById('qty').value) || 0;
            let discount = parseFloat(document.getElementById('discount').value) || 0;
    
            // Calculate total price
            let totalPrice = (price * qty) - discount;
    
            // Update the final amount field
            document.getElementById('final_amt').value = totalPrice.toFixed(2);
        }
    
        // Function to generate a unique invoice number
        function generateInvoiceNumber() {
            // Get current date and time
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
            const day = String(now.getDate()).padStart(2, '0');
            const time = String(now.getHours()).padStart(2, '0') + String(now.getMinutes()).padStart(2, '0') + String(now.getSeconds()).padStart(2, '0');
            
            // Generate a random 4 digit number
            const randomNumber = Math.floor(Math.random() * 10000);
            
            // Format the invoice number
            const invoiceNumber = `INV-${year}${month}${day}-${time}-${randomNumber.toString().padStart(4, '0')}`;
            
            // Set the invoice number in the input field
            document.getElementById('invoiceNumber').value = invoiceNumber;
        }
        
                // Function to calculate the final amount
                function calculateFinalAmountD() {
            // Get the values from the form inputs
            var serviceCharge = parseFloat(document.getElementById("serviceCharge").value);
            var discount = parseFloat(document.getElementById("discount").value);
            
            // Ensure values are numbers
            if (isNaN(serviceCharge) || isNaN(discount)) {
                document.getElementById("finalAmt").value = ""; // Clear final amount if inputs are invalid
                return;
            }

            // Calculate the final amount
            var finalAmount = serviceCharge - discount;
            
            // Display the result in the finalAmount input field
            document.getElementById("finalAmt").value = finalAmount.toFixed(2);
        }

            
        // Combined window.onload function
        window.onload = function() {
            // Generate the invoice number on page load
            generateInvoiceNumber();
    
            // Add event listeners for the final amount calculation
            document.getElementById('price').addEventListener('input', calculateFinalAmount);
            document.getElementById('qty').addEventListener('input', calculateFinalAmount);
            document.getElementById('discount').addEventListener('input', calculateFinalAmount);

            
        }
    </script>
        
        
        
    @isset($script)
    {{$script}}
    @endisset
</html>
