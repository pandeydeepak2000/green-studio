@extends('layouts.staff')

@section('title', 'Add Customer')
@section('page_title', 'Add Customer')

@push('styles')

<style>

.customer-form-wrapper{
    max-width:1000px;
    margin:auto;
}

.customer-form-card{
    border:none;
    border-radius:26px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.customer-form-header{
    padding:28px 30px;
    border-bottom:1px solid #eef2f7;
    background:linear-gradient(to right,#ffffff,#f8fafc);
}

.customer-form-title{
    font-size:28px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:4px;
}

.customer-form-subtitle{
    font-size:14px;
    color:#64748b;
}

.customer-form-body{
    padding:30px;
}

.form-label{
    font-size:13px;
    font-weight:700;
    color:#334155;
    margin-bottom:8px;
}

.form-control{
    min-height:50px;
    border-radius:16px;
    border:1px solid #dbe2ea;
    box-shadow:none !important;
    padding-left:16px;
}

textarea.form-control{
    min-height:120px;
    padding-top:14px;
    border-radius:18px;
}

.form-control:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.12) !important;
}

.btn{
    border-radius:16px;
    font-weight:700;
    padding:11px 20px;
}

.customer-actions{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:26px;
    flex-wrap:wrap;
}

.alert{
    border:none;
    border-radius:18px;
}

@media(max-width:768px){

    .customer-form-header{
        padding:22px;
    }

    .customer-form-body{
        padding:22px;
    }

    .customer-form-title{
        font-size:24px;
    }

    .btn{
        width:100%;
    }

}

</style>

@endpush

@section('content')

<div class="container-fluid py-4 px-lg-4 px-2">

    <div class="customer-form-wrapper">

        @if ($errors->any())

            <div class="alert alert-danger shadow-sm mb-4">

                @foreach ($errors->all() as $error)

                    <div>{{ $error }}</div>

                @endforeach

            </div>

        @endif

        <div class="card customer-form-card">

            {{-- HEADER --}}
            <div class="customer-form-header">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                        <div class="customer-form-title">

                            Add Customer

                        </div>

                        <div class="customer-form-subtitle">

                            Create new customer with GST billing details

                        </div>

                    </div>

                    <a href="{{ route('staff.customers.index') }}"
                       class="btn btn-light border">

                        Back

                    </a>

                </div>

            </div>

            {{-- BODY --}}
            <div class="customer-form-body">

                <form method="POST"
                      action="{{ route('staff.customers.store') }}">

                    @csrf

                    <div class="row g-4">

                        {{-- CUSTOMER NAME --}}
                        <div class="col-md-6">

                            <label class="form-label">

                                Customer Name *

                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   required>

                        </div>

                        {{-- COMPANY --}}
                        <div class="col-md-6">

                            <label class="form-label">

                                Company Name

                            </label>

                            <input type="text"
                                   name="company_name"
                                   class="form-control @error('company_name') is-invalid @enderror"
                                   value="{{ old('company_name') }}">

                        </div>

                        {{-- PHONE --}}
                        <div class="col-md-6">

                            <label class="form-label">

                                Phone *

                            </label>

                            <input type="text"
                                   name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}"
                                   required>

                        </div>

                        {{-- EMAIL --}}
                        <div class="col-md-6">

                            <label class="form-label">

                                Email *

                            </label>

                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   required>

                        </div>

                        {{-- GST --}}
                        <div class="col-md-6">

                            <label class="form-label">

                                GST Number

                            </label>

                            <input type="text"
                                   name="gst_number"
                                   class="form-control @error('gst_number') is-invalid @enderror"
                                   value="{{ old('gst_number') }}">

                        </div>

                        {{-- STATE --}}
                        <div class="col-md-6">

                            <label class="form-label">

                                State *

                            </label>

                            <input type="text"
                                   name="state"
                                   class="form-control @error('state') is-invalid @enderror"
                                   value="{{ old('state') }}"
                                   required>

                        </div>

                        {{-- ADDRESS --}}
                        <div class="col-12">

                            <label class="form-label">

                                Address *

                            </label>

                            <textarea
                                name="address"
                                class="form-control @error('address') is-invalid @enderror"
                                required>{{ old('address') }}</textarea>

                        </div>

                    </div>

                    {{-- ACTIONS --}}
                    <div class="customer-actions">

                        <a href="{{ route('staff.customers.index') }}"
                           class="btn btn-light border">

                            Cancel

                        </a>

                        <button type="submit"
                                class="btn btn-primary">

                            Save Customer

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection