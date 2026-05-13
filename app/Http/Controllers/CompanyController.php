<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::orderByDesc('is_default')
            ->orderBy('name')
            ->get();

        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'gstin'             => ['nullable', 'string', 'max:50'],
            'state'             => ['nullable', 'string', 'max:100'],
            'state_code'        => ['nullable', 'string', 'max:10'],
            'address'           => ['nullable', 'string', 'max:500'],
            'phone'             => ['nullable', 'string', 'max:50'],
            'email'             => ['nullable', 'email', 'max:255'],
            'bank_name'         => ['nullable', 'string', 'max:255'],
            'bank_account'      => ['nullable', 'string', 'max:100'],
            'bank_ifsc'         => ['nullable', 'string', 'max:50'],
            'bank_branch'       => ['nullable', 'string', 'max:255'],
            'logo'              => ['nullable', 'image', 'max:2048'],
            'is_default'        => ['nullable', 'boolean'],
            'show_logo_on_invoice' => ['nullable', 'boolean'],
        ]);

        // Agar nayi company default hai to baaki ka default hata do
        if ($request->boolean('is_default')) {
            Company::where('is_default', true)->update(['is_default' => false]);
        }

        // Logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo_path'] = $path;
        }

        // Checkbox ko proper boolean banado
        $data['is_default'] = $request->boolean('is_default');
        $data['show_logo_on_invoice'] = $request->boolean('show_logo_on_invoice');

        Company::create($data);

        return redirect()
            ->route('companies.index')
            ->with('status', 'Company created successfully.');
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'gstin'             => ['nullable', 'string', 'max:50'],
            'state'             => ['nullable', 'string', 'max:100'],
            'state_code'        => ['nullable', 'string', 'max:10'],
            'address'           => ['nullable', 'string', 'max:500'],
            'phone'             => ['nullable', 'string', 'max:50'],
            'email'             => ['nullable', 'email', 'max:255'],
            'bank_name'         => ['nullable', 'string', 'max:255'],
            'bank_account'      => ['nullable', 'string', 'max:100'],
            'bank_ifsc'         => ['nullable', 'string', 'max:50'],
            'bank_branch'       => ['nullable', 'string', 'max:255'],
            'logo'              => ['nullable', 'image', 'max:2048'],
            'is_default'        => ['nullable', 'boolean'],
            'show_logo_on_invoice' => ['nullable', 'boolean'],
        ]);

        // Agar ye company default ban rahi hai to baaki ka default hata do
        if ($request->boolean('is_default')) {
            Company::where('is_default', true)
                ->where('id', '!=', $company->id)
                ->update(['is_default' => false]);
        }

        // Logo update
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo_path'] = $path;
        }

        // Checkbox boolean
        $data['is_default'] = $request->boolean('is_default');
        $data['show_logo_on_invoice'] = $request->boolean('show_logo_on_invoice');

        $company->update($data);

        return redirect()
            ->route('companies.index')
            ->with('status', 'Company updated successfully.');
    }
}