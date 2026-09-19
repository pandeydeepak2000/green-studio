<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\User;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceTransaction;
use App\Models\ActivityLog;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Company: Green Studio
        $company = Company::updateOrCreate(
            ['gstin' => '10DYFPA2189J1ZO'],
            [
                'name'                 => 'GREEN STUDIO',
                'gstin'                => '10DYFPA2189J1ZO',
                'state'                => 'Bihar',
                'state_code'           => '10',
                'address'              => 'Koshi College, Kachhari Road, Chitragupt Nagar, Khagaria, Bihar - 851205',
                'phone'                => '+91 98765 43210',
                'email'                => 'greenstudio.khagaria@gmail.com',
                'bank_name'            => 'State Bank of India',
                'bank_account'         => '39871234567',
                'bank_ifsc'            => 'SBIN0000115',
                'bank_branch'          => 'Khagaria Branch',
                'is_default'           => true,
                'show_logo_on_invoice' => true,
            ]
        );

        // 2. Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@greenstudio.com'],
            [
                'name'        => 'Green Studio Admin',
                'email'       => 'admin@greenstudio.com',
                'password'    => Hash::make('admin123'),
                'role'        => 'admin',
                'is_approved' => true,
                'company_id'  => $company->id,
            ]
        );

        // 3. Create Support User
        $support = User::updateOrCreate(
            ['email' => 'support@greenstudio.com'],
            [
                'name'        => 'Green Studio Support',
                'email'       => 'support@greenstudio.com',
                'password'    => Hash::make('support123'),
                'role'        => 'support',
                'is_approved' => true,
                'company_id'  => $company->id,
            ]
        );

        // 4. Create Customers (Local & Interstate)
        $customer1 = Customer::updateOrCreate(
            ['phone' => '9835012345'],
            [
                'name'         => 'Rajesh Kumar',
                'company_name' => 'Maa Durga Electronics',
                'phone'        => '9835012345',
                'email'        => 'maadurga.khg@gmail.com',
                'gst_number'   => '10AABCM1234F1Z5',
                'state'        => 'Bihar',
                'address'      => 'Station Road, Khagaria, Bihar - 851204',
            ]
        );

        $customer2 = Customer::updateOrCreate(
            ['phone' => '9431098765'],
            [
                'name'         => 'Vikram Singh',
                'company_name' => 'Singh Infotech Services',
                'phone'        => '9431098765',
                'email'        => 'singhinfotech.patna@gmail.com',
                'gst_number'   => '10AAACS5678Q1Z2',
                'state'        => 'Bihar',
                'address'      => 'Boring Road, Patna, Bihar - 800001',
            ]
        );

        $customer3 = Customer::updateOrCreate(
            ['phone' => '9830054321'],
            [
                'name'         => 'Sourav Mukherjee',
                'company_name' => 'Eastern Media Productions',
                'phone'        => '9830054321',
                'email'        => 'easternmedia.kolkata@gmail.com',
                'gst_number'   => '19ABCDE1234F1Z8',
                'state'        => 'West Bengal',
                'address'      => 'Park Street, Kolkata, West Bengal - 700016',
            ]
        );

        // 5. Create Sample Invoices
        // Invoice 1: Local GST (Bihar to Bihar) - Paid
        $inv1 = Invoice::updateOrCreate(
            ['invoice_number' => 'GS-2026-0001'],
            [
                'invoice_number' => 'GS-2026-0001',
                'invoice_date'   => now()->subDays(2)->format('Y-m-d'),
                'company_id'     => $company->id,
                'customer_id'    => $customer1->id,
                'created_by'     => $support->id,
                'sale_type'      => 'LOCAL',
                'taxable_amount' => 10000.00,
                'cgst_amount'    => 900.00,
                'sgst_amount'    => 900.00,
                'igst_amount'    => 0.00,
                'total_amount'   => 11800.00,
                'status'         => 'paid',
            ]
        );

        $inv1->items()->delete();
        $inv1->items()->create([
            'description' => 'Studio Photography & 4K Video Coverage Setup',
            'rate'        => 10000.00,
            'taxable'     => 10000.00,
            'gst_percent' => 18.00,
            'cgst_amount' => 900.00,
            'sgst_amount' => 900.00,
            'igst_amount' => 0.00,
            'line_total'  => 11800.00,
        ]);

        $inv1->transactions()->delete();
        $inv1->transactions()->create([
            'gateway'        => 'manual',
            'transaction_id' => 'UPI-GS-8923411',
            'amount'         => 11800.00,
            'paid_at'        => now()->subDays(2),
        ]);

        // Invoice 2: Central GST (Bihar to West Bengal) - Unpaid
        $inv2 = Invoice::updateOrCreate(
            ['invoice_number' => 'GS-2026-0002'],
            [
                'invoice_number' => 'GS-2026-0002',
                'invoice_date'   => now()->format('Y-m-d'),
                'company_id'     => $company->id,
                'customer_id'    => $customer3->id,
                'created_by'     => $admin->id,
                'sale_type'      => 'CENTRAL',
                'taxable_amount' => 25000.00,
                'cgst_amount'    => 0.00,
                'sgst_amount'    => 0.00,
                'igst_amount'    => 4500.00,
                'total_amount'   => 29500.00,
                'status'         => 'unpaid',
            ]
        );

        $inv2->items()->delete();
        $inv2->items()->create([
            'description' => 'Commercial Video Editing & Color Grading Services',
            'rate'        => 25000.00,
            'taxable'     => 25000.00,
            'gst_percent' => 18.00,
            'cgst_amount' => 0.00,
            'sgst_amount' => 0.00,
            'igst_amount' => 4500.00,
            'line_total'  => 29500.00,
        ]);

        // 6. Activity Log
        ActivityLog::create([
            'user_id'     => $admin->id,
            'user_name'   => $admin->name,
            'user_email'  => $admin->email,
            'role'        => $admin->role,
            'action'      => 'system_init',
            'module'      => 'system',
            'module_id'   => $company->id,
            'description' => 'System initialized with Green Studio company profile and credentials.',
        ]);
    }
}
