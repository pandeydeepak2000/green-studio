@extends('layouts.staff')

@section('title', 'Staff Dashboard - Green Studio')
@section('page_title', 'Staff Billing Dashboard')

@push('styles')
<style>
.dash-hero{
    position:relative;
    overflow:hidden;
    background:linear-gradient(135deg, #064e3b 0%, #0f172a 60%, #061e12 100%);
    border-radius:20px;
    padding:30px 32px;
    color:#fff;
    box-shadow:0 14px 35px rgba(6, 78, 59, 0.25);
    border:1px solid rgba(255,255,255,0.08);
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

.kpi-card{
    background:#ffffff;
    border:1px solid #e2e8f0;
    border-radius:18px;
    padding:20px;
    box-shadow:0 6px 20px rgba(15,23,42,0.04);
    height:100%;
    transition:all 0.2s;
}

.kpi-card:hover{
    transform:translateY(-3px);
    box-shadow:0 12px 28px rgba(15,23,42,0.08);
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
</style>
@endpush

@section('content')

<div class="container-fluid">

    {{-- HERO BANNER --}}
    <div class="dash-hero mb-4">
        <div class="hero-pill">
            🌿 Green Studio • Staff Billing Operations
        </div>

        <div class="dash-hero-title">
            Welcome back, {{ auth()->user()->name }} 👋
        </div>

        <div class="dash-hero-subtitle">
            Generate GST compliant invoices, register customers, verify UPI transactions, and print or download computer-generated tax bills.
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('staff.invoices.create') }}" class="btn-hero-primary">
                <span>➕</span> Create New Invoice
            </a>
            <a href="{{ route('staff.customers.create') }}" class="btn-hero-glass">
                <span>👥</span> Add Customer
            </a>
            <a href="{{ route('staff.invoices.index') }}" class="btn-hero-glass">
                <span>🧾</span> Invoices List
            </a>
        </div>
    </div>

    {{-- KPIS --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div>
                        <div class="kpi-label">My Invoices</div>
                        <div class="kpi-value text-primary">{{ $myInvoices }}</div>
                    </div>
                    <div class="kpi-icon" style="background:#dbeafe; color:#1d4ed8;">🧾</div>
                </div>
                <div class="text-muted small">Total invoices created by you</div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div>
                        <div class="kpi-label">Month Billing</div>
                        <div class="kpi-value text-success">₹{{ number_format($monthlySales, 2) }}</div>
                    </div>
                    <div class="kpi-icon" style="background:#dcfce7; color:#15803d;">💰</div>
                </div>
                <div class="text-muted small">Current month gross billed</div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div>
                        <div class="kpi-label">Paid Invoices</div>
                        <div class="kpi-value text-success">{{ $paidInvoices }}</div>
                    </div>
                    <div class="kpi-icon" style="background:#dcfce7; color:#16a34a;">✅</div>
                </div>
                <div class="text-muted small">Verified & paid transactions</div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div>
                        <div class="kpi-label">Pending Payments</div>
                        <div class="kpi-value text-danger">₹{{ number_format($pendingPayments, 2) }}</div>
                    </div>
                    <div class="kpi-icon" style="background:#fee2e2; color:#dc2626;">⏳</div>
                </div>
                <div class="text-muted small">Outstanding unpaid invoices</div>
            </div>
        </div>
    </div>

    {{-- RECENT INVOICES --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-header bg-light border-bottom p-3 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                <span>🧾</span> My Recent Invoices
            </h6>
            <a href="{{ route('staff.invoices.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold" style="font-size: 11.5px;">
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
                                No invoices created yet. <a href="{{ route('staff.invoices.create') }}" class="text-success fw-bold">Create your first invoice</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection