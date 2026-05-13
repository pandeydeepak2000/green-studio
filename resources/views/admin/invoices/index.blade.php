@extends('layouts.admin')

@section('title', 'Invoices')
@section('page_title', 'Invoices')

@section('content')

<style>

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    flex-wrap:wrap;
    margin-bottom:24px;
}

.page-title{
    font-size:28px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:4px;
}

.page-subtitle{
    font-size:14px;
    color:#64748b;
}

.filter-card{
    border:none;
    border-radius:24px;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.filter-body{
    padding:24px;
}

.form-label{
    font-size:13px;
    font-weight:700;
    color:#334155;
    margin-bottom:8px;
}

.form-control,
.form-select{
    min-height:48px;
    border-radius:14px;
    border:1px solid #dbe2ea;
    box-shadow:none !important;
}

.form-control:focus,
.form-select:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.10) !important;
}

.invoice-card{
    border:none;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.invoice-table thead{
    background:#f8fafc;
}

.invoice-table th{
    padding:16px;
    font-size:13px;
    font-weight:800;
    color:#475569;
    white-space:nowrap;
}

.invoice-table td{
    padding:18px 16px;
    vertical-align:middle;
}

.invoice-number{
    font-weight:800;
    color:#2563eb;
    font-size:14px;
}

.customer-name{
    font-weight:700;
    color:#0f172a;
}

.customer-sub{
    font-size:13px;
    color:#64748b;
}

.status-paid{
    background:#dcfce7;
    color:#15803d;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
}

.status-unpaid{
    background:#fee2e2;
    color:#dc2626;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
}

.sale-local{
    background:#dcfce7;
    color:#15803d;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
}

.sale-central{
    background:#dbeafe;
    color:#1d4ed8;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
}

.action-btn{
    border-radius:12px;
    padding:8px 14px;
    font-size:13px;
    font-weight:700;
}

.amount-text{
    font-size:15px;
    font-weight:800;
    color:#0f172a;
}

.empty-box{
    padding:70px 20px;
    text-align:center;
}

.empty-title{
    font-size:20px;
    font-weight:800;
    color:#0f172a;
    margin-top:14px;
}

.empty-subtitle{
    color:#64748b;
    font-size:14px;
}

@media(max-width:768px){

    .page-title{
        font-size:22px;
    }

    .invoice-table th,
    .invoice-table td{
        white-space:nowrap;
    }

}

</style>

@if(session('status'))

    <div class="alert alert-success border-0 rounded-4 shadow-sm">

        {{ session('status') }}

    </div>

@endif

{{-- HEADER --}}
<div class="page-header">

    <div>

        <div class="page-title">

            Invoice Management

        </div>

        <div class="page-subtitle">

            All invoices created by staff and admin

        </div>

    </div>

</div>

{{-- FILTERS --}}
<div class="card filter-card mb-4">

    <div class="filter-body">

        <form method="GET"
              action="{{ route('admin.invoices.index') }}">

            <div class="row g-4">

                {{-- SEARCH --}}
                <div class="col-lg-4">

                    <label class="form-label">

                        Search Invoice

                    </label>

                    <input type="text"
                           name="q"
                           class="form-control"
                           placeholder="Invoice no, customer..."
                           value="{{ $search ?? '' }}">

                </div>

                {{-- FROM --}}
                <div class="col-lg-2 col-md-4">

                    <label class="form-label">

                        From Date

                    </label>

                    <input type="date"
                           name="from"
                           class="form-control"
                           value="{{ $from ?? '' }}">

                </div>

                {{-- TO --}}
                <div class="col-lg-2 col-md-4">

                    <label class="form-label">

                        To Date

                    </label>

                    <input type="date"
                           name="to"
                           class="form-control"
                           value="{{ $to ?? '' }}">

                </div>

                {{-- STATUS --}}
                <div class="col-lg-2 col-md-4">

                    <label class="form-label">

                        Payment Status

                    </label>

                    <select name="status"
                            class="form-select">

                        <option value="">
                            All
                        </option>

                        <option value="paid"
                            {{ ($status ?? '') === 'paid' ? 'selected' : '' }}>

                            Paid

                        </option>

                        <option value="unpaid"
                            {{ ($status ?? '') === 'unpaid' ? 'selected' : '' }}>

                            Unpaid

                        </option>

                    </select>

                </div>

                {{-- SORT --}}
                <div class="col-lg-2 col-md-4">

                    <label class="form-label">

                        Sort

                    </label>

                    <select name="sort"
                            class="form-select">

                        <option value="newest"
                            {{ ($sort ?? '') === 'newest' ? 'selected' : '' }}>

                            Newest

                        </option>

                        <option value="oldest"
                            {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>

                            Oldest

                        </option>

                    </select>

                </div>

            </div>

            <div class="mt-4">

                <button type="submit"
                        class="btn btn-dark action-btn">

                    Apply Filters

                </button>

            </div>

        </form>

    </div>

</div>

{{-- TABLE --}}
<div class="card invoice-card">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0 invoice-table">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>Invoice</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Company</th>
                        <th>Sale Type</th>
                        <th>Status</th>
                        <th class="text-end">Amount</th>
                        <th class="text-end">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($invoices as $invoice)

                        <tr>

                            {{-- SERIAL --}}
                            <td>

                                {{ $invoices->firstItem() + $loop->index }}

                            </td>

                            {{-- INVOICE --}}
                            <td>

                                <div class="invoice-number">

                                    {{ $invoice->invoice_number }}

                                </div>

                            </td>

                            {{-- DATE --}}
                            <td>

                                {{ optional($invoice->invoice_date)->format('d-m-Y') }}

                            </td>

                            {{-- CUSTOMER --}}
                            <td>

                                <div class="customer-name">

                                    {{ $invoice->customer->company_name
                                        ?? $invoice->customer->name
                                        ?? '-' }}

                                </div>

                                @if($invoice->customer?->name &&
                                    $invoice->customer?->company_name)

                                    <div class="customer-sub">

                                        {{ $invoice->customer->name }}

                                    </div>

                                @endif

                            </td>

                            {{-- COMPANY --}}
                            <td>

                                {{ $invoice->company->name ?? '-' }}

                            </td>

                            {{-- SALE TYPE --}}
                            <td>

                                @if($invoice->sale_type === 'LOCAL')

                                    <span class="sale-local">

                                        LOCAL

                                    </span>

                                @elseif($invoice->sale_type === 'CENTRAL')

                                    <span class="sale-central">

                                        CENTRAL

                                    </span>

                                @else

                                    -

                                @endif

                            </td>

                            {{-- STATUS --}}
                            <td>

                                @if($invoice->status === 'paid')

                                    <span class="status-paid">

                                        PAID

                                    </span>

                                @else

                                    <span class="status-unpaid">

                                        UNPAID

                                    </span>

                                @endif

                            </td>

                            {{-- AMOUNT --}}
                            <td class="text-end">

                                <div class="amount-text">

                                    ₹{{ number_format($invoice->total_amount, 2) }}

                                </div>

                            </td>

                            {{-- ACTIONS --}}
                            <td class="text-end">

                                <a href="{{ route('admin.invoices.show', $invoice) }}"
                                   class="btn btn-outline-dark action-btn">

                                    View

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9">

                                <div class="empty-box">

                                    <div style="font-size:50px;">

                                        🧾

                                    </div>

                                    <div class="empty-title">

                                        No Invoices Found

                                    </div>

                                    <div class="empty-subtitle">

                                        No invoice records available right now.

                                    </div>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    @if($invoices->hasPages())

        <div class="card-footer bg-white border-0 py-3">

            {{ $invoices->withQueryString()->links() }}

        </div>

    @endif

</div>

@endsection