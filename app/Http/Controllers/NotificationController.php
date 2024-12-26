<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller; // Make sure to import this
use App\Models\Sale;
use App\Notifications\SaleDateExceeded;
use Illuminate\Support\Facades\Notification as h;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Notification;

class NotificationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');  // Ensure user is logged in
        $this->middleware('permission:view dashboard');  // Ensure user has 'view dashboard' permission
        // auth()->user()->unreadNotifications->markAsRead();
    }
    
    public function index()
    {
        // Get all notifications
        $notifications = Notification::all();

        return view('notifications.index', compact('notifications'));
    }


    

}
