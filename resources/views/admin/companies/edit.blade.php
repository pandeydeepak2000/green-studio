@extends('layouts.admin')

@section('title', 'Edit Company')
@section('page_title', 'Edit Company')

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

.company-preview{
    background:#f8fafc;
    border:1px solid #eef2f7;
    border-radius:20px;
    padding:20px;
    margin-bottom:28px;
}

.company-logo-preview{
    width:70px;
    height:70px;
    border-radius:18px;
    object-fit:cover;
    border:1px solid #e2e8f0;
    background:#fff;
}

.company-avatar{
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

.company-name{
    font-size:20px;
    font-weight:800;
    color:#0f172a;
}

.company-gstin{
    color:#64748b;
    font-size:14px;
}

@media(max-width:768px){

    .company-form-header{
        padding:22px;
    }

    .company-form-body{
        padding:22px;
    }

    .company-preview{
        flex-direction:column;
        align-items:flex-start !important;
    }

}

</style>

<div class="card company-form-card">

    <div class="company-form-header">

        <div class="company-form-title">

            Edit Company

        </div>

        <div class="company-form-subtitle">

            Update company GST and billing information

        </div>

    </div>

    <div class="company-form-body">

        {{-- COMPANY PREVIEW --}}
        <div class="company-preview d-flex align-items-center gap-3">

            @if($company->logo_path)

                <img src="{{ asset('storage/'.$company->logo_path) }}"
                     class="company-logo-preview"
                     alt="{{ $company->name }}">

            @else

                <div class="company-avatar">

                    {{ strtoupper(substr($company->name,0,1)) }}

                </div>

            @endif

            <div>

                <div class="company-name">

                    {{ $company->name }}

                </div>

                <div class="company-gstin">

                    GSTIN:
                    {{ $company->gstin ?? '-' }}

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
              action="{{ route('companies.update', $company) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            @include('admin.companies._form', ['company' => $company])

        </form>

    </div>

</div>

@endsection