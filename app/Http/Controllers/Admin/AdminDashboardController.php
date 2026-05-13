<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $todaySales = Invoice::whereDate(
            'invoice_date',
            today()
        )->sum('total_amount');

        $monthlySales = Invoice::whereMonth(
            'invoice_date',
            now()->month
        )
        ->whereYear(
            'invoice_date',
            now()->year
        )
        ->sum('total_amount');

        $totalGST =
            Invoice::sum('cgst_amount') +
            Invoice::sum('sgst_amount') +
            Invoice::sum('igst_amount');

        $paidInvoices = Invoice::where(
            'status',
            'paid'
        )->count();

        $unpaidInvoices = Invoice::where(
            'status',
            'unpaid'
        )->count();

        $totalCustomers = Customer::count();

        $totalStaff = User::where(
            'role',
            'staff'
        )->count();

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'todaySales',
            'monthlySales',
            'totalGST',
            'paidInvoices',
            'unpaidInvoices',
            'totalCustomers',
            'totalStaff',
            'recentActivities'
        ));
    }
}