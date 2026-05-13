@extends('layouts.admin')

@section('title', 'Dashboard - GST Invoice')
@section('page_title', 'Admin Dashboard')

@push('styles')

<style>

.dashboard-hero{
    position:relative;
    overflow:hidden;
    border-radius:26px;
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    padding:34px;
    color:#fff;
    box-shadow:0 18px 40px rgba(37,99,235,.25);
}

.dashboard-hero::before{
    content:'';
    position:absolute;
    right:-70px;
    top:-70px;
    width:240px;
    height:240px;
    border-radius:50%;
    background:rgba(255,255,255,.08);
}

.dashboard-hero::after{
    content:'';
    position:absolute;
    bottom:-100px;
    left:-80px;
    width:280px;
    height:280px;
    border-radius:50%;
    background:rgba(255,255,255,.05);
}

.hero-badge{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.15);
    padding:8px 16px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
    margin-bottom:18px;
}

.hero-title{
    font-size:38px;
    font-weight:800;
    line-height:1.15;
    margin-bottom:12px;
}

.hero-subtitle{
    max-width:680px;
    color:rgba(255,255,255,.88);
    line-height:1.8;
    font-size:15px;
}

.stats-card{
    border:none;
    border-radius:22px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 10px 25px rgba(15,23,42,.06);
    transition:.25s ease;
    height:100%;
}

.stats-card:hover{
    transform:translateY(-4px);
    box-shadow:0 18px 40px rgba(15,23,42,.12);
}

.stats-card .card-body{
    padding:26px;
}

.stats-icon{
    width:58px;
    height:58px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
    margin-bottom:18px;
}

.icon-blue{
    background:#dbeafe;
    color:#2563eb;
}

.icon-green{
    background:#dcfce7;
    color:#16a34a;
}

.icon-orange{
    background:#ffedd5;
    color:#ea580c;
}

.icon-purple{
    background:#ede9fe;
    color:#7c3aed;
}

.stats-label{
    font-size:13px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.05em;
    color:#94a3b8;
    margin-bottom:8px;
}

.stats-value{
    font-size:34px;
    font-weight:800;
    color:#0f172a;
    line-height:1;
    margin-bottom:10px;
}

.stats-desc{
    font-size:14px;
    color:#64748b;
    line-height:1.6;
}

.section-title{
    font-size:24px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:18px;
}

.activity-card{
    border:none;
    border-radius:22px;
    background:#fff;
    box-shadow:0 10px 25px rgba(15,23,42,.06);
}

.activity-card .card-body{
    padding:24px;
}

.activity-item{
    display:flex;
    align-items:flex-start;
    gap:14px;
    padding-bottom:18px;
    margin-bottom:18px;
    border-bottom:1px solid #e5e7eb;
}

.activity-item:last-child{
    border-bottom:none;
    margin-bottom:0;
    padding-bottom:0;
}

.activity-icon{
    width:42px;
    height:42px;
    border-radius:12px;
    background:#eff6ff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
}

.activity-title{
    font-weight:700;
    color:#0f172a;
    margin-bottom:3px;
}

.activity-time{
    font-size:12px;
    color:#64748b;
}

@media (max-width: 575.98px){

    .hero-title{
        font-size:28px;
    }

    .stats-value{
        font-size:28px;
    }

}

</style>

@endpush

@section('content')

<div class="container-fluid">

    {{-- HERO --}}
    <div class="dashboard-hero mb-4">

        <div class="hero-badge">
            🚀 Admin Control Center
        </div>

        <div class="hero-title">
            Welcome back,
            {{ auth()->user()->name }}
        </div>

        <div class="hero-subtitle">
            Monitor invoices, GST billing, staff activity,
            customers and complete business reports from one dashboard.
        </div>

    </div>

    {{-- MAIN STATS --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card stats-card">

                <div class="card-body">

                    <div class="stats-icon icon-blue">
                        💰
                    </div>

                    <div class="stats-label">
                        Today Sales
                    </div>

                    <div class="stats-value">
                        ₹{{ number_format($todaySales, 2) }}
                    </div>

                    <div class="stats-desc">
                        Today's invoice sales.
                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card stats-card">

                <div class="card-body">

                    <div class="stats-icon icon-green">
                        📈
                    </div>

                    <div class="stats-label">
                        Monthly Sales
                    </div>

                    <div class="stats-value">
                        ₹{{ number_format($monthlySales, 2) }}
                    </div>

                    <div class="stats-desc">
                        Current month revenue.
                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card stats-card">

                <div class="card-body">

                    <div class="stats-icon icon-orange">
                        🧾
                    </div>

                    <div class="stats-label">
                        GST Collected
                    </div>

                    <div class="stats-value">
                        ₹{{ number_format($totalGST, 2) }}
                    </div>

                    <div class="stats-desc">
                        Total GST amount collected.
                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card stats-card">

                <div class="card-body">

                    <div class="stats-icon icon-purple">
                        📄
                    </div>

                    <div class="stats-label">
                        Total Invoices
                    </div>

                    <div class="stats-value">
                        {{ $paidInvoices + $unpaidInvoices }}
                    </div>

                    <div class="stats-desc">
                        All generated invoices.
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- EXTRA STATS --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="card stats-card">

                <div class="card-body">

                    <div class="stats-icon icon-green">
                        ✅
                    </div>

                    <div class="stats-label">
                        Paid Invoices
                    </div>

                    <div class="stats-value">
                        {{ $paidInvoices }}
                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card stats-card">

                <div class="card-body">

                    <div class="stats-icon icon-orange">
                        ⏳
                    </div>

                    <div class="stats-label">
                        Unpaid Invoices
                    </div>

                    <div class="stats-value">
                        {{ $unpaidInvoices }}
                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card stats-card">

                <div class="card-body">

                    <div class="stats-icon icon-blue">
                        👥
                    </div>

                    <div class="stats-label">
                        Customers
                    </div>

                    <div class="stats-value">
                        {{ $totalCustomers }}
                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card stats-card">

                <div class="card-body">

                    <div class="stats-icon icon-purple">
                        👨‍💼
                    </div>

                    <div class="stats-label">
                        Staff Users
                    </div>

                    <div class="stats-value">
                        {{ $totalStaff }}
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ACTIVITY LOGS --}}
    <div class="section-title">
        Recent Activity
    </div>

    <div class="card activity-card">

        <div class="card-body">

            @forelse($recentActivities as $activity)

                <div class="activity-item">

                    <div class="activity-icon">
                        📜
                    </div>

                    <div>

                        <div class="activity-title">

                            {{ $activity->description }}

                        </div>

                        <div class="activity-time">

                            {{ $activity->user->name ?? 'Unknown' }}
                            •
                            {{ $activity->created_at->diffForHumans() }}

                        </div>

                    </div>

                </div>

            @empty

                <div class="text-muted text-center py-4">

                    No activity found.

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection