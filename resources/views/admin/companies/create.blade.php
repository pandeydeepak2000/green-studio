@extends('layouts.admin')

@section('title', 'Add Company')
@section('page_title', 'Add Company')

@section('content')

<style>

.company-form-card{
    border:none;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.company-form-header{
    padding:28px 32px;
    border-bottom:1px solid #eef2f7;
    background:#f8fafc;
}

.company-form-title{
    font-size:24px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:4px;
}

.company-form-subtitle{
    color:#64748b;
    font-size:14px;
}

.company-form-body{
    padding:32px;
}

.action-btn{
    border-radius:16px;
    min-height:50px;
    padding:0 22px;
    font-weight:700;
}

@media(max-width:768px){

    .company-form-header{
        padding:22px;
    }

    .company-form-body{
        padding:22px;
    }

}

</style>

<div class="card company-form-card">

    <div class="company-form-header">

        <div class="company-form-title">

            Add New Company

        </div>

        <div class="company-form-subtitle">

            Create company profile for GST billing and invoices

        </div>

    </div>

    <div class="company-form-body">

        @if ($errors->any())

            <div class="alert alert-danger border-0 rounded-4 mb-4">

                @foreach ($errors->all() as $error)

                    <div>{{ $error }}</div>

                @endforeach

            </div>

        @endif

        <form method="POST"
              action="{{ route('companies.store') }}"
              enctype="multipart/form-data">

            @csrf

            @include('admin.companies._form', ['company' => null])

        </form>

    </div>

</div>

@endsection