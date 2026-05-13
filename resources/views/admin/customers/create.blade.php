@extends('layouts.admin')

@section('title', 'Add Customer')
@section('page_title', 'Add Customer')

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

@media(max-width:768px){

    .customer-form-header{
        padding:22px;
    }

    .customer-form-body{
        padding:22px;
    }

}

</style>

<div class="card customer-form-card">

    <div class="customer-form-header">

        <div class="customer-form-title">

            Add New Customer

        </div>

        <div class="customer-form-subtitle">

            Create customer profile and GST details

        </div>

    </div>

    <div class="customer-form-body">

        @if ($errors->any())

            <div class="alert alert-danger border-0 rounded-4 mb-4">

                @foreach ($errors->all() as $error)

                    <div>{{ $error }}</div>

                @endforeach

            </div>

        @endif

        <form method="POST"
              action="{{ route('customers.store') }}">

            @csrf

            @include('admin.customers._form', ['customer' => null])

        </form>

    </div>

</div>

@endsection