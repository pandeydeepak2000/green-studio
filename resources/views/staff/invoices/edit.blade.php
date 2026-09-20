@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.staff')

@section('title', 'Edit Invoice #' . $invoice->invoice_number)
@section('page_title', 'Edit Invoice')

@push('styles')

<style>

.invoice-edit-wrapper{
    max-width:1400px;
    margin:auto;
}

.invoice-card{
    border:none;
    border-radius:26px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.invoice-card .card-body{
    padding:28px;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    flex-wrap:wrap;
    margin-bottom:24px;
}

.page-title{
    font-size:30px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:4px;
}

.page-subtitle{
    font-size:14px;
    color:#64748b;
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

textarea.form-control{
    min-height:90px;
    padding-top:12px;
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

.btn-light{
    border:1px solid #dbe2ea;
}

.table{
    margin-bottom:0;
}

.table th{
    white-space:nowrap;
    background:#f8fafc !important;
    font-size:13px;
    font-weight:700;
    color:#475569;
    padding:16px;
}

.table td{
    vertical-align:middle;
    padding:16px;
}

.status-card{
    background:linear-gradient(to right,#ffffff,#f8fafc);
}

.total-badge{
    background:#eff6ff;
    color:#2563eb;
    padding:8px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.line-total-text{
    font-weight:800;
    color:#0f172a;
}

.alert{
    border:none;
    border-radius:18px;
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

/* SCOPED COMPACT PROFESSIONAL ITEMS TABLE */
.items-table{
    border-collapse:separate;
    border-spacing:0;
}

.items-table th{
    background:#f1f5f9 !important;
    font-size:12px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.6px;
    color:#475569;
    padding:10px 12px !important;
    border-bottom:2px solid #cbd5e1 !important;
}

.items-table td{
    padding:8px 10px !important;
    vertical-align:middle !important;
    border-bottom:1px solid #f1f5f9 !important;
}

.items-table .form-control{
    min-height:38px !important;
    height:38px !important;
    font-size:13.5px !important;
    border-radius:8px !important;
    border:1px solid #cbd5e1 !important;
    padding:6px 12px !important;
}

.items-table .form-control:focus{
    border-color:#16a34a !important;
    box-shadow:0 0 0 3px rgba(22,163,74,.15) !important;
}

.items-table .input-group-text{
    background:#f8fafc;
    border-color:#cbd5e1;
    font-size:13px;
    font-weight:700;
    color:#64748b;
    border-radius:8px;
    padding:6px 10px;
}

.item-index-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:24px;
    height:24px;
    border-radius:6px;
    background:#e2e8f0;
    color:#334155;
    font-weight:800;
    font-size:12px;
}

.items-summary-bar{
    background:linear-gradient(to right, #f8fafc, #f1f5f9);
    border:1px solid #e2e8f0;
    border-radius:16px;
    padding:14px 20px;
}

@media(max-width:768px){

    .invoice-card{
        border-radius:20px;
    }

    .invoice-card .card-body{
        padding:20px;
    }

    .page-title{
        font-size:24px;
    }

    .btn{
        width:100%;
    }

    .table td,
    .table th{
        white-space:nowrap;
    }

}

</style>

@endpush

@section('content')

<div class="container-fluid py-4 px-lg-4 px-2">

    <div class="invoice-edit-wrapper">

        {{-- HEADER --}}
        {{-- HEADER --}}
        <div class="page-header">

            <div>

                <div class="page-title">

                    Edit Invoice

                </div>

                <div class="page-subtitle">

                    Invoice #{{ $invoice->invoice_number }} &bull; Customer: {{ $invoice->customer->company_name ?? $invoice->customer->name }}

                </div>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('staff.invoices.show', $invoice) }}"
                   class="btn btn-outline-dark d-flex align-items-center gap-1">

                    <span>🖨️</span>
                    <span>View & Print</span>

                </a>

                <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('admin.invoices.index') : route('staff.invoices.index') }}"
                   class="btn btn-light border">

                    Back

                </a>

            </div>

        </div>

        @if(session('status'))

            <div class="alert alert-success shadow-sm mb-4">

                {{ session('status') }}

            </div>

        @endif

        {{-- BASIC DETAILS CARD --}}
        <form action="{{ route('staff.invoices.updateBasic', $invoice) }}"
              method="POST"
              class="mb-4">

            @csrf
            @method('PUT')

            <div class="card invoice-card mb-4 border shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <h6 class="fw-bold mb-0 text-dark">
                            📋 Basic Invoice Information
                        </h6>
                        <div>
                            @if($invoice->sale_type === 'LOCAL')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                    Local Sale (Bihar &bull; CGST + SGST)
                                </span>
                            @elseif($invoice->sale_type === 'CENTRAL')
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                                    Interstate Sale (Central &bull; IGST)
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row g-3">

                        {{-- INVOICE NUMBER --}}
                        <div class="col-md-4">
                            <label class="form-label">Invoice Number *</label>
                            <input type="text"
                                   name="invoice_number"
                                   class="form-control fw-semibold"
                                   value="{{ old('invoice_number', $invoice->invoice_number) }}"
                                   required>
                        </div>

                        {{-- CUSTOMER --}}
                        <div class="col-md-4">
                            <label class="form-label">Customer *</label>
                            <select name="customer_id" class="form-select fw-semibold" required>
                                @foreach($customers as $cust)
                                    <option value="{{ $cust->id }}" {{ old('customer_id', $invoice->customer_id) == $cust->id ? 'selected' : '' }}>
                                        {{ $cust->company_name ? $cust->company_name . ' (' . $cust->name . ')' : $cust->name }} - {{ $cust->state ?? 'Bihar' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- INVOICE DATE --}}
                        <div class="col-md-2">
                            <label class="form-label">Invoice Date *</label>
                            <input type="date"
                                   name="invoice_date"
                                   class="form-control"
                                   value="{{ old('invoice_date', optional($invoice->invoice_date)->format('Y-m-d')) }}"
                                   required>
                        </div>

                        {{-- SAVE BUTTON --}}
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary w-100 fw-bold">
                                Update Info
                            </button>
                        </div>

                    </div>

                </div>

            </div>

        </form>

        {{-- STATUS --}}
        <form action="{{ route('staff.invoices.updateStatusWithTransaction', $invoice) }}"
              method="POST"
              id="paymentStatusForm"
              class="mb-4">

            @csrf
            @method('PUT')

            <div class="card invoice-card status-card">

                <div class="card-body">

                    <div class="row g-3">

                        {{-- STATUS --}}
                        <div class="col-md-3">

                            <label class="form-label fw-bold">

                                Payment Status

                            </label>

                            <select name="status"
                                    id="paymentStatusSelect"
                                    class="form-select"
                                    onchange="toggleTxRequirement()">

                                <option value="unpaid"
                                    {{ $invoice->status === 'unpaid' ? 'selected' : '' }}>

                                    UNPAID

                                </option>

                                <option value="paid"
                                    {{ $invoice->status === 'paid' ? 'selected' : '' }}>

                                    PAID

                                </option>

                            </select>

                        </div>

                        {{-- PAYMENT METHOD --}}
                        <div class="col-md-3">

                            <label class="form-label fw-bold">

                                Payment Method

                            </label>

                            @php
                                $currentMethod = $invoice->transactions->first()?->gateway ?? 'UPI / Digital Payment';
                            @endphp

                            <select name="payment_method" class="form-select">
                                <option value="UPI / Digital Payment" {{ $currentMethod === 'UPI / Digital Payment' ? 'selected' : '' }}>💳 UPI / Digital Payment</option>
                                <option value="Bank Transfer (NEFT/IMPS)" {{ str_contains($currentMethod, 'Bank') ? 'selected' : '' }}>🏦 Bank Transfer (NEFT/IMPS)</option>
                                <option value="Card / POS" {{ str_contains($currentMethod, 'Card') ? 'selected' : '' }}>💳 Card / POS</option>
                                <option value="Cash Payment" {{ str_contains($currentMethod, 'Cash') ? 'selected' : '' }}>💵 Cash Payment</option>
                                <option value="Cheque / DD" {{ str_contains($currentMethod, 'Cheque') ? 'selected' : '' }}>📝 Cheque / DD</option>
                            </select>

                        </div>

                        {{-- TRANSACTION --}}
                        <div class="col-md-3">

                            <label class="form-label fw-bold">

                                Transaction Ref / ID
                                <span id="txRequiredStar" class="text-danger small" style="display: {{ $invoice->status === 'paid' ? 'inline' : 'none' }};">* (Required for PAID)</span>

                            </label>

                            <input type="text"
                                   id="transactionIdInput"
                                   name="transaction_id"
                                   class="form-control @error('transaction_id') is-invalid @enderror"
                                   placeholder="e.g. UPI/Bank Ref"
                                   value="{{ old('transaction_id', $invoice->transactions->first()?->transaction_id ?? '') }}">

                            @error('transaction_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                        {{-- DATE --}}
                        <div class="col-md-3">

                            <label class="form-label fw-bold">

                                Invoice Date

                            </label>

                            <input type="date"
                                   name="invoice_date"
                                   class="form-control"
                                   value="{{ old('invoice_date', optional($invoice->invoice_date)->format('Y-m-d')) }}">

                        </div>

                        {{-- SAVE BUTTON --}}
                        <div class="col-12 text-end pt-2">

                            <button type="submit"
                                    class="btn btn-primary px-4 py-2 fw-semibold">

                                Update Payment & Status

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </form>

        {{-- ITEMS --}}
        <div class="card invoice-card">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">

                            Invoice Items

                        </h5>

                        <div class="text-muted small">

                            Add and manage invoice items

                        </div>

                    </div>

                    <div class="total-badge">

                        Invoice:
                        {{ $invoice->invoice_number }}

                    </div>

                </div>

                <form method="POST"
                      action="{{ route('staff.invoices.updateItems', $invoice) }}">

                    @csrf

                    <div class="table-responsive">

                        <table class="table align-middle border mb-0 items-table">

                            <thead>

                                <tr>

                                    <th style="width:40px" class="text-center">#</th>
                                    <th style="width:48%">Item Description</th>
                                    <th style="width:16%" class="text-end">Rate (₹)</th>
                                    <th style="width:14%" class="text-center">GST %</th>
                                    <th style="width:16%" class="text-end">Amount (₹)</th>
                                    <th style="width:50px" class="text-center"></th>

                                </tr>

                            </thead>

                            <tbody id="items-body">

                                @forelse($invoice->items as $index => $item)

                                    <tr>

                                        {{-- S.NO --}}
                                        <td class="text-center">
                                            <span class="item-index-badge row-index">{{ $loop->iteration }}</span>
                                        </td>

                                        {{-- DESCRIPTION --}}
                                        <td>
                                            <input type="text"
                                                   name="items[{{ $index }}][description]"
                                                   class="form-control item-desc"
                                                   placeholder="Enter item description or service details..."
                                                   value="{{ $item->description }}"
                                                   required>
                                        </td>

                                        {{-- RATE --}}
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">₹</span>
                                                <input type="number"
                                                       step="0.01"
                                                       min="0"
                                                       name="items[{{ $index }}][rate]"
                                                       class="form-control rate text-end"
                                                       placeholder="0.00"
                                                       value="{{ $item->rate }}">
                                            </div>
                                        </td>

                                        {{-- GST --}}
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="number"
                                                       step="0.01"
                                                       min="0"
                                                       name="items[{{ $index }}][gst_percent]"
                                                       class="form-control gst-percent text-center"
                                                       value="{{ $item->gst_percent }}">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </td>

                                        {{-- TOTAL --}}
                                        <td class="text-end">
                                            <span class="fw-bold text-dark fs-6">₹<span class="line-total line-total-text">{{ number_format($item->line_total, 2) }}</span></span>
                                        </td>

                                        {{-- REMOVE --}}
                                        <td class="text-center">
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger p-1 px-2 remove-row rounded-3"
                                                    title="Delete Row">
                                                🗑️
                                            </button>
                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td class="text-center">
                                            <span class="item-index-badge row-index">1</span>
                                        </td>

                                        <td>
                                            <input type="text"
                                                   name="items[0][description]"
                                                   class="form-control item-desc"
                                                   placeholder="Enter item description or service details..."
                                                   required>
                                        </td>

                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">₹</span>
                                                <input type="number"
                                                       step="0.01"
                                                       min="0"
                                                       name="items[0][rate]"
                                                       class="form-control rate text-end"
                                                       placeholder="0.00">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="number"
                                                       step="0.01"
                                                       min="0"
                                                       name="items[0][gst_percent]"
                                                       class="form-control gst-percent text-center"
                                                       value="18">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </td>

                                        <td class="text-end">
                                            <span class="fw-bold text-dark fs-6">₹<span class="line-total line-total-text">0.00</span></span>
                                        </td>

                                        <td class="text-center">
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger p-1 px-2 remove-row rounded-3"
                                                    title="Delete Row">
                                                🗑️
                                            </button>
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="6" class="p-2 px-3 bg-light border-top">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                            <button type="button"
                                                    class="btn btn-sm btn-success fw-bold px-3 py-2 d-inline-flex align-items-center gap-2 rounded-3 shadow-sm"
                                                    id="add-row">
                                                <span class="fs-5 lh-1">+</span> <span>Add Another Item</span>
                                            </button>
                                            <span class="text-muted small">
                                                💡 <strong>Shortcut:</strong> Press <kbd class="bg-secondary text-white px-1 py-0 rounded">Enter</kbd> in GST % to add next line automatically.
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>

                        </table>

                    </div>

                    {{-- LIVE SUMMARY & SAVE --}}
                    <div class="items-summary-bar mt-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-4 flex-wrap">
                            <div>
                                <div class="small text-muted fw-semibold">Taxable Subtotal</div>
                                <div class="fw-bold text-dark fs-6">₹<span id="summary-subtotal">0.00</span></div>
                            </div>
                            <div>
                                <div class="small text-muted fw-semibold">Estimated GST</div>
                                <div class="fw-bold text-dark fs-6">₹<span id="summary-gst">0.00</span></div>
                            </div>
                            <div>
                                <div class="small text-muted fw-semibold">Total Items</div>
                                <div class="fw-bold text-secondary fs-6"><span id="summary-count">0</span> lines</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-end pe-3 border-end">
                                <div class="small text-muted fw-semibold">Total Amount</div>
                                <div class="fw-bold text-success fs-5">₹<span id="summary-total">0.00</span></div>
                            </div>
                            <button type="submit"
                                    class="btn btn-primary px-4 py-2 fw-bold rounded-3 shadow-sm d-inline-flex align-items-center gap-2">
                                <span>💾</span> <span>Save Items</span>
                            </button>
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const tbody = document.getElementById('items-body');
    const addBtn = document.getElementById('add-row');

    function updateRowIndices() {
        Array.from(tbody.querySelectorAll('tr')).forEach(function (row, idx) {
            const badge = row.querySelector('.row-index');
            if (badge) badge.textContent = idx + 1;
        });
        const countSpan = document.getElementById('summary-count');
        if (countSpan) countSpan.textContent = tbody.rows.length;
    }

    function recalc() {
        let grandTaxable = 0;
        let grandGst = 0;
        let grandTotal = 0;

        Array.from(tbody.rows).forEach(function (row) {
            const rate = parseFloat(row.querySelector('.rate')?.value || 0);
            const gstP = parseFloat(row.querySelector('.gst-percent')?.value || 0);

            const taxable = rate;
            const gstAmt = taxable * (gstP / 100);
            const total = taxable + gstAmt;

            grandTaxable += taxable;
            grandGst += gstAmt;
            grandTotal += total;

            const span = row.querySelector('.line-total');
            if (span) {
                span.textContent = total.toFixed(2);
            }
        });

        const subtotalSpan = document.getElementById('summary-subtotal');
        const gstSpan = document.getElementById('summary-gst');
        const totalSpan = document.getElementById('summary-total');

        if (subtotalSpan) subtotalSpan.textContent = grandTaxable.toFixed(2);
        if (gstSpan) gstSpan.textContent = grandGst.toFixed(2);
        if (totalSpan) totalSpan.textContent = grandTotal.toFixed(2);

        updateRowIndices();
    }

    function attachRowEvents(row) {
        ['rate', 'gst-percent'].forEach(function (cls) {
            const input = row.querySelector('.' + cls);
            if (input) {
                input.addEventListener('input', recalc);
            }
        });

        const gstInput = row.querySelector('.gst-percent');
        if (gstInput) {
            gstInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (addBtn) addBtn.click();
                }
            });
        }

        const removeBtn = row.querySelector('.remove-row');
        if (removeBtn) {
            removeBtn.addEventListener('click', function () {
                if (tbody.rows.length > 1) {
                    row.remove();
                    recalc();
                } else {
                    const desc = row.querySelector('.item-desc');
                    const rate = row.querySelector('.rate');
                    const gst = row.querySelector('.gst-percent');
                    if (desc) desc.value = '';
                    if (rate) rate.value = '';
                    if (gst) gst.value = '18';
                    recalc();
                }
            });
        }
    }

    Array.from(tbody.rows).forEach(attachRowEvents);
    recalc();

    if (addBtn) {
        addBtn.addEventListener('click', function () {
            const index = tbody.rows.length;
            const tpl = `
                <tr>
                    <td class="text-center">
                        <span class="item-index-badge row-index">${index + 1}</span>
                    </td>
                    <td>
                        <input type="text"
                               name="items[${index}][description]"
                               class="form-control item-desc"
                               placeholder="Enter item description or service details..."
                               required>
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">₹</span>
                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   name="items[${index}][rate]"
                                   class="form-control rate text-end"
                                   placeholder="0.00">
                        </div>
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   name="items[${index}][gst_percent]"
                                   class="form-control gst-percent text-center"
                                   value="18">
                            <span class="input-group-text">%</span>
                        </div>
                    </td>
                    <td class="text-end">
                        <span class="fw-bold text-dark fs-6">₹<span class="line-total line-total-text">0.00</span></span>
                    </td>
                    <td class="text-center">
                        <button type="button"
                                class="btn btn-sm btn-outline-danger p-1 px-2 remove-row rounded-3"
                                title="Delete Row">
                            🗑️
                        </button>
                    </td>
                </tr>
            `;

            tbody.insertAdjacentHTML('beforeend', tpl);
            const newRow = tbody.rows[tbody.rows.length - 1];
            attachRowEvents(newRow);
            recalc();

            const newDesc = newRow.querySelector('.item-desc');
            if (newDesc) newDesc.focus();
        });
    }

});

function toggleTxRequirement() {
    const statusSelect = document.getElementById('paymentStatusSelect');
    const txInput = document.getElementById('transactionIdInput');
    const star = document.getElementById('txRequiredStar');
    if (statusSelect && txInput && star) {
        if (statusSelect.value === 'paid') {
            star.style.display = 'inline';
            txInput.setAttribute('required', 'required');
        } else {
            star.style.display = 'none';
            txInput.removeAttribute('required');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleTxRequirement();

    const paymentForm = document.getElementById('paymentStatusForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            const statusSelect = document.getElementById('paymentStatusSelect');
            const txInput = document.getElementById('transactionIdInput');
            if (statusSelect && statusSelect.value === 'paid') {
                if (!txInput || !txInput.value.trim()) {
                    e.preventDefault();
                    alert('Security Check: An invoice CANNOT be marked as PAID without entering a valid Transaction ID.');
                    txInput.focus();
                    return false;
                }
            }
        });
    }
});
</script>

@endsection