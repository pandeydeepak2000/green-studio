@extends('layouts.staff')

@section('title', 'Customers')
@section('page_title', 'Customers')

@push('styles')

<style>

.customer-page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    flex-wrap:wrap;
    margin-bottom:24px;
}

.customer-title{
    font-size:30px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:4px;
}

.customer-subtitle{
    color:#64748b;
    font-size:14px;
}

.customer-card{
    border:none;
    border-radius:24px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.customer-card .card-body{
    padding:22px;
}

.customer-search{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.customer-search .form-control{
    min-height:48px;
    border-radius:14px;
    border:1px solid #dbe2ea;
    min-width:260px;
    box-shadow:none !important;
}

.customer-search .form-control:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.12) !important;
}

.customer-search .btn{
    border-radius:14px;
    font-weight:700;
    padding:10px 18px;
}

.add-btn{
    border-radius:14px;
    font-weight:700;
    padding:11px 18px;
}

.customer-table{
    margin-bottom:0;
}

.customer-table thead{
    background:#f8fafc;
}

.customer-table th{
    font-size:13px;
    font-weight:700;
    color:#475569;
    white-space:nowrap;
    border-bottom:1px solid #e5e7eb;
    padding:16px;
}

.customer-table td{
    padding:16px;
    vertical-align:middle;
    font-size:14px;
}

.customer-name{
    font-weight:700;
    color:#0f172a;
}

.customer-phone{
    color:#64748b;
    font-size:13px;
}

.customer-gstin{
    font-family:monospace;
    font-size:13px;
    background:#eff6ff;
    color:#2563eb;
    padding:6px 10px;
    border-radius:999px;
    display:inline-block;
    font-weight:700;
}

.customer-state{
    background:#f1f5f9;
    color:#334155;
    padding:6px 10px;
    border-radius:999px;
    display:inline-block;
    font-size:12px;
    font-weight:700;
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
    font-weight:700;
    padding:8px 14px;
}

.empty-state{
    padding:60px 20px;
    text-align:center;
}

.empty-icon{
    font-size:52px;
    margin-bottom:14px;
}

.empty-title{
    font-size:20px;
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

    .customer-title{
        font-size:24px;
    }

    .customer-card{
        border-radius:20px;
    }

    .customer-card .card-body{
        padding:18px;
    }

    .customer-search{
        width:100%;
    }

    .customer-search .form-control{
        min-width:100%;
    }

    .customer-search .btn,
    .add-btn{
        width:100%;
    }

    .customer-table td,
    .customer-table th{
        white-space:nowrap;
    }

    .action-group{
        justify-content:flex-start;
    }

}

</style>

@endpush

@section('content')

@if(session('status'))

    <div class="alert alert-success border-0 shadow-sm rounded-4">

        {{ session('status') }}

    </div>

@endif

{{-- HEADER --}}
<div class="customer-page-header">

    <div>

        <div class="customer-title">
            Customers
        </div>

        <div class="customer-subtitle">

            Manage customer details, GSTIN and billing information

        </div>

    </div>

    <a href="{{ route('staff.customers.create') }}"
       class="btn btn-primary add-btn">

        + Add Customer

    </a>

</div>

{{-- SEARCH --}}
<div class="card customer-card mb-4">

    <div class="card-body">

        <form method="GET"
              action="{{ route('staff.customers.index') }}"
              class="customer-search">

            <input type="text"
                   name="q"
                   class="form-control"
                   placeholder="Search name, phone or GSTIN..."
                   value="{{ $search ?? '' }}">

            <button class="btn btn-outline-secondary"
                    type="submit">

                Search

            </button>

        </form>

    </div>

</div>

{{-- TABLE --}}
<div class="card customer-card">

    <div class="table-responsive">

        <table class="table customer-table align-middle">

            <thead>

                <tr>

                    <th>Customer</th>

                    <th>Phone</th>

                    <th>GSTIN</th>

                    <th>State</th>

                    <th class="text-end">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($customers as $customer)

                    <tr>

                        {{-- NAME --}}
                        <td>

                            <div class="customer-name">

                                {{ $customer->name }}

                            </div>

                            @if($customer->company_name)

                                <div class="customer-phone mt-1">

                                    {{ $customer->company_name }}

                                </div>

                            @endif

                        </td>

                        {{-- PHONE --}}
                        <td>

                            <div class="customer-phone">

                                {{ $customer->phone ?? '-' }}

                            </div>

                        </td>

                        {{-- GST --}}
                        <td>

                            @if($customer->gst_number)

                                <span class="customer-gstin">

                                    {{ $customer->gst_number }}

                                </span>

                            @else

                                -

                            @endif

                        </td>

                        {{-- STATE --}}
                        <td>

                            @if($customer->state)

                                <span class="customer-state">

                                    {{ $customer->state }}

                                </span>

                            @else

                                -

                            @endif

                        </td>

                        {{-- ACTIONS --}}
                        <td class="text-end">

                            <div class="action-group">

                                <a href="{{ route('staff.customers.edit', $customer) }}"
                                   class="btn btn-outline-primary">

                                    Edit

                                </a>

                                <form action="{{ route('staff.customers.destroy', $customer) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this customer?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-outline-danger">

                                        Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5">

                            <div class="empty-state">

                                <div class="empty-icon">
                                    👥
                                </div>

                                <div class="empty-title">

                                    No customers found

                                </div>

                                <div class="empty-subtitle">

                                    Start by adding your first customer
                                    to generate GST invoices easily.

                                </div>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($customers->hasPages())

        <div class="card-footer bg-white border-0 py-3">

            {{ $customers->withQueryString()->links() }}

        </div>

    @endif

</div>

@endsection