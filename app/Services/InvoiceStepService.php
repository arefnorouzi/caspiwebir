<?php

namespace App\Services;

use App\Models\InvoiceStep;
use Illuminate\Support\Facades\Log;

class InvoiceStepService
{
    public static function store_step($invoice, $status_id): void
    {
        try {
            $step = InvoiceStep::firstOrCreate(
                [
                    'invoice_id' => $invoice->id,
                    'invoice_status_id' => $status_id
                ],
                [
                    'pinned' => 1,
                ]
            );
            if ($step)
            {
                InvoiceStep::where('invoice_id', $invoice->id)->where('id', '!=', $step->id)
                    ->update(['pinned' => 0]);
            }
        }
        catch (\Exception $e) {
            Log::error("error in store step for invoice: " . $invoice->id);
        }


    }
}
