<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Part;
use App\Models\Partsale;
use App\Models\Complaint;
use App\Models\Service;
use App\Models\Permission;
use App\Models\Rental; // Assuming this is part of your analytics data
use Illuminate\Routing\Controller; // Make sure to import this
// use App\Models\Sale;
use App\Notifications\SaleDateExceeded;
use Illuminate\Support\Facades\Notification;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  // Ensure user is logged in
        $this->middleware('permission:view dashboard');  // Ensure user has 'view dashboard' permission
    
    }

    public function index()
    {
                


        // Example of analytics data
        $userCount = User::count();
        $userProduct = Product::count();
        $userSale = Sale::count();
        $userPart = Part::count();
        $userPartsale = Partsale::count();
        $userComplaint = Complaint::count();
        $userService = Service::count();
        $userPermission = Permission::count();
        $rechargeCount = Rental::count();
        $activeRecharges = Rental::where('status', 'active')->count();
        $expiredRecharges = Rental::where('status', 'expired')->count();

        $totalSale = DB::table('sales')
        ->select(DB::raw('SUM(final_amt * qty) as total_sale'))
        ->first()->total_sale;

        $totalService = DB::table('services')
        ->select(DB::raw('SUM(final_amt) as total_sale'))
        ->first()->total_sale;

        $totalRental = DB::table('recharges')
        ->select(DB::raw('SUM(amount) as total_sale'))
        ->first()->total_sale;

        // You can also fetch other kinds of data as needed

        // Pass the data to the dashboard view
        return view('dashboard', compact('userCount', 'rechargeCount', 'activeRecharges', 'expiredRecharges', 'userPermission','userComplaint','userService','userPart','userPartsale','userProduct','userSale','totalSale','totalService','totalRental'));
    }

}
