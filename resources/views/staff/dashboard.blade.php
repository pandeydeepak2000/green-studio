@extends('layouts.staff')

@section('title', 'Staff Dashboard')
@section('page_title', 'Staff Dashboard')

@push('styles')

<style>

.dashboard-hero{
    position:relative;
    overflow:hidden;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    border-radius:24px;
    padding:32px;
    color:#fff;
    box-shadow:0 15px 35px rgba(37,99,235,.25);
}

.dashboard-hero::before{
    content:'';
    position:absolute;
    right:-60px;
    top:-60px;
    width:220px;
    height:220px;
    background:rgba(255,255,255,.08);
    border-radius:50%;
}

.hero-title{
    font-size:36px;
    font-weight:800;
    margin-bottom:12px;
}

.hero-subtitle{
    font-size:15px;
    line-height:1.7;
    color:rgba(255,255,255,.88);
}

.stats-card{
    border:none;
    border-radius:22px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 8px 24px rgba(15,23,42,.06);
    height:100%;
}

.stats-card .card-body{
    padding:24px;
}

.card-icon{
    width:56px;
    height:56px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
    margin-bottom:16px;
}

.icon-blue{
    background:#dbeafe;
}

.icon-green{
    background:#dcfce7;
}

.icon-orange{
    background:#ffedd5;
}

.icon-purple{
    background:#ede9fe;
}

.card-label{
    font-size:13px;
    text-transform:uppercase;
    font-weight:700;
    color:#94a3b8;
    margin-bottom:6px;
}

.card-title{
    font-size:30px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:8px;
}

.card-description{
    color:#64748b;
    font-size:14px;
}

.quick-card{
    border:none;
    border-radius:22px;
    background:#fff;
    box-shadow:0 8px 24px rgba(15,23,42,.06);
    height:100%;
}

.quick-card .card-body{
    padding:26px;
}

.quick-title{
    font-size:22px;
    font-weight:800;
    margin-bottom:10px;
}

.quick-desc{
    font-size:14px;
    color:#64748b;
    line-height:1.7;
    margin-bottom:20px;
}

.quick-btn{
    border-radius:14px;
    padding:10px 18px;
    font-weight:700;
}

</style>

@endpush

@section('content')

<div class="container-fluid">

    {{-- HERO --}}
    <div class="dashboard-hero mb-4">

        <div class="hero-title">

            Welcome back,
            {{ auth()->user()->name }}

        </div>

        <div class="hero-subtitle">

            Create GST invoices, manage customers
            and track your billing activity easily.

        </div>

    </div>

    {{-- STATS --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card stats-card">

                <div class="card-body">

                    <div class="card-icon icon-blue">
                        🧾
                    </div>

                    <div class="card-label">
                        My Invoices
                    </div>

                    <div class="card-title">
                        {{ $myInvoices }}
                    </div>

                    <div class="card-description">
                        Total invoices created by you.
                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card stats-card">

                <div class="card-body">

                    <div class="card-icon icon-green">
                        💰
                    </div>

                    <div class="card-label">
                        Monthly Sales
                    </div>

                    <div class="card-title">
                        ₹{{ number_format($monthlySales, 2) }}
                    </div>

                    <div class="card-description">
                        Your current month sales.
                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card stats-card">

                <div class="card-body">

                    <div class="card-icon icon-orange">
                        ⏳
                    </div>

                    <div class="card-label">
                        Pending Payments
                    </div>

                    <div class="card-title">
                        ₹{{ number_format($pendingPayments, 2) }}
                    </div>

                    <div class="card-description">
                        Unpaid invoice amount.
                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card stats-card">

                <div class="card-body">

                    <div class="card-icon icon-purple">
                        ✅
                    </div>

                    <div class="card-label">
                        Paid Invoices
                    </div>

                    <div class="card-title">
                        {{ $paidInvoices }}
                    </div>

                    <div class="card-description">
                        Successfully paid invoices.
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- QUICK ACTIONS --}}
    <div class="row g-4">

        <div class="col-lg-4">

            <div class="card quick-card">

                <div class="card-body">

                    <div class="quick-title">
                        🧾 Create Invoice
                    </div>

                    <div class="quick-desc">

                        Generate professional GST invoices
                        with automatic tax calculations.

                    </div>

                    <a href="{{ route('staff.invoices.create') }}"
                       class="btn btn-primary quick-btn">

                        New Invoice

                    </a>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card quick-card">

                <div class="card-body">

                    <div class="quick-title">
                        👥 Customers
                    </div>

                    <div class="quick-desc">

                        Add, update and manage
                        customer GST information.

                    </div>

                    <a href="{{ route('staff.customers.index') }}"
                       class="btn btn-outline-success quick-btn">

                        Open Customers

                    </a>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card quick-card">

                <div class="card-body">

                    <div class="quick-title">
                        📄 Invoice List
                    </div>

                    <div class="quick-desc">

                        View invoice history,
                        payment status and billing details.

                    </div>

                    <a href="{{ route('staff.invoices.index') }}"
                       class="btn btn-outline-dark quick-btn">

                        View Invoices

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection