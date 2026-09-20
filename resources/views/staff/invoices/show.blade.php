@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.staff')

@section('title', 'Invoice #' . $invoice->invoice_number . ' - Green Studio')
@section('page_title', 'Invoice #' . $invoice->invoice_number)

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
@page {
    size: A4 portrait;
    margin: 0mm !important;
}

/* ==========================================================================
   ULTRA-PREMIUM EXECUTIVE INVOICE DESIGN
   ========================================================================== */
.invoice-page-container {
    max-width: 900px;
    margin: 0 auto;
    padding-bottom: 60px;
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    -webkit-font-smoothing: antialiased;
}

/* Control / Actions Bar */
.invoice-action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.action-btn-pill {
    font-weight: 700;
    font-size: 13.5px;
    border-radius: 9999px;
    padding: 10px 22px;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    cursor: pointer;
}

.action-btn-pill:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(15, 23, 42, 0.1);
}

/* The Paper Sheet */
.invoice-sheet {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(15, 23, 42, 0.06), 0 1px 3px rgba(15, 23, 42, 0.04);
    border: 1px solid #e2e8f0;
    padding: 38px 46px 30px;
    position: relative;
    overflow: hidden;
    color: #0f172a;
}

/* Angled Premium Ribbon in Top-Right */
.sheet-ribbon-box {
    width: 110px;
    height: 110px;
    overflow: hidden;
    position: absolute;
    top: 0;
    right: 0;
    border-top-right-radius: 20px;
    z-index: 20;
    pointer-events: none;
}

.sheet-ribbon {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.5px;
    color: #ffffff;
    text-transform: uppercase;
    text-align: center;
    line-height: 28px;
    transform: rotate(45deg);
    position: relative;
    padding: 2px 0;
    left: -5px;
    top: 26px;
    width: 150px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
}

.sheet-ribbon.ribbon-paid {
    background: linear-gradient(135deg, #16a34a, #15803d);
}

.sheet-ribbon.ribbon-unpaid {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
}

/* Header Grid */
.invoice-header-grid {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 36px;
    align-items: start;
    margin-bottom: 26px;
}

/* Brand & Green Leaf Emblem */
.brand-identity-box {
    display: flex;
    align-items: flex-start;
    gap: 16px;
}

.green-leaf-emblem {
    width: 46px;
    height: 46px;
    background: linear-gradient(135deg, #16a34a, #15803d);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);
    flex-shrink: 0;
}

.green-leaf-emblem svg {
    width: 28px;
    height: 28px;
}

.brand-title-text {
    font-size: 26px;
    font-weight: 900;
    letter-spacing: -0.5px;
    color: #0f172a;
    line-height: 1.15;
    margin-bottom: 4px;
    text-transform: uppercase;
}

.brand-address-text {
    font-size: 13.5px;
    color: #64748b;
    line-height: 1.6;
    max-width: 440px;
    margin-bottom: 6px;
}

.brand-gstin-badge {
    display: inline-flex;
    align-items: center;
    font-size: 13px;
    color: #0f172a;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 4px 10px;
    margin-top: 4px;
    font-feature-settings: "tnum";
}

.brand-gstin-badge strong {
    font-weight: 800;
    margin-right: 6px;
    color: #334155;
}

/* Meta Panel (Right Side) */
.meta-panel {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 18px 24px;
    min-width: 250px;
}

.meta-panel-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px 0;
    font-size: 13.5px;
}

.meta-panel-label {
    color: #64748b;
    font-weight: 600;
}

.meta-panel-val {
    font-weight: 800;
    color: #0f172a;
    font-feature-settings: "tnum";
}

.meta-panel-val.status-paid {
    color: #16a34a;
}

.meta-panel-val.status-unpaid {
    color: #dc2626;
}

/* Invoiced To Section */
.recipient-wrapper {
    margin-bottom: 22px;
    padding-bottom: 6px;
}

.recipient-label {
    font-size: 11.5px;
    font-weight: 800;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 6px;
}

.recipient-name {
    font-size: 20px;
    font-weight: 900;
    color: #0f172a;
    letter-spacing: -0.3px;
    margin-bottom: 4px;
    text-transform: uppercase;
}

.recipient-detail {
    font-size: 13px;
    color: #475569;
    line-height: 1.55;
}

.recipient-gstin {
    display: inline-flex;
    align-items: center;
    font-size: 12.5px;
    color: #0f172a;
    margin-top: 4px;
}

.recipient-gstin strong {
    font-weight: 800;
    margin-right: 6px;
}

/* Items Table */
.items-table-wrapper {
    margin-bottom: 22px;
    border-radius: 12px;
    overflow-x: auto;
}

.invoice-table {
    width: 100%;
    border-collapse: collapse;
}

.invoice-table thead th {
    background: #ffffff;
    color: #475569;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 14px 16px;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1.5px solid #cbd5e1;
}

.invoice-table tbody td {
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13.5px;
    color: #1e293b;
    vertical-align: middle;
}

.invoice-table tbody tr:last-child td {
    border-bottom: 1.5px solid #cbd5e1;
}

.invoice-table .col-desc {
    width: 54%;
    text-align: left;
    font-weight: 600;
    color: #0f172a;
}

.invoice-table .col-rate {
    width: 16%;
    text-align: left;
    font-feature-settings: "tnum";
}

.invoice-table .col-gst {
    width: 12%;
    text-align: left;
    font-feature-settings: "tnum";
}

.invoice-table .col-amount {
    width: 18%;
    text-align: right;
    font-weight: 800;
    color: #0f172a;
    font-feature-settings: "tnum";
}

/* Bottom Split Section: Payment Method on Left & Totals on Right */
.bottom-financial-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 36px;
    align-items: start;
    margin-bottom: 40px;
}

/* Payment Info Side Panel */
.payment-info-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 20px 24px;
    position: relative;
}

.payment-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid #edf2f7;
}

.payment-card-title {
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.8px;
    color: #64748b;
    text-transform: uppercase;
}

.payment-detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    padding: 5px 0;
}

.p-item-label {
    color: #64748b;
    font-weight: 600;
}

.p-item-val {
    color: #0f172a;
    font-weight: 700;
}

.badge-method-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #ffffff;
    color: #0f172a;
    font-weight: 700;
    font-size: 12.5px;
    padding: 5px 12px;
    border-radius: 9999px;
    border: 1px solid #cbd5e1;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
}

.badge-status-completed {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    color: #16a34a;
    font-weight: 800;
    font-size: 12px;
}

.badge-status-pending {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    color: #dc2626;
    font-weight: 800;
    font-size: 12px;
}

/* Totals Summary */
.summary-container {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 36px;
}

.summary-card {
    width: 330px;
}

.summary-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
    font-size: 14px;
}

.summary-line .s-label {
    color: #64748b;
    font-weight: 500;
}

.summary-line .s-val {
    font-weight: 700;
    color: #0f172a;
    font-feature-settings: "tnum";
}

.summary-divider {
    height: 1.5px;
    background: #cbd5e1;
    margin: 12px 0 14px;
}

.grand-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 20px;
    font-weight: 900;
    color: #0f172a;
    letter-spacing: -0.5px;
}

.grand-total-row .gt-val {
    font-size: 24px;
    color: #0f172a;
    font-feature-settings: "tnum";
}

/* Transaction History Table */
.transaction-section {
    margin-top: 18px;
    margin-bottom: 22px;
}

.transaction-section-title {
    font-size: 14px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.2px;
    margin-bottom: 10px;
}

.transaction-table {
    width: 100%;
    border-collapse: collapse;
}

.transaction-table thead th {
    background: #ffffff;
    color: #64748b;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 10px 12px;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1.5px solid #cbd5e1;
    text-align: left;
}

.transaction-table tbody td {
    padding: 10px 12px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #1e293b;
    vertical-align: middle;
}

/* Exact Mandated System Footer */
.computer-generated-footer {
    text-align: center;
    font-size: 11.5px;
    font-weight: 500;
    color: #64748b;
    margin-top: 22px;
    padding-top: 14px;
    border-top: 1px solid #e2e8f0;
    letter-spacing: 0.2px;
}

/* ==========================================================================
   RESPONSIVE DESIGN (MOBILE & TABLET)
   ========================================================================== */
@media (max-width: 768px) {
    .invoice-sheet {
        padding: 32px 20px 28px;
        border-radius: 14px;
    }

    .invoice-header-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .bottom-financial-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .meta-panel {
        width: 100%;
        min-width: unset;
    }

    .brand-title-text {
        font-size: 22px;
    }

    .recipient-name {
        font-size: 18px;
    }

    .grand-total-row .gt-val {
        font-size: 20px;
    }

    .invoice-action-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .invoice-action-bar .d-flex {
        width: 100%;
        justify-content: space-between;
    }

    .action-btn-pill {
        flex: 1;
        justify-content: center;
        padding: 8px 14px;
        font-size: 12.5px;
    }
}

/* ==========================================================================
   STRICT SINGLE-PAGE PRINT OPTIMIZATION (GUARANTEED 1-PAGE FIT)
   ========================================================================== */
@media print {
    @page {
        size: A4 portrait;
        margin: 0mm !important; /* Suppresses browser URL footer and date/title header in Chrome/Edge */
    }

    html, body {
        height: auto !important;
        background: #ffffff !important;
        margin: 0 !important;
        padding: 14mm 16mm 12mm !important; /* Clean paper margins handled by CSS */
        color: #0f172a !important;
        font-size: 14px !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .no-print,
    .admin-sidebar,
    .staff-sidebar,
    .admin-topbar,
    .staff-topbar,
    header,
    nav {
        display: none !important;
    }

    .admin-main,
    .staff-main,
    .main-content,
    .main-wrapper {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }

    .container-fluid {
        padding: 0 !important;
        margin: 0 !important;
    }

    .invoice-page-container {
        max-width: 100% !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .invoice-sheet {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        border-radius: 0 !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
        page-break-after: avoid !important;
        break-after: avoid !important;
    }

    .sheet-ribbon-box {
        width: 110px !important;
        height: 110px !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .sheet-ribbon {
        font-size: 11px !important;
        line-height: 26px !important;
        top: 24px !important;
        left: -5px !important;
        width: 150px !important;
    }

    .invoice-header-grid {
        margin-bottom: 28px !important;
        gap: 30px !important;
    }

    .green-leaf-emblem {
        width: 50px !important;
        height: 50px !important;
        border-radius: 14px !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .green-leaf-emblem svg {
        width: 30px !important;
        height: 30px !important;
    }

    .brand-title-text {
        font-size: 30px !important;
        font-weight: 900 !important;
        margin-bottom: 6px !important;
        line-height: 1.15 !important;
    }

    .brand-address-text {
        font-size: 13.5px !important;
        line-height: 1.6 !important;
        margin-bottom: 6px !important;
    }

    .brand-gstin-badge {
        font-size: 13px !important;
        padding: 5px 12px !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
    }

    .meta-panel {
        padding: 14px 20px !important;
        min-width: 260px !important;
        border-radius: 14px !important;
    }

    .meta-panel-row {
        padding: 5px 0 !important;
        font-size: 13.5px !important;
    }

    .meta-panel-row .meta-val {
        font-size: 14.5px !important;
    }

    .recipient-wrapper {
        margin-bottom: 26px !important;
        padding-bottom: 0 !important;
    }

    .recipient-label {
        font-size: 11.5px !important;
        font-weight: 800 !important;
        letter-spacing: 1px !important;
        margin-bottom: 6px !important;
    }

    .recipient-name {
        font-size: 20px !important;
        font-weight: 800 !important;
        margin-bottom: 6px !important;
    }

    .recipient-detail {
        font-size: 13.5px !important;
        line-height: 1.55 !important;
    }

    .recipient-gstin {
        font-size: 13px !important;
        margin-top: 6px !important;
    }

    .items-table-wrapper {
        margin-bottom: 26px !important;
    }

    .invoice-table thead th {
        padding: 13px 16px !important;
        font-size: 12.5px !important;
        font-weight: 800 !important;
        letter-spacing: 0.8px !important;
        background: #f8fafc !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .invoice-table tbody td {
        padding: 15px 16px !important;
        font-size: 14px !important;
        line-height: 1.45 !important;
    }

    .invoice-table .col-desc {
        font-size: 14.5px !important;
        font-weight: 700 !important;
    }

    .summary-container {
        margin-bottom: 26px !important;
    }

    .summary-card {
        width: 360px !important;
    }

    .summary-line {
        padding: 6px 0 !important;
        font-size: 13.5px !important;
    }

    .summary-divider {
        margin: 7px 0 9px !important;
    }

    .grand-total-row {
        font-size: 18px !important;
    }

    .grand-total-row .gt-val {
        font-size: 22px !important;
        font-weight: 900 !important;
    }

    .transaction-section {
        margin-top: 26px !important;
        margin-bottom: 18px !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    .transaction-section-title {
        font-size: 14px !important;
        font-weight: 800 !important;
        margin-bottom: 9px !important;
    }

    .transaction-table thead th {
        padding: 9px 14px !important;
        font-size: 11.5px !important;
        font-weight: 800 !important;
    }

    .transaction-table tbody td {
        padding: 12px 14px !important;
        font-size: 13px !important;
    }

    .badge-method-pill {
        font-size: 12px !important;
        padding: 4px 12px !important;
    }

    .badge-status-completed {
        font-size: 12px !important;
    }

    .computer-generated-footer {
        margin-top: 30px !important;
        padding-top: 16px !important;
        font-size: 12.5px !important;
        border-top: 1px solid #e2e8f0 !important;
        page-break-after: avoid !important;
        break-after: avoid !important;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4 px-lg-4 px-2">
    <div class="invoice-page-container">

        @if(session('status'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-3 no-print d-flex align-items-center gap-2">
                <span>✅</span>
                <div>{{ session('status') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-3 no-print d-flex align-items-center gap-2">
                <span>⚠️</span>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        {{-- TOP ACTION CONTROLS (PRINT / DOWNLOAD / EMAIL / EDIT) --}}
        <div class="invoice-action-bar no-print">
            <div class="d-flex align-items-center gap-2">
                <span class="badge {{ $invoice->status === 'paid' ? 'bg-success' : 'bg-danger' }} fs-6 px-3 py-2 rounded-pill shadow-sm">
                    ● {{ strtoupper($invoice->status) }}
                </span>
                <span class="text-muted small fw-bold">Invoice #{{ $invoice->invoice_number }}</span>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <form action="{{ route('staff.invoices.sendEmail', $invoice) }}" method="POST" class="d-inline" onsubmit="return confirm('Send Invoice #{{ $invoice->invoice_number }} to customer email ({{ $invoice->customer->email ?? 'No email found' }})?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-success action-btn-pill shadow-sm" title="Email invoice directly to customer">
                        <span>📧</span> Email Invoice
                    </button>
                </form>

                <button onclick="window.print()" class="btn btn-primary action-btn-pill shadow-sm">
                    <span>🖨️</span> Print Invoice
                </button>

                <button onclick="triggerDownloadPdf()" class="btn btn-outline-dark action-btn-pill">
                    <span>📥</span> Download PDF
                </button>

                <a href="{{ route('staff.invoices.edit', $invoice) }}" class="btn btn-outline-primary action-btn-pill">
                    <span>✏️</span> Edit
                </a>

                <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('admin.invoices.index') : route('staff.invoices.index') }}" class="btn btn-light border action-btn-pill text-secondary">
                    <span>⬅️</span> Back
                </a>
            </div>
        </div>

        <div class="alert alert-light border py-2 px-3 rounded-4 mb-3 no-print d-flex align-items-center justify-content-between flex-wrap gap-2 small shadow-sm text-secondary">
            <div>
                💡 <strong>Clean Print Tip:</strong> In the print preview window, click <strong>"More settings"</strong> and uncheck <strong>"Headers and footers"</strong> to remove the date and website URL from the printed invoice.
            </div>
        </div>

        {{-- THE PREMIUM INVOICE SHEET --}}
        <div class="invoice-sheet" id="printableInvoice">

            {{-- 3D ANGLED STATUS RIBBON --}}
            <div class="sheet-ribbon-box">
                <div class="sheet-ribbon {{ $invoice->status === 'paid' ? 'ribbon-paid' : 'ribbon-unpaid' }}">
                    {{ strtoupper($invoice->status) }}
                </div>
            </div>

            {{-- HEADER: COMPANY INFO WITH GREEN LEAF EMBLEM & INVOICE META --}}
            <div class="invoice-header-grid">
                {{-- COMPANY IDENTITY --}}
                <div class="brand-identity-box">
                    {{-- GREEN LEAF VECTOR LOGO EMBLEM --}}
                    <div class="green-leaf-emblem" title="Green Studio">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.477 2 2 6.477 2 12C2 17.523 6.477 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2Z" fill="#15803d" fill-opacity="0.15"/>
                            <path d="M6 18C6 18 7.5 9.5 17 6C17 6 18.5 14.5 12 17C9 18.2 6 18 6 18Z" fill="#ffffff"/>
                            <path d="M6.5 17.5C9.5 14 13 11 17 6" stroke="#15803d" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <div>
                        <div class="brand-title-text">
                            {{ strtoupper($invoice->company->name ?? 'GREEN STUDIO') }}
                        </div>
                        <div class="brand-address-text">
                            {{ $invoice->company->address ?? 'Koshi College, Kachhari Road, Chitragupt Nagar, Khagaria, Bihar - 851205' }}
                        </div>
                        <div class="brand-gstin-badge">
                            <strong>GSTIN:</strong> {{ $invoice->company->gstin ?? '10DYFPA2189J1ZO' }}
                        </div>
                    </div>
                </div>

                {{-- INVOICE META CARD --}}
                <div>
                    <div class="meta-panel">
                        <div class="meta-panel-row">
                            <span class="meta-panel-label">Invoice No:</span>
                            <span class="meta-panel-val font-monospace">#{{ $invoice->invoice_number }}</span>
                        </div>
                        <div class="meta-panel-row">
                            <span class="meta-panel-label">Date:</span>
                            <span class="meta-panel-val">{{ optional($invoice->invoice_date)->format('d-m-Y') }}</span>
                        </div>
                        <div class="meta-panel-row">
                            <span class="meta-panel-label">Status:</span>
                            <span class="meta-panel-val {{ $invoice->status === 'paid' ? 'status-paid' : 'status-unpaid' }}">
                                {{ strtoupper($invoice->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- INVOICED TO --}}
            <div class="recipient-wrapper">
                <div class="recipient-label">Invoiced To</div>
                <div class="recipient-name">
                    {{ $invoice->customer->company_name ?: $invoice->customer->name }}
                </div>
                @if($invoice->customer->name && $invoice->customer->company_name)
                    <div class="recipient-detail">
                        Attn: {{ $invoice->customer->name }}
                    </div>
                @endif
                @if($invoice->customer->address)
                    <div class="recipient-detail">
                        {{ $invoice->customer->address }}
                    </div>
                @endif
                @if($invoice->customer->state)
                    <div class="recipient-detail">
                        {{ $invoice->customer->state }}
                    </div>
                @endif
                <div class="recipient-gstin">
                    <strong>GSTIN:</strong> {{ $invoice->customer->gst_number ?? 'N/A' }}
                </div>
            </div>

            {{-- ITEMS TABLE: Description | Rate | GST % | Amount --}}
            <div class="items-table-wrapper">
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th class="col-desc">Description</th>
                            <th class="col-rate">Rate</th>
                            <th class="col-gst">GST %</th>
                            <th class="col-amount">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoice->items as $item)
                            <tr>
                                <td class="col-desc">{{ $item->description }}</td>
                                <td class="col-rate font-monospace">₹{{ number_format($item->rate ?? $item->taxable, 2) }}</td>
                                <td class="col-gst font-monospace">{{ number_format($item->gst_percent, 0) }}%</td>
                                <td class="col-amount font-monospace">₹{{ number_format($item->line_total, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No items added to this invoice.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- TOTALS SUMMARY: Taxable Amount | GST Amount | Grand Total --}}
            <div class="summary-container">
                <div class="summary-card">
                    <div class="summary-line">
                        <span class="s-label">Taxable Amount</span>
                        <span class="s-val font-monospace">₹{{ number_format($invoice->taxable_amount, 2) }}</span>
                    </div>

                    <div class="summary-line">
                        <span class="s-label">GST Amount</span>
                        <span class="s-val font-monospace">₹{{ number_format($invoice->cgst_amount + $invoice->sgst_amount + $invoice->igst_amount, 2) }}</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="grand-total-row">
                        <span>Grand Total</span>
                        <span class="gt-val font-monospace">₹{{ number_format($invoice->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- TRANSACTION HISTORY SECTION (CLEAN PREMIUM LAYOUT) --}}
            <div class="transaction-section">
                <div class="transaction-section-title">
                    Transaction History
                </div>
                <table class="transaction-table">
                    <thead>
                        <tr>
                            <th style="width: 25%;">DATE</th>
                            <th style="width: 32%;">PAYMENT METHOD</th>
                            <th style="width: 23%;">STATUS</th>
                            <th style="width: 20%; text-align: right;">AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($invoice->transactions && $invoice->transactions->count() > 0)
                            @foreach($invoice->transactions as $transaction)
                                <tr>
                                    <td class="font-monospace fw-semibold">{{ \Carbon\Carbon::parse($transaction->paid_at ?? $invoice->invoice_date)->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge-method-pill">
                                            💳 {{ $transaction->gateway ?: 'UPI / Digital Payment' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-status-completed">
                                            ✓ Paid & Verified
                                        </span>
                                    </td>
                                    <td style="text-align: right;" class="font-monospace fw-bold">₹{{ number_format(($transaction->amount > 0 ? $transaction->amount : $invoice->total_amount), 2) }}</td>
                                </tr>
                            @endforeach
                        @elseif($invoice->status === 'paid')
                            <tr>
                                <td class="font-monospace fw-semibold">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge-method-pill">
                                        💳 UPI / Digital Payment
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-status-completed">
                                        ✓ Paid & Verified
                                    </span>
                                </td>
                                <td style="text-align: right;" class="font-monospace fw-bold">₹{{ number_format($invoice->total_amount, 2) }}</td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="4" class="text-muted text-center py-3" style="font-size: 13px;">
                                    <span class="badge-status-pending">● Payment Pending</span>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- EXACT MANDATED SYSTEM FOOTER --}}
            <div class="computer-generated-footer">
                This is a computer generated invoice no signature required.
            </div>

        </div>

    </div>
</div>

{{-- JAVASCRIPT FOR PDF DOWNLOAD --}}
<script>
function triggerDownloadPdf() {
    if (confirm("Tip: In the print dialog, select 'Save as PDF' under Destination to download this invoice. Open now?")) {
        setTimeout(function() {
            window.print();
        }, 150);
    }
}
</script>
@endsection