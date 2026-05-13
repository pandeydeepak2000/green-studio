<?php

namespace App\Services;

use App\Models\Invoice;
use Carbon\Carbon;

class InvoiceNumberGenerator
{
    public static function next(): string
    {
        $year = Carbon::now()->format('Y');

        // Default prefix – later make configurable
        $prefix = 'INV-'.$year.'-';

        // Find last invoice for this year
        $last = Invoice::where('invoice_number', 'like', $prefix.'%')
            ->orderByDesc('id')
            ->first();

        if ($last) {
            $lastNumber = (int) str_replace($prefix, '', $last->invoice_number);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}