<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Company;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('gst_number', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('name')->paginate(15);

        if (auth()->check() && auth()->user()->role === 'admin') {
            return view('admin.customers.index', compact('customers', 'search'));
        }

        return view('staff.customers.index', compact('customers', 'search'));
    }

    public function create()
    {
        $company = Company::where('is_default', true)->first();

        if (auth()->check() && auth()->user()->role === 'admin') {
            return view('admin.customers.create', compact('company'));
        }

        return view('staff.customers.create', compact('company'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:50'],
            'email'        => ['nullable', 'email', 'max:255'],
            'gst_number'   => ['nullable', 'string', 'max:50'],
            'state'        => ['required', 'string', 'max:100'],
            'address'      => ['nullable', 'string', 'max:500'],
        ]);

        Customer::create($data);

        if (auth()->check() && auth()->user()->role === 'admin') {
            $route = 'customers.index';
        } else {
            $route = 'staff.customers.index';
        }

        return redirect()->route($route)
            ->with('status', 'Customer created successfully.');
    }

    public function edit(Customer $customer)
    {
        $company = Company::where('is_default', true)->first();

        if (auth()->check() && auth()->user()->role === 'admin') {
            return view('admin.customers.edit', compact('customer', 'company'));
        }

        return view('staff.customers.edit', compact('customer', 'company'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:50'],
            'email'        => ['nullable', 'email', 'max:255'],
            'gst_number'   => ['nullable', 'string', 'max:50'],
            'state'        => ['required', 'string', 'max:100'],
            'address'      => ['nullable', 'string', 'max:500'],
        ]);

        $customer->update($data);

        if (auth()->check() && auth()->user()->role === 'admin') {
            $route = 'customers.index';
        } else {
            $route = 'staff.customers.index';
        }

        return redirect()->route($route)
            ->with('status', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        if (auth()->check() && auth()->user()->role === 'admin') {
            $route = 'customers.index';
        } else {
            $route = 'staff.customers.index';
        }

        return redirect()->route($route)
            ->with('status', 'Customer deleted.');
    }
}