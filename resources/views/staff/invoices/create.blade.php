@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.staff')

@section('title', 'New Invoice')
@section('page_title', 'Create Invoice')

@push('styles')

<style>

.invoice-create-wrapper{
    max-width:1200px;
    margin:auto;
}

.invoice-create-card{
    border:none;
    border-radius:26px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.invoice-create-header{
    padding:28px 30px;
    border-bottom:1px solid #eef2f7;
    background:linear-gradient(to right,#ffffff,#f8fafc);
}

.invoice-create-title{
    font-size:30px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:4px;
}

.invoice-create-subtitle{
    color:#64748b;
    font-size:14px;
}

.invoice-create-body{
    padding:30px;
}

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
    box-shadow:0 0 0 4px rgba(37,99,235,.12) !important;
}

.search-card{
    border:none;
    border-radius:20px;
    background:#f8fafc;
    padding:20px;
    margin-bottom:24px;
}

.btn{
    border-radius:16px;
    font-weight:700;
    padding:11px 18px;
}

.btn-light{
    border:1px solid #dbe2ea;
}

.alert{
    border:none;
    border-radius:18px;
}

.info-box{
    background:#eff6ff;
    border:1px solid #bfdbfe;
    color:#1d4ed8;
    padding:14px 16px;
    border-radius:16px;
    font-size:13px;
    margin-top:12px;
}

@media(max-width:768px){

    .invoice-create-header{
        padding:22px;
    }

    .invoice-create-body{
        padding:22px;
    }

    .invoice-create-title{
        font-size:24px;
    }

    .btn{
        width:100%;
    }

}

</style>

@endpush

@section('content')

<div class="container-fluid py-4 px-lg-4 px-2">

    <div class="invoice-create-wrapper">

        @if($errors->any())

            <div class="alert alert-danger shadow-sm mb-4">

                Please fix the errors below.

            </div>

        @endif

        <div class="card invoice-create-card">

            {{-- HEADER --}}
            <div class="invoice-create-header">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <div class="invoice-create-title">

                            Create Invoice

                        </div>

                        <div class="invoice-create-subtitle">

                            Generate professional GST invoice

                        </div>

                    </div>

                    <a href="{{ route('staff.invoices.index') }}"
                       class="btn btn-light">

                        Back

                    </a>

                </div>

            </div>

            {{-- BODY --}}
            <div class="invoice-create-body">

                {{-- SEARCH --}}
                <div class="search-card">

                    <form method="GET"
                          action="{{ route('staff.invoices.create') }}">

                        <div class="row g-3 align-items-end">

                            <div class="col-lg-9">

                                <label class="form-label">

                                    Search Customer

                                </label>

                                <input type="text"
                                       name="customer_q"
                                       class="form-control"
                                       placeholder="Search by customer name, company or email..."
                                       value="{{ $customerSearch ?? '' }}">

                            </div>

                            <div class="col-lg-3">

                                <button class="btn btn-outline-primary w-100"
                                        type="submit">

                                    Search Customer

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

                {{-- COMPANY BANNER --}}
                <div class="p-3 mb-4 rounded-4 bg-light border d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <span class="badge bg-success text-white me-2">Billing As</span>
                        <strong class="text-dark">{{ $company->name }}</strong>
                        <span class="text-muted ms-2 small">GSTIN: <strong>{{ $company->gstin ?? 'N/A' }}</strong> | State: {{ $company->state ?? 'Bihar' }}</span>
                    </div>
                    <div class="small text-muted">
                        📍 {{ $company->address }}
                    </div>
                </div>

                {{-- FORM --}}
                <form method="POST"
                      action="{{ route('staff.invoices.store') }}">

                    @csrf

                    <div class="row g-4">

                        {{-- INVOICE NUMBER --}}
                        <div class="col-md-4">

                            <label class="form-label d-flex justify-content-between">
                                <span>Invoice Number *</span>
                                <span class="small text-muted">Auto-suggested</span>
                            </label>

                            @php
                                $suggestedInv = 'GS-' . date('Y') . '-' . str_pad((\App\Models\Invoice::max('id') + 1), 4, '0', STR_PAD_LEFT);
                            @endphp

                            <input type="text"
                                   name="invoice_number"
                                   class="form-control @error('invoice_number') is-invalid @enderror fw-semibold"
                                   value="{{ old('invoice_number', $suggestedInv) }}"
                                   placeholder="e.g. GS-2026-0001"
                                   required>

                            @error('invoice_number')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                        {{-- DATE --}}
                        <div class="col-md-4">

                            <label class="form-label">

                                Invoice Date *

                            </label>

                            <input type="date"
                                   name="invoice_date"
                                   class="form-control @error('invoice_date') is-invalid @enderror"
                                   value="{{ old('invoice_date', now()->format('Y-m-d')) }}"
                                   required>

                            @error('invoice_date')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                        {{-- CUSTOMER --}}
                        <div class="col-md-4">

                            <label class="form-label">

                                Customer *

                            </label>

                            <select name="customer_id"
                                    class="form-select @error('customer_id') is-invalid @enderror"
                                    required>

                                <option value="">

                                    Select customer

                                </option>

                                @foreach($customers as $customer)

                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>

                                        {{ $customer->company_name ?? $customer->name }}

                                        @if($customer->email)
                                            ({{ $customer->email }})
                                        @endif

                                    </option>

                                @endforeach

                            </select>

                            @error('customer_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                    {{-- INFO --}}
                    <div class="info-box">

                        Showing maximum 50 customers.
                        Use customer search above to filter customer list quickly.

                    </div>

                    {{-- ACTIONS --}}
                    <div class="d-flex justify-content-end gap-3 flex-wrap mt-4">

                        <a href="{{ route('staff.invoices.index') }}"
                           class="btn btn-light">

                            Cancel

                        </a>

                        <button type="submit"
                                class="btn btn-primary">

                            Create Invoice

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection