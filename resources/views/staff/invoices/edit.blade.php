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

                        <table class="table align-middle border">

                            <thead>

                                <tr>

                                    <th style="width:55%">
                                        Description
                                    </th>

                                    <th style="width:15%">
                                        Rate
                                    </th>

                                    <th style="width:15%">
                                        GST %
                                    </th>

                                    <th style="width:10%"
                                        class="text-end">

                                        Total

                                    </th>

                                    <th style="width:5%"></th>

                                </tr>

                            </thead>

                            <tbody id="items-body">

                                @forelse($invoice->items as $index => $item)

                                    <tr>

                                        {{-- DESCRIPTION --}}
                                        <td>

                                            <textarea
                                                name="items[{{ $index }}][description]"
                                                class="form-control"
                                                rows="2"
                                                required>{{ $item->description }}</textarea>

                                        </td>

                                        {{-- RATE --}}
                                        <td>

                                            <input type="number"
                                                   step="0.01"
                                                   min="0"
                                                   name="items[{{ $index }}][rate]"
                                                   class="form-control rate"
                                                   value="{{ $item->rate }}">

                                        </td>

                                        {{-- GST --}}
                                        <td>

                                            <input type="number"
                                                   step="0.01"
                                                   min="0"
                                                   name="items[{{ $index }}][gst_percent]"
                                                   class="form-control gst-percent"
                                                   value="{{ $item->gst_percent }}">

                                        </td>

                                        {{-- TOTAL --}}
                                        <td class="text-end">

                                            ₹<span class="line-total line-total-text">

                                                {{ number_format($item->line_total, 2) }}

                                            </span>

                                        </td>

                                        {{-- REMOVE --}}
                                        <td class="text-end">

                                            <button type="button"
                                                    class="btn btn-outline-danger remove-row">

                                                ×

                                            </button>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td>

                                            <textarea
                                                name="items[0][description]"
                                                class="form-control"
                                                rows="2"
                                                required></textarea>

                                        </td>

                                        <td>

                                            <input type="number"
                                                   step="0.01"
                                                   min="0"
                                                   name="items[0][rate]"
                                                   class="form-control rate">

                                        </td>

                                        <td>

                                            <input type="number"
                                                   step="0.01"
                                                   min="0"
                                                   name="items[0][gst_percent]"
                                                   class="form-control gst-percent"
                                                   value="18">

                                        </td>

                                        <td class="text-end">

                                            ₹<span class="line-total line-total-text">

                                                0.00

                                            </span>

                                        </td>

                                        <td class="text-end">

                                            <button type="button"
                                                    class="btn btn-outline-danger remove-row">

                                                ×

                                            </button>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    {{-- ACTIONS --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">

                        <button type="button"
                                class="btn btn-outline-secondary"
                                id="add-row">

                            + Add Item

                        </button>

                        <button type="submit"
                                class="btn btn-primary">

                            Save Items

                        </button>

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

    function recalc() {

        Array.from(tbody.rows).forEach(function (row) {

            const rate = parseFloat(
                row.querySelector('.rate')?.value || 0
            );

            const gstP = parseFloat(
                row.querySelector('.gst-percent')?.value || 0
            );

            const taxable = rate;

            const gstAmt = taxable * (gstP / 100);

            const total = taxable + gstAmt;

            const span = row.querySelector('.line-total');

            if (span) {

                span.textContent = total.toFixed(2);

            }

        });

    }

    function attachRowEvents(row) {

        ['rate', 'gst-percent'].forEach(function (cls) {

            const input = row.querySelector('.' + cls);

            if (input) {

                input.addEventListener('input', recalc);

            }

        });

        const removeBtn = row.querySelector('.remove-row');

        if (removeBtn) {

            removeBtn.addEventListener('click', function () {

                if (tbody.rows.length > 1) {

                    row.remove();

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

                    <td>

                        <textarea
                            name="items[${index}][description]"
                            class="form-control"
                            rows="2"
                            required></textarea>

                    </td>

                    <td>

                        <input type="number"
                               step="0.01"
                               min="0"
                               name="items[${index}][rate]"
                               class="form-control rate">

                    </td>

                    <td>

                        <input type="number"
                               step="0.01"
                               min="0"
                               name="items[${index}][gst_percent]"
                               class="form-control gst-percent"
                               value="18">

                    </td>

                    <td class="text-end">

                        ₹<span class="line-total line-total-text">

                            0.00

                        </span>

                    </td>

                    <td class="text-end">

                        <button type="button"
                                class="btn btn-outline-danger remove-row">

                            ×

                        </button>

                    </td>

                </tr>

            `;

            tbody.insertAdjacentHTML('beforeend', tpl);

            const newRow = tbody.rows[tbody.rows.length - 1];

            attachRowEvents(newRow);

            recalc();

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