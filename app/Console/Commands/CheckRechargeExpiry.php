<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Mail\RechargeExpiredMail;
use Illuminate\Support\Facades\Mail;
use PDF;

class CheckRechargeExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-recharge-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $currentDate = Carbon::now();

        // Get all recharges and their associated rentals
        $recharges = DB::table('recharges')
            ->leftjoin('rentals', 'rentals.rental_id', '=', 'recharges.rentalid')
            // ->select('recharges.*', 'rentals.name', 'rentals.email', 'rentals.status', 'rentals.rental_id')
            ->get();

        foreach ($recharges as $recharge) {
            // Calculate expiry date based on days or months
            $expiryDate = $this->calculateExpiryDate($recharge);

            // Check if expired
            if ($currentDate->greaterThan($expiryDate)) {
                // Update rental status to expired
                DB::table('rentals')
                    ->where('rental_id', $recharge->rental_id)
                    ->update(['status' => 'expired']);

                // Generate PDF and send email
                $this->generatePdfAndSendEmail($recharge);
            }
        }

        $this->info('Recharge expiry check completed.');
    }

    /**
     * Calculate expiry date based on days or months.
     */
    protected function calculateExpiryDate($recharge)
    {
        // Default expiry date based on 'created_at'
        $expiryDate = Carbon::parse($recharge->created_at);

        // Add days if 'days' is provided
        if ($recharge->days) {
            $expiryDate = $expiryDate->addDays((int)$recharge->days);
        }
        // Add months if 'months' is provided
        elseif ($recharge->months) {
            $expiryDate = $expiryDate->addMonths((int)$recharge->months);
        }

        return $expiryDate;
    }

    /**
     * Generate PDF and send email with the recharge details.
     */
    protected function generatePdfAndSendEmail($recharge)
    {
        // Generate the PDF content using the recharge data
        $pdf = PDF::loadView('pdf.expired_recharge', [
            'recharge' => $recharge,
            'status' => 'expired'  // Include the updated status in the PDF
        ]);

        // Get the PDF content as a string (in-memory)
        $pdfContent = $pdf->output();
        // $new_status="Expired";
        // Send email with the generated PDF (no need to save it in storage)
        Mail::to($recharge->email)->send(new RechargeExpiredMail($recharge, $pdfContent));
    }


}
