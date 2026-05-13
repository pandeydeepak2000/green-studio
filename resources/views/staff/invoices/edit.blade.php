@extends('layouts.staff')

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
        <div class="page-header">

            <div>

                <div class="page-title">

                    Edit Invoice

                </div>

                <div class="page-subtitle">

                    Invoice #{{ $invoice->invoice_number }}

                </div>

            </div>

            <a href="{{ route('staff.invoices.index') }}"
               class="btn btn-light">

                Back

            </a>

        </div>

        @if(session('status'))

            <div class="alert alert-success shadow-sm mb-4">

                {{ session('status') }}

            </div>

        @endif

        {{-- STATUS --}}
        <form action="{{ route('staff.invoices.updateStatusWithTransaction', $invoice) }}"
              method="POST"
              class="mb-4">

            @csrf
            @method('PUT')

            <div class="card invoice-card status-card">

                <div class="card-body">

                    <div class="row g-4">

                        {{-- STATUS --}}
                        <div class="col-md-3">

                            <label class="form-label">

                                Payment Status

                            </label>

                            <select name="status"
                                    class="form-select">

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

                        {{-- TRANSACTION --}}
                        <div class="col-md-4">

                            <label class="form-label">

                                Transaction ID

                            </label>

                            <input type="text"
                                   name="transaction_id"
                                   class="form-control @error('transaction_id') is-invalid @enderror"
                                   placeholder="Enter transaction ID"
                                   value="{{ old('transaction_id') }}">

                            @error('transaction_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                        {{-- DATE --}}
                        <div class="col-md-3">

                            <label class="form-label">

                                Invoice Date

                            </label>

                            <input type="date"
                                   name="invoice_date"
                                   class="form-control"
                                   value="{{ old('invoice_date', optional($invoice->invoice_date)->format('Y-m-d')) }}">

                        </div>

                        {{-- SAVE --}}
                        <div class="col-md-2 d-flex align-items-end">

                            <button type="submit"
                                    class="btn btn-primary w-100">

                                Save

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

</script>

@endsection