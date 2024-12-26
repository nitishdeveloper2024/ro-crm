<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sale;
use App\Models\Notification;
use Carbon\Carbon;
// use Illuminate\Console\Command;

class CheckSalesNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-sales-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all sales
        $sales = Sale::all();

        foreach ($sales as $sale) {
            // Calculate the number of days from the sale's created_at to the current date
            $daysSinceCreated = Carbon::parse($sale->created_at)->diffInDays(Carbon::now());

            // Check if sale exceeds 220 days
            $is220 = $daysSinceCreated > 220;

            // Check if sale exceeds 330 days
            $is330 = $daysSinceCreated > 330;

            // Check if the notification already exists for this sale
            $existingNotification = Notification::where('sale_id', $sale->id)->first();

            // If no notification exists and sale exceeds 220 or 330 days, create one
            if (!$existingNotification) {
                if ($is220 || $is330) {
                    Notification::create([
                        'sale_id' => $sale->id,
                        'is220' => $is220 ? 1 : 0,   // Save 1 for is220 if the sale exceeds 220 days
                        'is330' => $is330 ? 1 : 0,   // Save 1 for is330 if the sale exceeds 330 days
                    ]);

                    // Output to console
                    $this->info('Notification created for Sale ID: ' . $sale->id);
                }
            }
        }

        $this->info('Sales notification check completed.');
    }
        
    }
// }
