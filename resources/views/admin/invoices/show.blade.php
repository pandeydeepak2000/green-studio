@extends('layouts.admin')

@section('title', 'Invoice #' . $invoice->invoice_number)
@section('page_title', 'Invoice #' . $invoice->invoice_number)

@section('content')

<style>

.invoice-wrapper{
    max-width:1100px;
    margin:auto;
}

.invoice-card{
    border:none;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.invoice-header{
    padding:32px;
    background:#f8fafc;
    border-bottom:1px solid #eef2f7;
}

.invoice-title{
    font-size:30px;
    font-weight:900;
    color:#0f172a;
}

.invoice-subtitle{
    font-size:14px;
    color:#64748b;
}

.invoice-body{
    padding:32px;
}

.info-card{
    border:1px solid #eef2f7;
    border-radius:22px;
    padding:22px;
    height:100%;
    background:#fff;
}

.info-title{
    font-size:13px;
    font-weight:800;
    color:#64748b;
    text-transform:uppercase;
    letter-spacing:.08em;
    margin-bottom:14px;
}

.info-value{
    font-size:15px;
    font-weight:700;
    color:#0f172a;
    line-height:1.8;
}

.status-paid{
    background:#dcfce7;
    color:#15803d;
    padding:8px 16px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
}

.status-unpaid{
    background:#fee2e2;
    color:#dc2626;
    padding:8px 16px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
}

.invoice-table{
    border-radius:20px;
    overflow:hidden;
}

.invoice-table th{
    background:#f8fafc;
    font-size:13px;
    font-weight:800;
    color:#475569;
    padding:16px;
    white-space:nowrap;
}

.invoice-table td{
    padding:16px;
    vertical-align:middle;
}

.total-box{
    border:1px solid #eef2f7;
    border-radius:22px;
    overflow:hidden;
}

.total-box .table td,
.total-box .table th{
    padding:16px 20px;
    font-size:14px;
}

.grand-total{
    background:#f8fafc;
    font-size:18px !important;
    font-weight:900 !important;
}

.action-btn{
    border-radius:16px;
    min-height:48px;
    padding:0 22px;
    font-weight:700;
}

@media(max-width:768px){

    .invoice-header{
        padding:24px;
    }

    .invoice-body{
        padding:22px;
    }

    .invoice-title{
        font-size:24px;
    }

}

@media print{

    .btn,
    .topbar,
    .sidebar{
        display:none !important;
    }

    body{
        background:#fff !important;
    }

    .invoice-card{
        box-shadow:none !important;
        border:none !important;
    }

    .main-wrapper{
        margin:0 !important;
    }

}

</style>

<div class="invoice-wrapper">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Invoice Details

            </h3>

            <div class="text-muted">

                Invoice overview and payment details

            </div>

        </div>

        <div class="d-flex gap-2 flex-wrap">

            <button onclick="window.print()"
                    class="btn btn-dark action-btn">

                Print Invoice

            </button>

            <a href="{{ route('admin.invoices.index') }}"
               class="btn btn-light border action-btn">

                Back

            </a>

        </div>

    </div>

    <div class="card invoice-card">

        {{-- HEADER --}}
        <div class="invoice-header">

            <div class="d-flex justify-content-between align-items-start flex-wrap gap-4">

                <div>

                    <div class="invoice-title">

                        {{ $invoice->company->name ?? 'Company' }}

                    </div>

                    <div class="invoice-subtitle mt-2">

                        GST Invoice Management System

                    </div>

                </div>

                <div class="text-md-end">

                    <div class="fw-bold fs-4">

                        Invoice

                    </div>

                    <div class="text-muted mt-2">

                        #{{ $invoice->invoice_number }}

                    </div>

                </div>

            </div>

        </div>

        {{-- BODY --}}
        <div class="invoice-body">

            {{-- INFO ROW --}}
            <div class="row g-4 mb-4">

                {{-- COMPANY --}}
                <div class="col-lg-4">

                    <div class="info-card">

                        <div class="info-title">

                            Company Details

                        </div>

                        <div class="info-value">

                            {{ $invoice->company->name ?? '-' }}<br>

                            {{ $invoice->company->address ?? '-' }}<br>

                            GSTIN:
                            {{ $invoice->company->gstin ?? '-' }}

                        </div>

                    </div>

                </div>

                {{-- CUSTOMER --}}
                <div class="col-lg-4">

                    <div class="info-card">

                        <div class="info-title">

                            Customer Details

                        </div>

                        <div class="info-value">

                            {{ $invoice->customer->company_name
                                ?? $invoice->customer->name
                                ?? '-' }}<br>

                            {{ $invoice->customer->address ?? '-' }}<br>

                            GST:
                            {{ $invoice->customer->gst_number ?? '-' }}

                        </div>

                    </div>

                </div>

                {{-- INVOICE --}}
                <div class="col-lg-4">

                    <div class="info-card">

                        <div class="info-title">

                            Invoice Information

                        </div>

                        <div class="info-value">

                            Invoice No:
                            {{ $invoice->invoice_number }}<br>

                            Date:
                            {{ optional($invoice->invoice_date)->format('d-m-Y') }}<br>

                            Sale Type:
                            {{ $invoice->sale_type }}

                            <div class="mt-3">

                                @if($invoice->status === 'paid')

                                    <span class="status-paid">

                                        PAID

                                    </span>

                                @else

                                    <span class="status-unpaid">

                                        UNPAID

                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ITEMS --}}
            <div class="table-responsive mb-4">

                <table class="table invoice-table align-middle mb-0">

                    <thead>

                        <tr>

                            <th>#</th>
                            <th>Description</th>
                            <th class="text-end">Rate</th>
                            <th class="text-end">GST %</th>
                            <th class="text-end">Amount</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($invoice->items as $item)

                            <tr>

                                <td>

                                    {{ $loop->iteration }}

                                </td>

                                <td>

                                    {{ $item->description }}

                                </td>

                                <td class="text-end">

                                    ₹{{ number_format($item->rate, 2) }}

                                </td>

                                <td class="text-end">

                                    {{ number_format($item->gst_percent, 2) }}%

                                </td>

                                <td class="text-end fw-bold">

                                    ₹{{ number_format($item->line_total, 2) }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            {{-- TOTAL --}}
            <div class="row justify-content-end">

                <div class="col-lg-5">

                    <div class="total-box">

                        <table class="table mb-0">

                            <tr>

                                <th>

                                    Taxable Amount

                                </th>

                                <td class="text-end">

                                    ₹{{ number_format($invoice->taxable_amount, 2) }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    CGST

                                </th>

                                <td class="text-end">

                                    ₹{{ number_format($invoice->cgst_amount, 2) }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    SGST

                                </th>

                                <td class="text-end">

                                    ₹{{ number_format($invoice->sgst_amount, 2) }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    IGST

                                </th>

                                <td class="text-end">

                                    ₹{{ number_format($invoice->igst_amount, 2) }}

                                </td>

                            </tr>

                            <tr class="grand-total">

                                <th>

                                    Grand Total

                                </th>

                                <td class="text-end">

                                    ₹{{ number_format($invoice->total_amount, 2) }}

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection