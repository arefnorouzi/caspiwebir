<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;

class DeleteExpiredInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Expired Invoices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Invoice::where('payment_status', false)
            ->where('invoice_status_id', 1)
            ->whereNull('purchased_at')
            ->where('expired_at', '<', now())->delete();
    }
}
