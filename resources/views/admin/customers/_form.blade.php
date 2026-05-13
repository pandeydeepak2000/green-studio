@php

    $companyState = $company->state ?? null;
    $editing = !empty($customer);

@endphp

<style>

.form-label{
    font-size:13px;
    font-weight:700;
    color:#334155;
    margin-bottom:8px;
}

.form-control{
    min-height:52px;
    border-radius:16px;
    border:1px solid #dbe2ea;
    box-shadow:none !important;
}

.form-control:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.10) !important;
}

textarea.form-control{
    min-height:110px;
    resize:vertical;
}

.form-section-title{
    font-size:16px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:18px;
}

.info-box{
    background:#f8fafc;
    border:1px solid #eef2f7;
    border-radius:18px;
    padding:18px;
}

.info-text{
    font-size:13px;
    color:#64748b;
    line-height:1.7;
}

.action-btn{
    border-radius:16px;
    min-height:50px;
    padding:0 24px;
    font-weight:700;
}

.required-star{
    color:#dc2626;
}

</style>

<div class="row g-4">

    {{-- BASIC INFO --}}
    <div class="col-12">

        <div class="form-section-title">

            Customer Information

        </div>

    </div>

    {{-- CUSTOMER NAME --}}
    <div class="col-md-6">

        <label class="form-label">

            Customer Name
            <span class="required-star">*</span>

        </label>

        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $customer->name ?? '') }}"
               placeholder="Enter customer name"
               required>

        @error('name')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    {{-- COMPANY NAME --}}
    <div class="col-md-6">

        <label class="form-label">

            Company Name

        </label>

        <input type="text"
               name="company_name"
               class="form-control @error('company_name') is-invalid @enderror"
               value="{{ old('company_name', $customer->company_name ?? '') }}"
               placeholder="Enter company name">

        @error('company_name')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    {{-- PHONE --}}
    <div class="col-md-6">

        <label class="form-label">

            Phone Number

        </label>

        <input type="text"
               name="phone"
               class="form-control @error('phone') is-invalid @enderror"
               value="{{ old('phone', $customer->phone ?? '') }}"
               placeholder="Enter phone number">

        @error('phone')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    {{-- EMAIL --}}
    <div class="col-md-6">

        <label class="form-label">

            Email Address

        </label>

        <input type="email"
               name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $customer->email ?? '') }}"
               placeholder="Enter email address">

        @error('email')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    {{-- GST --}}
    <div class="col-md-6">

        <label class="form-label">

            GST Number

        </label>

        <input type="text"
               name="gst_number"
               class="form-control @error('gst_number') is-invalid @enderror"
               value="{{ old('gst_number', $customer->gst_number ?? '') }}"
               placeholder="Enter GST number">

        @error('gst_number')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    {{-- STATE --}}
    <div class="col-md-6">

        <label class="form-label">

            State

        </label>

        <input type="text"
               name="state"
               class="form-control @error('state') is-invalid @enderror"
               value="{{ old('state', $customer->state ?? '') }}"
               placeholder="Enter state">

        @error('state')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    {{-- ADDRESS --}}
    <div class="col-12">

        <label class="form-label">

            Address

        </label>

        <textarea name="address"
                  class="form-control @error('address') is-invalid @enderror"
                  placeholder="Enter complete address">{{ old('address', $customer->address ?? '') }}</textarea>

        @error('address')

            <div class="invalid-feedback">

                {{ $message }}

            </div>

        @enderror

    </div>

    {{-- INFO BOX --}}
    @if($companyState)

        <div class="col-12">

            <div class="info-box">

                <div class="fw-bold mb-2">

                    Company State Information

                </div>

                <div class="info-text">

                    Your company state is
                    <strong>{{ $companyState }}</strong>.

                    GST sale type (LOCAL / CENTRAL)
                    will automatically calculate
                    based on customer state.

                </div>

            </div>

        </div>

    @endif

    {{-- BUTTONS --}}
    <div class="col-12 pt-2">

        <div class="d-flex gap-3 flex-wrap">

            <button type="submit"
                    class="btn btn-primary action-btn">

                {{ $editing ? 'Update Customer' : 'Save Customer' }}

            </button>

            <a href="{{ route('customers.index') }}"
               class="btn btn-light border action-btn">

                Cancel

            </a>

        </div>

    </div>

</div>