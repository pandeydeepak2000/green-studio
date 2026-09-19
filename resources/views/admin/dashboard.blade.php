@extends('layouts.admin')

@section('title', 'Admin Dashboard - Green Studio')
@section('page_title', 'Admin Dashboard')

@push('styles')
<style>
/* ==========================================================================
   EXECUTIVE DASHBOARD THEME
   ========================================================================== */
.dash-hero{
    position:relative;
    overflow:hidden;
    border-radius:20px;
    background:linear-gradient(135deg, #064e3b 0%, #0f172a 60%, #061e12 100%);
    padding:30px 32px;
    color:#fff;
    box-shadow:0 14px 35px rgba(6, 78, 59, 0.25);
    border:1px solid rgba(255,255,255,0.08);
}

.dash-hero::before{
    content:'';
    position:absolute;
    right:-40px;
    top:-40px;
    width:220px;
    height:220px;
    border-radius:50%;
    background:radial-gradient(circle, rgba(34, 197, 94, 0.18), transparent 70%);
    pointer-events:none;
}

.hero-pill{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:rgba(255,255,255,0.1);
    border:1px solid rgba(255,255,255,0.15);
    padding:5px 14px;
    border-radius:999px;
    font-size:11.5px;
    font-weight:700;
    color:#86efac;
    margin-bottom:12px;
    letter-spacing:0.3px;
}

.dash-hero-title{
    font-size:28px;
    font-weight:900;
    line-height:1.2;
    margin-bottom:6px;
    letter-spacing:-0.4px;
}

.dash-hero-subtitle{
    font-size:13.5px;
    color:rgba(255,255,255,0.78);
    max-width:580px;
    margin-bottom:20px;
    line-height:1.5;
}

.hero-actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.btn-hero-primary{
    background:#22c55e;
    color:#052e16;
    font-weight:800;
    font-size:13px;
    padding:9px 18px;
    border-radius:10px;
    border:none;
    display:inline-flex;
    align-items:center;
    gap:6px;
    text-decoration:none;
    transition:all 0.2s;
    box-shadow:0 4px 14px rgba(34,197,94,0.3);
}

.btn-hero-primary:hover{
    background:#16a34a;
    color:#fff;
    transform:translateY(-1px);
}

.btn-hero-glass{
    background:rgba(255,255,255,0.1);
    color:#fff;
    font-weight:700;
    font-size:13px;
    padding:9px 16px;
    border-radius:10px;
    border:1px solid rgba(255,255,255,0.2);
    display:inline-flex;
    align-items:center;
    gap:6px;
    text-decoration:none;
    transition:all 0.2s;
}

.btn-hero-glass:hover{
    background:rgba(255,255,255,0.18);
    color:#fff;
    transform:translateY(-1px);
}

/* KPI METRIC CARDS */
.kpi-card{
    background:#ffffff;
    border:1px solid #e2e8f0;
    border-radius:18px;
    padding:20px;
    box-shadow:0 6px 20px rgba(15,23,42,0.04);
    height:100%;
    transition:all 0.2s;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.kpi-card:hover{
    transform:translateY(-3px);
    box-shadow:0 12px 28px rgba(15,23,42,0.08);
    border-color:#cbd5e1;
}

.kpi-top{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:12px;
}

.kpi-icon{
    width:44px;
    height:44px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
    flex-shrink:0;
}

.kpi-icon-green{
    background:#dcfce7;
    color:#15803d;
}

.kpi-icon-blue{
    background:#dbeafe;
    color:#1d4ed8;
}

.kpi-icon-purple{
    background:#ede9fe;
    color:#6d28d9;
}

.kpi-icon-amber{
    background:#fef3c7;
    color:#b45309;
}

.kpi-label{
    font-size:11.5px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:0.5px;
    color:#64748b;
    margin-bottom:4px;
}

.kpi-value{
    font-size:24px;
    font-weight:900;
    color:#0f172a;
    letter-spacing:-0.4px;
    line-height:1.2;
}

.kpi-desc{
    font-size:12px;
    color:#94a3b8;
    margin-top:6px;
}

/* SECOND ROW METRICS */
.pill-card{
    background:#ffffff;
    border:1px solid #e2e8f0;
    border-radius:14px;
    padding:14px 18px;
    display:flex;
    align-items:center;
    gap:14px;
    box-shadow:0 4px 12px rgba(15,23,42,0.03);
    transition:all 0.2s;
}

.pill-card:hover{
    border-color:#cbd5e1;
    transform:translateY(-2px);
}

.pill-icon{
    width:38px;
    height:38px;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:17px;
    flex-shrink:0;
}

.pill-title{
    font-size:11.5px;
    font-weight:700;
    color:#64748b;
    text-transform:uppercase;
    letter-spacing:0.3px;
}

.pill-val{
    font-size:18px;
    font-weight:900;
    color:#0f172a;
}

.pill-sub{
    font-size:11px;
    color:#94a3b8;
}

/* SECTION CARDS */
.section-card{
    background:#ffffff;
    border:1px solid #e2e8f0;
    border-radius:18px;
    box-shadow:0 6px 20px rgba(15,23,42,0.04);
    overflow:hidden;
}

.section-card-header{
    padding:16px 20px;
    background:#f8fafc;
    border-bottom:1px solid #e2e8f0;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.section-card-title{
    font-size:15px;
    font-weight:800;
    color:#0f172a;
    margin:0;
    display:flex;
    align-items:center;
    gap:8px;
}

/* TABLE STYLING */
.custom-table th{
    font-size:11.5px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:0.4px;
    color:#64748b;
    background:#f8fafc;
    padding:12px 16px;
    border-bottom:1px solid #e2e8f0;
}

.custom-table td{
    padding:12px 16px;
    vertical-align:middle;
    border-bottom:1px solid #f1f5f9;
    font-size:13px;
}

.custom-table tr:hover td{
    background:#fcfdfe;
}

/* TIMELINE */
.activity-row{
    display:flex;
    align-items:flex-start;
    gap:12px;
    padding:12px 0;
    border-bottom:1px solid #f1f5f9;
}

.activity-row:last-child{
    border-bottom:none;
    padding-bottom:0;
}

.activity-dot{
    width:30px;
    height:30px;
    border-radius:8px;
    background:#f1f5f9;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:13px;
    flex-shrink:0;
}

.activity-text{
    font-size:12.5px;
    font-weight:600;
    color:#1e293b;
    line-height:1.4;
}

.activity-time{
    font-size:11px;
    color:#94a3b8;
    margin-top:2px;
}
</style>
@endpush

@section('content')

<div class="container-fluid">

    {{-- HERO EXECUTIVE BANNER --}}
    <div class="dash-hero mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
            <div class="hero-pill">
                🌿 Green Studio • GST Billing & Portal
            </div>
            <div class="text-white small fw-bold" style="opacity:0.85;">
                📅 {{ now()->format('l, d F Y') }}
            </div>
        </div>

        <div class="dash-hero-title">
            Welcome back, {{ auth()->user()->name }} 👋
        </div>

        <div class="dash-hero-subtitle">
            Khagaria Portal: Bihar GSTIN <strong>10DYFPA2189J1ZO</strong>. Manage sales, issue tax invoices, monitor GST tax liabilities, and oversee staff operations in real-time.
        </div>

        <div class="hero-actions">
            <a href="{{ route('staff.invoices.create') }}" class="btn-hero-primary">
                <span>➕</span> Create New Invoice
            </a>
            <a href="{{ route('customers.create') }}" class="btn-hero-glass">
                <span>👥</span> Add Customer
            </a>
            <a href="{{ route('admin.mailSettings.index') }}" class="btn-hero-glass">
                <span>✉️</span> Email Settings
            </a>
            <a href="{{ route('admin.gstReports.index') }}" class="btn-hero-glass">
                <span>📊</span> GST Reports
            </a>
        </div>
    </div>

    {{-- TOP 4 PRIMARY FINANCIAL KPIS --}}
    <div class="row g-3 mb-4">
        {{-- TODAY'S SALES --}}
        <div class="col-xl-3 col-sm-6">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div>
                        <div class="kpi-label">Today's Sales</div>
                        <div class="kpi-value text-success">
                            ₹{{ number_format($todaySales, 2) }}
                        </div>
                    </div>
                    <div class="kpi-icon kpi-icon-green">
                        💰
                    </div>
                </div>
                <div class="kpi-desc">
                    Invoices billed today ({{ now()->format('d M') }})
                </div>
            </div>
        </div>

        {{-- MONTHLY SALES --}}
        <div class="col-xl-3 col-sm-6">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div>
                        <div class="kpi-label">Month Revenue ({{ now()->format('M Y') }})</div>
                        <div class="kpi-value text-primary">
                            ₹{{ number_format($monthlySales, 2) }}
                        </div>
                    </div>
                    <div class="kpi-icon kpi-icon-blue">
                        📈
                    </div>
                </div>
                <div class="kpi-desc">
                    Total billing this calendar month
                </div>
            </div>
        </div>

        {{-- TOTAL GST COLLECTED --}}
        <div class="col-xl-3 col-sm-6">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div>
                        <div class="kpi-label">Total GST Tax</div>
                        <div class="kpi-value" style="color: #6d28d9;">
                            ₹{{ number_format($totalGST, 2) }}
                        </div>
                    </div>
                    <div class="kpi-icon kpi-icon-purple">
                        🧾
                    </div>
                </div>
                <div class="kpi-desc">
                    Combined CGST + SGST + IGST
                </div>
            </div>
        </div>

        {{-- ALL-TIME TOTAL SALES --}}
        <div class="col-xl-3 col-sm-6">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div>
                        <div class="kpi-label">Total All-Time Billing</div>
                        <div class="kpi-value" style="color: #b45309;">
                            ₹{{ number_format($totalSalesAllTime, 2) }}
                        </div>
                    </div>
                    <div class="kpi-icon kpi-icon-amber">
                        🏛️
                    </div>
                </div>
                <div class="kpi-desc">
                    Total gross invoicing volume
                </div>
            </div>
        </div>
    </div>

    {{-- SECOND ROW: INVOICE & USER STATUS PILLS --}}
    <div class="row g-3 mb-4">
        {{-- PAID INVOICES --}}
        <div class="col-lg-3 col-sm-6">
            <div class="pill-card">
                <div class="pill-icon" style="background:#dcfce7; color:#16a34a;">
                    ✓
                </div>
                <div>
                    <div class="pill-title">Paid Invoices</div>
                    <div class="pill-val text-success">{{ $paidInvoices }}</div>
                    <div class="pill-sub">₹{{ number_format($paidAmount, 2) }} collected</div>
                </div>
            </div>
        </div>

        {{-- UNPAID INVOICES --}}
        <div class="col-lg-3 col-sm-6">
            <div class="pill-card">
                <div class="pill-icon" style="background:#fee2e2; color:#dc2626;">
                    ⏳
                </div>
                <div>
                    <div class="pill-title">Pending / Unpaid</div>
                    <div class="pill-val text-danger">{{ $unpaidInvoices }}</div>
                    <div class="pill-sub">₹{{ number_format($unpaidAmount, 2) }} outstanding</div>
                </div>
            </div>
        </div>

        {{-- CUSTOMERS --}}
        <div class="col-lg-3 col-sm-6">
            <div class="pill-card">
                <div class="pill-icon" style="background:#e0f2fe; color:#0284c7;">
                    👥
                </div>
                <div>
                    <div class="pill-title">Clients & Customers</div>
                    <div class="pill-val">{{ $totalCustomers }}</div>
                    <div class="pill-sub">Active buyer accounts</div>
                </div>
            </div>
        </div>

        {{-- STAFF USERS --}}
        <div class="col-lg-3 col-sm-6">
            <div class="pill-card">
                <div class="pill-icon" style="background:#f3e8ff; color:#7e22ce;">
                    👨‍💼
                </div>
                <div>
                    <div class="pill-title">Staff & Support</div>
                    <div class="pill-val">{{ $totalStaff }}</div>
                    <div class="pill-sub">Authorized team users</div>
                </div>
            </div>
        </div>
    </div>

    {{-- SPLIT SECTION: RECENT INVOICES (LEFT 8) & EMAIL + ACTIVITY (RIGHT 4) --}}
    <div class="row g-4 mb-4">
        {{-- RECENT INVOICES TABLE --}}
        <div class="col-lg-8">
            <div class="section-card h-100">
                <div class="section-card-header">
                    <h6 class="section-card-title">
                        <span>🧾</span> Recent Invoices
                    </h6>
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold" style="font-size: 11.5px;">
                        View All Invoices →
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0 custom-table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentInvoices as $inv)
                                <tr>
                                    <td>
                                        <a href="{{ route('staff.invoices.show', $inv) }}" class="fw-bold text-decoration-none text-dark">
                                            #{{ $inv->invoice_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $inv->customer->name ?? 'N/A' }}</div>
                                        @if(!empty($inv->customer->company_name))
                                            <div class="text-muted small" style="font-size: 11px;">{{ $inv->customer->company_name }}</div>
                                        @endif
                                    </td>
                                    <td class="text-muted">
                                        {{ \Carbon\Carbon::parse($inv->invoice_date)->format('d M Y') }}
                                    </td>
                                    <td>
                                        <strong class="text-dark">₹{{ number_format($inv->total_amount, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill {{ $inv->status === 'paid' ? 'bg-success' : 'bg-danger' }} px-2.5 py-1" style="font-size: 11px;">
                                            ● {{ strtoupper($inv->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('staff.invoices.show', $inv) }}" class="btn btn-sm btn-light border rounded-3 px-2 py-1" title="View Invoice">
                                            👁️
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        No invoices generated yet. <a href="{{ route('staff.invoices.create') }}" class="text-success fw-bold">Create the first invoice</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- EMAIL SERVICE & LIVE ACTIVITY (RIGHT 4) --}}
        <div class="col-lg-4">
            {{-- EMAIL SERVICE STATUS CARD --}}
            <div class="section-card mb-4" style="background: linear-gradient(to bottom, #ffffff, #f0fdf4);">
                <div class="section-card-header" style="background: rgba(22, 163, 74, 0.08);">
                    <h6 class="section-card-title text-success">
                        <span>✉️</span> Customer Email Service
                    </h6>
                    <a href="{{ route('admin.mailSettings.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-2 py-0.5 fw-bold" style="font-size: 11px;">
                        Configure ⚙️
                    </a>
                </div>
                <div class="p-3 small">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted">Sender From:</span>
                        <strong class="text-dark">{{ $mailSetting->mail_from_address ?? config('mail.from.address', 'billing@greenstudio.com') }}</strong>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted">Sender Name:</span>
                        <span class="badge bg-light text-dark border">{{ $mailSetting->mail_from_name ?? 'Green Studio' }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-muted">Driver:</span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle">{{ strtoupper($mailSetting->mail_mailer ?? 'smtp') }}</span>
                    </div>
                    <div class="text-center pt-2 border-top">
                        <a href="{{ route('admin.mailSettings.index') }}" class="btn btn-sm btn-success w-100 rounded-3 py-1.5 fw-bold" style="font-size: 12px;">
                            Test & Update Mail Settings
                        </a>
                    </div>
                </div>
            </div>

            {{-- LIVE ACTIVITY LOGS --}}
            <div class="section-card">
                <div class="section-card-header">
                    <h6 class="section-card-title">
                        <span>📜</span> Recent Operations
                    </h6>
                    <a href="{{ route('admin.activityLogs.index') }}" class="text-muted small text-decoration-none" style="font-size: 11.5px;">
                        Logs →
                    </a>
                </div>
                <div class="p-3">
                    @forelse($recentActivities as $activity)
                        <div class="activity-row">
                            <div class="activity-dot">
                                📌
                            </div>
                            <div>
                                <div class="activity-text">
                                    {{ $activity->description }}
                                </div>
                                <div class="activity-time">
                                    {{ $activity->user->name ?? 'System' }} • {{ $activity->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted text-center py-3 small">
                            No recent activity found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>

@endsection