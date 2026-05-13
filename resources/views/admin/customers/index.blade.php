@extends('layouts.admin')

@section('title', 'Customers')
@section('page_title', 'Customers')

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

.customer-card{
    border:none;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.customer-table thead{
    background:#f8fafc;
}

.customer-table th{
    padding:16px;
    font-size:13px;
    font-weight:700;
    color:#475569;
    white-space:nowrap;
}

.customer-table td{
    padding:18px 16px;
    vertical-align:middle;
}

.customer-avatar{
    width:48px;
    height:48px;
    border-radius:16px;
    background:#2563eb;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    font-weight:800;
}

.customer-name{
    font-size:15px;
    font-weight:800;
    color:#0f172a;
}

.customer-meta{
    font-size:13px;
    color:#64748b;
}

.search-box{
    position:relative;
}

.search-input{
    min-height:50px;
    border-radius:16px;
    border:1px solid #dbe2ea;
    padding-left:18px;
    box-shadow:none !important;
}

.search-input:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.10) !important;
}

.action-btn{
    border-radius:12px;
    padding:8px 14px;
    font-size:13px;
    font-weight:700;
}

.empty-box{
    text-align:center;
    padding:70px 20px;
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

    .customer-table th,
    .customer-table td{
        white-space:nowrap;
    }

}

</style>

@if(session('status'))

    <div class="alert alert-success border-0 shadow-sm rounded-4">

        {{ session('status') }}

    </div>

@endif

<div class="page-header">

    <div>

        <div class="page-title">

            Customer Management

        </div>

        <div class="page-subtitle">

            Manage customer profiles and GST details

        </div>

    </div>

    <div>

        <a href="{{ route('customers.create') }}"
           class="btn btn-primary action-btn">

            + Add Customer

        </a>

    </div>

</div>

{{-- SEARCH --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body p-3">

        <form method="GET"
              action="{{ route('customers.index') }}">

            <div class="row g-3 align-items-center">

                <div class="col-md-10">

                    <div class="search-box">

                        <input type="text"
                               name="q"
                               class="form-control search-input"
                               placeholder="Search customer name, phone or GSTIN..."
                               value="{{ $search ?? '' }}">

                    </div>

                </div>

                <div class="col-md-2">

                    <button type="submit"
                            class="btn btn-dark w-100 action-btn">

                        Search

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

{{-- TABLE --}}
<div class="card customer-card">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0 customer-table">

                <thead>

                    <tr>

                        <th>Customer</th>
                        <th>Phone</th>
                        <th>GSTIN</th>
                        <th>State</th>
                        <th class="text-end">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($customers as $customer)

                        <tr>

                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    <div class="customer-avatar">

                                        {{ strtoupper(substr($customer->name,0,1)) }}

                                    </div>

                                    <div>

                                        <div class="customer-name">

                                            {{ $customer->company_name ?? $customer->name }}

                                        </div>

                                        <div class="customer-meta">

                                            {{ $customer->email ?? 'No Email' }}

                                        </div>

                                    </div>

                                </div>

                            </td>

                            <td>

                                {{ $customer->phone ?? '-' }}

                            </td>

                            <td>

                                {{ $customer->gst_number ?? '-' }}

                            </td>

                            <td>

                                {{ $customer->state ?? '-' }}

                            </td>

                            <td class="text-end">

                                <div class="d-flex justify-content-end gap-2">

                                    <a href="{{ route('customers.edit', $customer) }}"
                                       class="btn btn-outline-primary action-btn">

                                        Edit

                                    </a>

                                    <form action="{{ route('customers.destroy', $customer) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this customer?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-outline-danger action-btn">

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5">

                                <div class="empty-box">

                                    <div style="font-size:50px;">

                                        👥

                                    </div>

                                    <div class="empty-title">

                                        No Customers Found

                                    </div>

                                    <div class="empty-subtitle">

                                        Add your first customer to start billing.

                                    </div>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    @if($customers->hasPages())

        <div class="card-footer bg-white border-0 py-3">

            {{ $customers->withQueryString()->links() }}

        </div>

    @endif

</div>

@endsection