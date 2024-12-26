<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    

    <div class="container">
        <h1>Welcome to Your Dashboard</h1>
        <style>
            .col-md-3{
                margin: 5px 0px;
            }
        </style>
        <!-- Displaying the analytics data -->
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Users</div>
                    <div class="card-body">
                        <h4>{{ $userCount }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Products Sale Value</div>
                    <div class="card-body">
                        <h4>{{ number_format($totalSale,2) }} INR</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Service Sale Value</div>
                    <div class="card-body">
                        <h4>{{ number_format($totalService,2) }} INR</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Rental Sale Value</div>
                    <div class="card-body">
                        <h4>{{ number_format($totalRental,2) }} INR</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Products</div>
                    <div class="card-body">
                        <h4>{{ $userProduct }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Sale</div>
                    <div class="card-body">
                        <h4>{{ $userSale }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Parts</div>
                    <div class="card-body">
                        <h4>{{ $userPart }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Parts Sale</div>
                    <div class="card-body">
                        <h4>{{ $userPartsale }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Complaint</div>
                    <div class="card-body">
                        <h4>{{ $userComplaint }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Service</div>
                    <div class="card-body">
                        <h4>{{ $userService }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Roles</div>
                    <div class="card-body">
                        <h4>{{ $userCount }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Permissions</div>
                    <div class="card-body">
                        <h4>{{ $userPermission }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Total Rentals</div>
                    <div class="card-body">
                        <h4>{{ $rechargeCount }}</h4>
                    </div>
                </div>
            </div>
    
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Active Recharges</div>
                    <div class="card-body">
                        <h4>{{ $activeRecharges }}</h4>
                    </div>
                </div>
            </div>
    
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Expired Recharges</div>
                    <div class="card-body">
                        <h4>{{ $expiredRecharges }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
