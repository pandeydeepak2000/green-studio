<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $myInvoices = Invoice::where(
            'created_by',
            $userId
        )->count();

        $monthlySales = Invoice::where(
            'created_by',
            $userId
        )
        ->whereMonth(
            'invoice_date',
            now()->month
        )
        ->whereYear(
            'invoice_date',
            now()->year
        )
        ->sum('total_amount');

        $pendingPayments = Invoice::where(
            'created_by',
            $userId
        )
        ->where(
            'status',
            'unpaid'
        )
        ->sum('total_amount');

        $paidInvoices = Invoice::where(
            'created_by',
            $userId
        )
        ->where(
            'status',
            'paid'
        )
        ->count();

        $recentInvoices = Invoice::with('customer')
            ->where('created_by', $userId)
            ->latest('id')
            ->take(5)
            ->get();

        return view('staff.dashboard', compact(
            'myInvoices',
            'monthlySales',
            'pendingPayments',
            'paidInvoices',
            'recentInvoices'
        ));
    }
}