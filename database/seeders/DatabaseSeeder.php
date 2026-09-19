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

        // 4. Activity Log - Clean Initialization
        ActivityLog::create([
            'user_id'     => $admin->id,
            'user_name'   => $admin->name,
            'user_email'  => $admin->email,
            'role'        => $admin->role,
            'action'      => 'system_init',
            'module'      => 'system',
            'module_id'   => $company->id,
            'description' => 'Green Studio Invoicing system initialized cleanly. Ready for real transactions.',
        ]);
    }
}
