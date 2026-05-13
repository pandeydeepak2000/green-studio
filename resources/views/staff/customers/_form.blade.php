@php
    $companyState = $company->state ?? null;
@endphp

<style>

.customer-form-box .form-label{
    font-size:13px;
    font-weight:700;
    color:#334155;
    margin-bottom:8px;
}

.customer-form-box .form-control{
    min-height:52px;
    border-radius:16px;
    border:1px solid #dbe2ea;
    box-shadow:none !important;
    padding-left:16px;
    transition:.2s ease;
}

.customer-form-box textarea.form-control{
    min-height:120px;
    padding-top:14px;
    border-radius:18px;
}

.customer-form-box .form-control:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.12) !important;
}

.customer-form-box .form-hint{
    font-size:12px;
    color:#64748b;
    margin-top:6px;
}

.customer-form-box .invalid-feedback{
    font-size:12px;
}

.customer-form-box .btn{
    border-radius:16px;
    font-weight:700;
    padding:11px 20px;
}

.customer-form-box .btn-light{
    border:1px solid #dbe2ea;
}

.customer-form-box .section-title{
    font-size:18px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:20px;
}

.customer-form-box .field-card{
    background:#fff;
    border:1px solid #eef2f7;
    border-radius:20px;
    padding:22px;
}

.customer-form-box .action-wrapper{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:28px;
    flex-wrap:wrap;
}

@media(max-width:768px){

    .customer-form-box .field-card{
        padding:18px;
        border-radius:18px;
    }

    .customer-form-box .action-wrapper .btn{
        width:100%;
    }

}

</style>

<div class="customer-form-box">

    <div class="field-card">

        <div class="section-title">

            Customer Details

        </div>

        <div class="row g-4">

            {{-- CUSTOMER NAME --}}
            <div class="col-md-6">

                <label class="form-label">

                    Customer Name *

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

                    Phone Number *

                </label>

                <input type="text"
                       name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $customer->phone ?? '') }}"
                       placeholder="Enter phone number"
                       required>

                @error('phone')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>

            {{-- EMAIL --}}
            <div class="col-md-6">

                <label class="form-label">

                    Email Address *

                </label>

                <input type="email"
                       name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $customer->email ?? '') }}"
                       placeholder="Enter email address"
                       required>

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

                <div class="form-hint">

                    Optional GSTIN for GST billing

                </div>

                @error('gst_number')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>

            {{-- STATE --}}
            <div class="col-md-6">

                <label class="form-label">

                    State *

                </label>

                <input type="text"
                       name="state"
                       class="form-control @error('state') is-invalid @enderror"
                       value="{{ old('state', $customer->state ?? '') }}"
                       placeholder="Enter state"
                       required>

                @if($companyState)

                    <div class="form-hint">

                        Company state:
                        <strong>{{ $companyState }}</strong>

                    </div>

                @endif

                @error('state')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>

            {{-- ADDRESS --}}
            <div class="col-12">

                <label class="form-label">

                    Address *

                </label>

                <textarea
                    name="address"
                    class="form-control @error('address') is-invalid @enderror"
                    placeholder="Enter full customer address"
                    required>{{ old('address', $customer->address ?? '') }}</textarea>

                @error('address')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>

        </div>

        {{-- ACTIONS --}}
        <div class="action-wrapper">

            <a href="{{ route('staff.customers.index') }}"
               class="btn btn-light">

                Cancel

            </a>

            <button type="submit"
                    class="btn btn-primary">

                {{ isset($customer) ? 'Update Customer' : 'Save Customer' }}

            </button>

        </div>

    </div>

</div>