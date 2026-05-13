@extends('layouts.admin')

@section('title', 'Edit Customer')
@section('page_title', 'Edit Customer')

@section('content')

<style>

.customer-form-card{
    border:none;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.customer-form-header{
    padding:28px 32px;
    border-bottom:1px solid #eef2f7;
    background:#f8fafc;
}

.customer-form-title{
    font-size:24px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:4px;
}

.customer-form-subtitle{
    color:#64748b;
    font-size:14px;
}

.customer-form-body{
    padding:32px;
}

.customer-preview{
    background:#f8fafc;
    border:1px solid #eef2f7;
    border-radius:20px;
    padding:20px;
    margin-bottom:28px;
}

.customer-avatar{
    width:70px;
    height:70px;
    border-radius:18px;
    background:#2563eb;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    font-weight:800;
}

.customer-name{
    font-size:20px;
    font-weight:800;
    color:#0f172a;
}

.customer-meta{
    color:#64748b;
    font-size:14px;
}

@media(max-width:768px){

    .customer-form-header{
        padding:22px;
    }

    .customer-form-body{
        padding:22px;
    }

    .customer-preview{
        flex-direction:column;
        align-items:flex-start !important;
    }

}

</style>

<div class="card customer-form-card">

    <div class="customer-form-header">

        <div class="customer-form-title">

            Edit Customer

        </div>

        <div class="customer-form-subtitle">

            Update customer billing and GST information

        </div>

    </div>

    <div class="customer-form-body">

        {{-- CUSTOMER PREVIEW --}}
        <div class="customer-preview d-flex align-items-center gap-3">

            <div class="customer-avatar">

                {{ strtoupper(substr($customer->name,0,1)) }}

            </div>

            <div>

                <div class="customer-name">

                    {{ $customer->company_name ?? $customer->name }}

                </div>

                <div class="customer-meta">

                    {{ $customer->email ?? 'No Email Address' }}

                </div>

            </div>

        </div>

        {{-- ERRORS --}}
        @if ($errors->any())

            <div class="alert alert-danger border-0 rounded-4 mb-4">

                @foreach ($errors->all() as $error)

                    <div>{{ $error }}</div>

                @endforeach

            </div>

        @endif

        {{-- FORM --}}
        <form method="POST"
              action="{{ route('customers.update', $customer) }}">

            @csrf
            @method('PUT')

            @include('admin.customers._form', ['customer' => $customer])

        </form>

    </div>

</div>

@endsection