<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Messages\DatabaseMessage;

class SaleDateExceeded extends Notification
{
    use Queueable;


    public $salesInfo;
    public $threshold;

    public function __construct($salesInfo, $threshold)
    {
        $this->salesInfo = $salesInfo; // The sales data passed to the notification
        $this->threshold = $threshold; // The threshold value (220 or 330 days)
    }

    public function via($notifiable)
    {
        return ['database']; // We will store the notification in the database
    }

    public function toDatabase($notifiable)
    {
        // Map the sales data to a format that will be used in the notification
        $sales = $this->salesInfo->map(function ($sale) {
            return [
                'sale_id' => $sale->id,
                'customer_name' => $sale->c_name,
                'customer_email' => $sale->c_email,
                'customer_contact' => $sale->c_contact,
            ];
        });

        return [
            'message' => "Some sales have exceeded the {$this->threshold}-day threshold.",
            'sales' => $sales, // This is an array of sales data
            'sent_for' => $this->threshold, // The threshold (220 or 330)
        ];
    }


}
