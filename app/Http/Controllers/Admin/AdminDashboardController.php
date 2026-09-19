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
        $todaySales = Invoice::whereDate('invoice_date', today())->sum('total_amount');

        $monthlySales = Invoice::whereMonth('invoice_date', now()->month)
            ->whereYear('invoice_date', now()->year)
            ->sum('total_amount');

        $totalSalesAllTime = Invoice::sum('total_amount');

        $totalGST = Invoice::sum('cgst_amount') +
            Invoice::sum('sgst_amount') +
            Invoice::sum('igst_amount');

        $paidInvoices = Invoice::where('status', 'paid')->count();
        $paidAmount = Invoice::where('status', 'paid')->sum('total_amount');

        $unpaidInvoices = Invoice::where('status', 'unpaid')->count();
        $unpaidAmount = Invoice::where('status', 'unpaid')->sum('total_amount');

        $totalCustomers = Customer::count();

        $totalStaff = User::whereIn('role', ['staff', 'support'])->count();

        $recentInvoices = Invoice::with('customer')
            ->latest('id')
            ->take(6)
            ->get();

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(8)
            ->get();

        $mailSetting = \App\Models\MailSetting::first();

        return view('admin.dashboard', compact(
            'todaySales',
            'monthlySales',
            'totalSalesAllTime',
            'totalGST',
            'paidInvoices',
            'paidAmount',
            'unpaidInvoices',
            'unpaidAmount',
            'totalCustomers',
            'totalStaff',
            'recentInvoices',
            'recentActivities',
            'mailSetting'
        ));
    }
}