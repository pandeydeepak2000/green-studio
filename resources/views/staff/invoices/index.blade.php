@extends('layouts.staff')

@section('title', 'Invoices')
@section('page_title', 'Invoices')

@push('styles')

<style>

.invoice-page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    flex-wrap:wrap;
    margin-bottom:24px;
}

.invoice-page-title{
    font-size:30px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:4px;
}

.invoice-page-subtitle{
    color:#64748b;
    font-size:14px;
}

.invoice-card{
    border:none;
    border-radius:26px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.invoice-card .card-body{
    padding:24px;
}

.filter-card{
    border:none;
    border-radius:24px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.filter-card .card-body{
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
    min-height:50px;
    border-radius:16px;
    border:1px solid #dbe2ea;
    box-shadow:none !important;
}

.form-control:focus,
.form-select:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.12) !important;
}

.btn{
    border-radius:16px;
    font-weight:700;
    padding:11px 18px;
}

.invoice-table{
    margin-bottom:0;
}

.invoice-table thead{
    background:#f8fafc;
}

.invoice-table th{
    font-size:13px;
    font-weight:700;
    color:#475569;
    white-space:nowrap;
    border-bottom:1px solid #e5e7eb;
    padding:16px;
}

.invoice-table td{
    padding:16px;
    vertical-align:middle;
    font-size:14px;
}

.invoice-number{
    font-weight:800;
    color:#2563eb;
}

.customer-name{
    font-weight:700;
    color:#0f172a;
}

.customer-sub{
    color:#64748b;
    font-size:12px;
    margin-top:4px;
}

.status-badge{
    font-size:11px;
    padding:7px 12px;
    border-radius:999px;
    font-weight:700;
}

.amount-text{
    font-size:15px;
    font-weight:800;
    color:#0f172a;
}

.action-group{
    display:flex;
    justify-content:flex-end;
    gap:8px;
    flex-wrap:wrap;
}

.action-group .btn{
    border-radius:12px;
    font-size:13px;
    padding:8px 14px;
}

.table-responsive{
    overflow:auto;
}

.table-responsive::-webkit-scrollbar{
    height:5px;
}

.table-responsive::-webkit-scrollbar-thumb{
    background:#cbd5e1;
    border-radius:999px;
}

.empty-state{
    padding:70px 20px;
    text-align:center;
}

.empty-icon{
    font-size:54px;
    margin-bottom:14px;
}

.empty-title{
    font-size:22px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:8px;
}

.empty-subtitle{
    color:#64748b;
    font-size:14px;
    max-width:420px;
    margin:auto;
    line-height:1.7;
}

.pagination{
    margin-bottom:0;
}

.page-link{
    border-radius:10px !important;
    margin:0 3px;
    border:none;
    color:#334155;
    font-weight:600;
}

.page-item.active .page-link{
    background:#2563eb;
}

@media(max-width:768px){

    .invoice-page-title{
        font-size:24px;
    }

    .invoice-card,
    .filter-card{
        border-radius:20px;
    }

    .invoice-card .card-body,
    .filter-card .card-body{
        padding:18px;
    }

    .btn{
        width:100%;
    }

    .invoice-table td,
    .invoice-table th{
        white-space:nowrap;
    }

    .action-group{
        justify-content:flex-start;
    }

}

</style>

@endpush

@section('content')

<div class="container-fluid py-4 px-lg-4 px-2">

    @if(session('status'))

        <div class="alert alert-success border-0 shadow-sm rounded-4">

            {{ session('status') }}

        </div>

    @endif

    {{-- HEADER --}}
    <div class="invoice-page-header">

        <div>

            <div class="invoice-page-title">

                Invoices

            </div>

            <div class="invoice-page-subtitle">

                Manage and track all GST invoices easily

            </div>

        </div>

        <a href="{{ route('staff.invoices.create') }}"
           class="btn btn-primary">

            + New Invoice

        </a>

    </div>

    {{-- FILTER --}}
    <div class="card filter-card mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('staff.invoices.index') }}">

                <div class="row g-3 align-items-end">

                    {{-- SEARCH --}}
                    <div class="col-lg-4">

                        <label class="form-label">

                            Search

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

                            From

                        </label>

                        <input type="date"
                               name="from"
                               class="form-control"
                               value="{{ $from ?? '' }}">

                    </div>

                    {{-- TO --}}
                    <div class="col-lg-2 col-md-4">

                        <label class="form-label">

                            To

                        </label>

                        <input type="date"
                               name="to"
                               class="form-control"
                               value="{{ $to ?? '' }}">

                    </div>

                    {{-- STATUS --}}
                    <div class="col-lg-2 col-md-4">

                        <label class="form-label">

                            Status

                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="">

                                All

                            </option>

                            <option value="draft"
                                {{ ($status ?? '') === 'draft' ? 'selected' : '' }}>

                                Draft

                            </option>

                            <option value="unpaid"
                                {{ ($status ?? '') === 'unpaid' ? 'selected' : '' }}>

                                Unpaid

                            </option>

                            <option value="paid"
                                {{ ($status ?? '') === 'paid' ? 'selected' : '' }}>

                                Paid

                            </option>

                        </select>

                    </div>

                    {{-- BUTTON --}}
                    <div class="col-lg-2">

                        <button type="submit"
                                class="btn btn-dark w-100">

                            Apply Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="card invoice-card">

        <div class="table-responsive">

            <table class="table table-hover align-middle invoice-table">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>Invoice No</th>
                        <th>Date</th>
                        <th>Customer</th>
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

                                {{ $loop->iteration }}

                            </td>

                            {{-- NUMBER --}}
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

                                @if($invoice->customer?->name)

                                    <div class="customer-sub">

                                        {{ $invoice->customer->name }}

                                    </div>

                                @endif

                            </td>

                            {{-- SALE TYPE --}}
                            <td>

                                @if($invoice->sale_type === 'LOCAL')

                                    <span class="badge bg-success status-badge">

                                        LOCAL

                                    </span>

                                @elseif($invoice->sale_type === 'CENTRAL')

                                    <span class="badge bg-primary status-badge">

                                        CENTRAL

                                    </span>

                                @else

                                    -

                                @endif

                            </td>

                            {{-- STATUS --}}
                            <td>

                                @if($invoice->status === 'paid')

                                    <span class="badge bg-success status-badge">

                                        PAID

                                    </span>

                                @elseif($invoice->status === 'unpaid')

                                    <span class="badge bg-danger status-badge">

                                        UNPAID

                                    </span>

                                @else

                                    <span class="badge bg-secondary status-badge">

                                        DRAFT

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

                                <div class="action-group">

                                    <a href="{{ route('staff.invoices.show', $invoice) }}"
                                       class="btn btn-outline-dark">

                                        View

                                    </a>

                                    <a href="{{ route('staff.invoices.edit', $invoice) }}"
                                       class="btn btn-primary">

                                        Edit

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8">

                                <div class="empty-state">

                                    <div class="empty-icon">
                                        🧾
                                    </div>

                                    <div class="empty-title">

                                        No invoices found

                                    </div>

                                    <div class="empty-subtitle">

                                        Start by creating your first GST invoice.

                                    </div>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($invoices->hasPages())

            <div class="card-footer bg-white border-0 py-3">

                {{ $invoices->withQueryString()->links() }}

            </div>

        @endif

    </div>

</div>

@endsection