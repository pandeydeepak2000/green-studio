@php

    $editing = !empty($company);

@endphp

<style>

.form-label{
    font-size:13px;
    font-weight:700;
    color:#334155;
    margin-bottom:8px;
}

.form-control,
.form-select{
    min-height:52px;
    border-radius:16px;
    border:1px solid #dbe2ea;
    box-shadow:none !important;
}

.form-control:focus,
.form-select:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.10) !important;
}

textarea.form-control{
    min-height:110px;
    resize:vertical;
}

.logo-preview{
    max-height:70px;
    border-radius:14px;
    border:1px solid #e2e8f0;
    padding:6px;
    background:#fff;
}

.form-section-title{
    font-size:16px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:18px;
}

.form-check-input{
    width:20px;
    height:20px;
}

.form-check-label{
    padding-top:2px;
    font-size:14px;
    color:#334155;
}

.action-btn{
    border-radius:16px;
    min-height:50px;
    padding:0 24px;
    font-weight:700;
}

.info-box{
    background:#f8fafc;
    border:1px solid #eef2f7;
    border-radius:18px;
    padding:18px;
}

</style>

<div class="row g-4">

    {{-- BASIC INFO --}}
    <div class="col-12">

        <div class="form-section-title">

            Basic Information

        </div>

    </div>

    <div class="col-md-6">

        <label class="form-label">

            Company Name *

        </label>

        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $company->name ?? '') }}"
               placeholder="Enter company name"
               required>

        @error('name')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    <div class="col-md-6">

        <label class="form-label">

            GSTIN

        </label>

        <input type="text"
               name="gstin"
               class="form-control @error('gstin') is-invalid @enderror"
               value="{{ old('gstin', $company->gstin ?? '') }}"
               placeholder="Enter GSTIN">

        @error('gstin')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    <div class="col-md-6">

        <label class="form-label">

            State

        </label>

        <input type="text"
               name="state"
               class="form-control @error('state') is-invalid @enderror"
               value="{{ old('state', $company->state ?? '') }}"
               placeholder="Enter state">

        @error('state')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    <div class="col-md-6">

        <label class="form-label">

            State Code

        </label>

        <input type="text"
               name="state_code"
               class="form-control @error('state_code') is-invalid @enderror"
               value="{{ old('state_code', $company->state_code ?? '') }}"
               placeholder="Enter state code">

        @error('state_code')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    <div class="col-12">

        <label class="form-label">

            Address

        </label>

        <textarea name="address"
                  class="form-control @error('address') is-invalid @enderror"
                  placeholder="Enter company address">{{ old('address', $company->address ?? '') }}</textarea>

        @error('address')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    {{-- CONTACT --}}
    <div class="col-12 mt-2">

        <div class="form-section-title">

            Contact Details

        </div>

    </div>

    <div class="col-md-6">

        <label class="form-label">

            Phone Number

        </label>

        <input type="text"
               name="phone"
               class="form-control @error('phone') is-invalid @enderror"
               value="{{ old('phone', $company->phone ?? '') }}"
               placeholder="Enter phone number">

        @error('phone')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    <div class="col-md-6">

        <label class="form-label">

            Email Address

        </label>

        <input type="email"
               name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $company->email ?? '') }}"
               placeholder="Enter email address">

        @error('email')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    {{-- BANK --}}
    <div class="col-12 mt-2">

        <div class="form-section-title">

            Bank Details

        </div>

    </div>

    <div class="col-md-6">

        <label class="form-label">

            Bank Name

        </label>

        <input type="text"
               name="bank_name"
               class="form-control @error('bank_name') is-invalid @enderror"
               value="{{ old('bank_name', $company->bank_name ?? '') }}"
               placeholder="Enter bank name">

    </div>

    <div class="col-md-6">

        <label class="form-label">

            Account Number

        </label>

        <input type="text"
               name="bank_account"
               class="form-control @error('bank_account') is-invalid @enderror"
               value="{{ old('bank_account', $company->bank_account ?? '') }}"
               placeholder="Enter account number">

    </div>

    <div class="col-md-6">

        <label class="form-label">

            IFSC Code

        </label>

        <input type="text"
               name="bank_ifsc"
               class="form-control @error('bank_ifsc') is-invalid @enderror"
               value="{{ old('bank_ifsc', $company->bank_ifsc ?? '') }}"
               placeholder="Enter IFSC code">

    </div>

    <div class="col-md-6">

        <label class="form-label">

            Branch Name

        </label>

        <input type="text"
               name="bank_branch"
               class="form-control @error('bank_branch') is-invalid @enderror"
               value="{{ old('bank_branch', $company->bank_branch ?? '') }}"
               placeholder="Enter branch name">

    </div>

    {{-- LOGO --}}
    <div class="col-12 mt-2">

        <div class="form-section-title">

            Branding & Invoice Settings

        </div>

    </div>

    <div class="col-md-6">

        <label class="form-label">

            Company Logo

        </label>

        <input type="file"
               name="logo"
               class="form-control @error('logo') is-invalid @enderror">

        @error('logo')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

        @if(!empty($company?->logo_path))

            <div class="mt-3">

                <img src="{{ asset('storage/'.$company->logo_path) }}"
                     class="logo-preview"
                     alt="Logo">

            </div>

        @endif

    </div>

    <div class="col-md-6">

        <div class="info-box">

            <div class="form-check mb-3">

                <input class="form-check-input"
                       type="checkbox"
                       name="show_logo_on_invoice"
                       id="show_logo_on_invoice"
                       value="1"
                       @checked(old('show_logo_on_invoice', $company->show_logo_on_invoice ?? true))>

                <label class="form-check-label"
                       for="show_logo_on_invoice">

                    Show logo on invoice

                </label>

            </div>

            <div class="form-check">

                <input class="form-check-input"
                       type="checkbox"
                       name="is_default"
                       id="is_default"
                       value="1"
                       @checked(old('is_default', $company->is_default ?? false))>

                <label class="form-check-label"
                       for="is_default">

                    Set as default company

                </label>

            </div>

        </div>

    </div>

    {{-- ACTIONS --}}
    <div class="col-12 pt-3">

        <div class="d-flex gap-3 flex-wrap">

            <button type="submit"
                    class="btn btn-primary action-btn">

                {{ $editing ? 'Update Company' : 'Save Company' }}

            </button>

            <a href="{{ route('companies.index') }}"
               class="btn btn-light border action-btn">

                Cancel

            </a>

        </div>

    </div>

</div>