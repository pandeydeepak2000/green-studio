@extends('layouts.staff')

@section('title', 'Invoice #' . $invoice->invoice_number)
@section('page_title', 'Invoice')

@push('styles')

<style>

@media print {

    @page{
        size:A4 portrait;
        margin:8mm;
    }

    html,
    body{
        width:210mm;
        min-height:297mm;
        background:#fff !important;
        -webkit-print-color-adjust:exact !important;
        print-color-adjust:exact !important;
        overflow:visible !important;
    }

    body{
        margin:0 !important;
        padding:0 !important;
        zoom:0.92;
    }

    .no-print,
    .sidebar,
    .topbar,
    .btn{
        display:none !important;
    }

    .main-wrapper{
        margin:0 !important;
        padding:0 !important;
    }

    .container-fluid{
        width:100% !important;
        max-width:100% !important;
        padding:0 !important;
        margin:0 !important;
    }

    .invoice-container{
        width:100% !important;
        max-width:100% !important;
        border:none !important;
        box-shadow:none !important;
        border-radius:0 !important;
        margin:0 auto !important;
        padding:0 !important;
        overflow:hidden !important;
        page-break-inside:avoid !important;
    }

    .row{
        display:flex !important;
        flex-wrap:nowrap !important;
    }

    .col-md-7{
        width:58% !important;
        flex:0 0 58% !important;
        max-width:58% !important;
    }

    .col-md-5{
        width:42% !important;
        flex:0 0 42% !important;
        max-width:42% !important;
    }

    .invoice-top-box{
        max-width:100% !important;
        margin-top:0 !important;
        margin-left:auto !important;
    }

    .invoice-ribbon{
        top:14px !important;
        right:-58px !important;
    }

    .company-title{
        font-size:24px !important;
    }

    .invoice-table th,
    .invoice-table td{
        padding:10px !important;
        font-size:12px !important;
    }

    .total-box{
        padding:14px !important;
    }

    .grand-total{
        font-size:22px !important;
    }

    .section-title{
        font-size:16px !important;
        margin-bottom:10px !important;
    }

    .invoice-footer{
        margin-top:18px !important;
        padding-top:10px !important;
        font-size:11px !important;
    }

    table,
    tr,
    td,
    th{
        page-break-inside:avoid !important;
    }

}

.invoice-container{
    position:relative;
    overflow:hidden;
    background:#fff;
    border-radius:28px;
    border:1px solid #eef2f7;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.invoice-ribbon{
    position:absolute;
    top:22px;
    right:-58px;
    transform:rotate(45deg);
    width:180px;
    text-align:center;
    padding:7px 0;
    color:#fff;
    font-weight:800;
    font-size:12px;
    text-transform:uppercase;
    z-index:10;
    letter-spacing:.06em;
}

.ribbon-paid{
    background:#22c55e;
}

.ribbon-unpaid{
    background:#ef4444;
}

.ribbon-draft{
    background:#64748b;
}

.invoice-logo{
    max-height:52px;
    width:auto;
}

.company-title{
    font-size:28px;
    font-weight:900;
    letter-spacing:.03em;
    color:#111827;
    text-transform:uppercase;
    line-height:1.2;
}

.invoice-top-box{
    background:#f8fafc;
    border-radius:18px;
    padding:18px 20px;
    max-width:340px;
    border:1px solid #eef2f7;
}

.invoice-info-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding:7px 0;
    font-size:14px;
}

.invoice-info-label{
    font-weight:700;
    color:#334155;
    white-space:nowrap;
}

.invoice-info-value{
    text-align:right;
    color:#0f172a;
    font-weight:600;
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
    padding:15px;
    white-space:nowrap;
}

.invoice-table td{
    font-size:14px;
    padding:15px;
    vertical-align:middle;
}

.total-box{
    background:#f8fafc;
    border-radius:20px;
    padding:18px;
}

.total-box table{
    margin-bottom:0;
}

.total-box td{
    padding:8px 0;
}

.grand-total{
    font-size:24px;
    font-weight:900;
    color:#0f172a;
}

.section-title{
    font-size:18px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:16px;
}

.transaction-table th{
    background:#f8fafc;
    white-space:nowrap;
}

.invoice-footer{
    margin-top:36px;
    padding-top:14px;
    border-top:1px solid #e5e7eb;
    font-size:12px;
    color:#64748b;
}

.action-btn{
    border-radius:16px;
    font-weight:700;
    padding:11px 18px;
}

@media(max-width:768px){

    .invoice-container{
        border-radius:20px;
    }

    .invoice-ribbon{
        top:18px;
        right:-62px;
        font-size:10px;
    }

    .company-title{
        font-size:20px;
    }

    .invoice-logo{
        max-height:42px;
    }

    .invoice-table th,
    .invoice-table td{
        font-size:12px;
        white-space:nowrap;
    }

    .grand-total{
        font-size:20px;
    }

    .action-btn{
        width:100%;
    }

    .invoice-top-box{
        max-width:100%;
        margin-top:20px;
    }

}

</style>

@endpush

@section('content')

<div class="container-fluid py-lg-4 py-3 px-lg-4 px-2">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 no-print">

        <div>

            <h3 class="fw-bold mb-1">
                Invoice Details
            </h3>

            <div class="text-muted">
                Invoice #{{ $invoice->invoice_number }}
            </div>

        </div>

        <div class="d-flex gap-2 flex-wrap">

            <button onclick="setTimeout(() => window.print(), 300)"
                    class="btn btn-outline-secondary action-btn">

                Print / Download

            </button>

            <a href="{{ route('staff.invoices.edit', $invoice) }}"
               class="btn btn-primary action-btn">

                Edit Invoice

            </a>

            <a href="{{ route('staff.invoices.index') }}"
               class="btn btn-light border action-btn">

                Back

            </a>

        </div>

    </div>

    <div class="invoice-container mx-auto print-full"
         style="max-width:950px;">

        <div class="invoice-ribbon

            @if($invoice->status === 'paid')
                ribbon-paid
            @elseif($invoice->status === 'unpaid')
                ribbon-unpaid
            @else
                ribbon-draft
            @endif">

            {{ strtoupper($invoice->status) }}

        </div>

        <div class="p-lg-5 p-4">

            <div class="row align-items-start mb-4">

                <div class="col-md-7 col-12">

                    @if(
                        $invoice->company &&
                        $invoice->company->show_logo_on_invoice &&
                        $invoice->company->logo_path
                    )

                        <img src="{{ asset('storage/'.$invoice->company->logo_path) }}"
                             class="invoice-logo mb-3"
                             alt="{{ $invoice->company->name }}">

                    @endif

                    <div class="company-title mb-2">

                        {{ strtoupper($invoice->company->name) }}

                    </div>

                    <div class="text-muted small lh-lg">

                        {{ $invoice->company->address }}<br>

                        {{ $invoice->company->state }}

                    </div>

                    @if($invoice->company->gstin)

                        <div class="small mt-3">

                            <strong>GSTIN:</strong>

                            {{ $invoice->company->gstin }}

                        </div>

                    @endif

                </div>

                <div class="col-md-5 col-12">

                    <div class="invoice-top-box ms-md-auto">

                        <div class="invoice-info-row">

                            <span class="invoice-info-label">
                                Invoice No:
                            </span>

                            <span class="invoice-info-value">
                                {{ $invoice->invoice_number }}
                            </span>

                        </div>

                        <div class="invoice-info-row">

                            <span class="invoice-info-label">
                                Date:
                            </span>

                            <span class="invoice-info-value">
                                {{ optional($invoice->invoice_date)->format('d-m-Y') }}
                            </span>

                        </div>

                        @if($invoice->sale_type)

                            <div class="invoice-info-row">

                                <span class="invoice-info-label">
                                    Sale Type:
                                </span>

                                <span class="invoice-info-value">
                                    {{ strtoupper($invoice->sale_type) }}
                                </span>

                            </div>

                        @endif

                        <div class="invoice-info-row">

                            <span class="invoice-info-label">
                                Status:
                            </span>

                            <span class="invoice-info-value">

                                @if($invoice->status === 'paid')

                                    <span class="text-success fw-bold">
                                        PAID
                                    </span>

                                @elseif($invoice->status === 'unpaid')

                                    <span class="text-danger fw-bold">
                                        UNPAID
                                    </span>

                                @else

                                    <span class="text-secondary fw-bold">
                                        DRAFT
                                    </span>

                                @endif

                            </span>

                        </div>

                    </div>

                </div>

            </div>

            <div class="mb-5">

                <div class="text-uppercase text-muted small fw-bold mb-2">
                    Invoiced To
                </div>

                <div class="fw-bold fs-4">

                    {{ $invoice->customer->company_name
                        ?? $invoice->customer->name }}

                </div>

                <div class="text-muted small mt-2 lh-lg">

                    @if($invoice->customer->company_name)

                        Attn:
                        {{ $invoice->customer->name }}
                        <br>

                    @endif

                    {{ $invoice->customer->address }}<br>

                    {{ $invoice->customer->state }}

                </div>

                @if($invoice->customer->gst_number)

                    <div class="small mt-3">

                        <strong>GSTIN:</strong>

                        {{ $invoice->customer->gst_number }}

                    </div>

                @endif

            </div>

            <div class="table-responsive mb-4">

                <table class="table table-bordered invoice-table">

                    <thead>

                        <tr>

                            <th>Description</th>
                            <th width="130">Rate</th>
                            <th width="120">GST %</th>
                            <th width="160" class="text-end">Amount</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($invoice->items as $item)

                            <tr>

                                <td>

                                    <div class="fw-semibold">
                                        {{ $item->description }}
                                    </div>

                                </td>

                                <td>
                                    ₹{{ number_format($item->rate, 2) }}
                                </td>

                                <td>
                                    {{ rtrim(rtrim(number_format($item->gst_percent, 2), '0'), '.') }}%
                                </td>

                                <td class="text-end fw-bold">
                                    ₹{{ number_format($item->line_total, 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center py-5 text-muted">

                                    No items added.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="row justify-content-end">

                <div class="col-lg-4">

                    <div class="total-box">

                        <table class="w-100">

                            <tr>

                                <td class="text-muted">
                                    Taxable Amount
                                </td>

                                <td class="text-end">
                                    ₹{{ number_format($invoice->taxable_amount, 2) }}
                                </td>

                            </tr>

                            <tr>

                                <td class="text-muted">
                                    GST Amount
                                </td>

                                <td class="text-end">

                                    ₹{{ number_format(
                                        $invoice->cgst_amount +
                                        $invoice->sgst_amount +
                                        $invoice->igst_amount,
                                        2
                                    ) }}

                                </td>

                            </tr>

                            <tr>

                                <td colspan="2">
                                    <hr>
                                </td>

                            </tr>

                            <tr>

                                <td class="fw-bold">
                                    Grand Total
                                </td>

                                <td class="text-end grand-total">
                                    ₹{{ number_format($invoice->total_amount, 2) }}
                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

            <div class="mt-5">

                <div class="section-title">
                    Transaction History
                </div>

                <div class="table-responsive">

                    <table class="table table-bordered transaction-table">

                        <thead>

                            <tr>

                                <th>Date</th>
                                <th>Gateway</th>
                                <th>Transaction ID</th>
                                <th class="text-end">Amount</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($invoice->transactions as $txn)

                                <tr>

                                    <td>

                                        {{ optional($txn->paid_at)->format('d-m-Y H:i') ?? '-' }}

                                    </td>

                                    <td>

                                        {{ ucfirst($txn->gateway) }}

                                    </td>

                                    <td>

                                        {{ $txn->transaction_id }}

                                    </td>

                                    <td class="text-end fw-bold">

                                        ₹{{ number_format($txn->amount, 2) }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4"
                                        class="text-center py-4 text-muted">

                                        No transactions found for this invoice.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="invoice-footer text-center">

                This is a system-generated invoice.
                No signature required.

            </div>

        </div>

    </div>

</div>

@endsection