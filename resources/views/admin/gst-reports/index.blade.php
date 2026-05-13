@extends('layouts.admin')

@section('title', 'GST Reports')
@section('page_title', 'GST Reports')

@section('content')

<style>

.report-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    flex-wrap:wrap;
    margin-bottom:24px;
}

.report-title{
    font-size:28px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:4px;
}

.report-subtitle{
    font-size:14px;
    color:#64748b;
}

.report-card{
    border:none;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.report-card-header{
    padding:28px 32px;
    border-bottom:1px solid #eef2f7;
    background:#f8fafc;
}

.report-card-body{
    padding:32px;
}

.form-label{
    font-size:13px;
    font-weight:700;
    color:#334155;
    margin-bottom:8px;
}

.form-control,
.form-select{
    min-height:52px;
    border-radius:16px;
    border:1px solid #dbe2ea;
    box-shadow:none !important;
}

.form-control:focus,
.form-select:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.10) !important;
}

.download-btn{
    min-height:52px;
    border-radius:16px;
    font-weight:700;
    font-size:14px;
}

.info-box{
    background:#eff6ff;
    border:1px solid #bfdbfe;
    border-radius:20px;
    padding:18px 20px;
    margin-top:22px;
}

.info-title{
    font-size:15px;
    font-weight:800;
    color:#1e3a8a;
    margin-bottom:8px;
}

.info-text{
    color:#475569;
    font-size:14px;
    line-height:1.8;
}

.summary-card{
    border:none;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 8px 24px rgba(15,23,42,.05);
    height:100%;
}

.summary-card .card-body{
    padding:24px;
}

.summary-title{
    font-size:18px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:18px;
}

.summary-table td,
.summary-table th{
    padding:12px 0;
    font-size:14px;
}

.summary-table th{
    color:#475569;
    font-weight:600;
}

.summary-table td{
    text-align:right;
    font-weight:700;
    color:#0f172a;
}

.total-row{
    border-top:1px solid #e2e8f0;
}

.total-row td,
.total-row th{
    padding-top:18px !important;
    font-size:16px !important;
    font-weight:800 !important;
}

.stat-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:18px;
    margin-bottom:28px;
}

.stat-card{
    background:#fff;
    border-radius:22px;
    padding:22px;
    border:1px solid #eef2f7;
    box-shadow:0 6px 20px rgba(15,23,42,.04);
}

.stat-label{
    font-size:13px;
    color:#64748b;
    margin-bottom:8px;
}

.stat-value{
    font-size:28px;
    font-weight:900;
    color:#0f172a;
}

@media(max-width:991px){

    .stat-grid{
        grid-template-columns:repeat(2,1fr);
    }

}

@media(max-width:768px){

    .report-title{
        font-size:22px;
    }

    .report-card-header{
        padding:22px;
    }

    .report-card-body{
        padding:22px;
    }

}

@media(max-width:576px){

    .stat-grid{
        grid-template-columns:1fr;
    }

}

</style>

@if(session('status'))

    <div class="alert alert-success border-0 rounded-4 shadow-sm">

        {{ session('status') }}

    </div>

@endif

<div class="report-header">

    <div>

        <div class="report-title">

            GST Reports & Analytics

        </div>

        <div class="report-subtitle">

            Download GST computation reports and sales summaries

        </div>

    </div>

</div>

@if(!empty($summary))

    <div class="stat-grid">

        <div class="stat-card">

            <div class="stat-label">

                Total Invoices

            </div>

            <div class="stat-value">

                {{ $summary['count'] }}

            </div>

        </div>

        <div class="stat-card">

            <div class="stat-label">

                Taxable Amount

            </div>

            <div class="stat-value">

                ₹{{ number_format($summary['taxable_amount'], 0) }}

            </div>

        </div>

        <div class="stat-card">

            <div class="stat-label">

                GST Collected

            </div>

            <div class="stat-value">

                ₹{{ number_format(
                    $summary['cgst_amount'] +
                    $summary['sgst_amount'] +
                    $summary['igst_amount'],
                    0
                ) }}

            </div>

        </div>

        <div class="stat-card">

            <div class="stat-label">

                Total Sales

            </div>

            <div class="stat-value">

                ₹{{ number_format($summary['total_amount'], 0) }}

            </div>

        </div>

    </div>

@endif

<div class="card report-card">

    <div class="report-card-header">

        <h4 class="mb-1 fw-bold">

            Download GST Report

        </h4>

        <div class="text-muted small">

            Export invoice GST computation data into Excel format

        </div>

    </div>

    <div class="report-card-body">

        <form method="GET"
              action="{{ route('admin.gstReports.download') }}">

            <div class="row g-4">

                {{-- COMPANY --}}
                <div class="col-md-4">

                    <label class="form-label">

                        Select Company

                    </label>

                    <select name="company_id"
                            class="form-select"
                            required>

                        <option value="">
                            Choose company
                        </option>

                        @foreach($companies as $company)

                            <option value="{{ $company->id }}"
                                {{ (int)($company_id ?? 0) === $company->id ? 'selected' : '' }}>

                                {{ $company->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- FROM --}}
                <div class="col-md-3">

                    <label class="form-label">

                        From Date

                    </label>

                    <input type="date"
                           name="from"
                           class="form-control"
                           value="{{ $from ?? '' }}">

                </div>

                {{-- TO --}}
                <div class="col-md-3">

                    <label class="form-label">

                        To Date

                    </label>

                    <input type="date"
                           name="to"
                           class="form-control"
                           value="{{ $to ?? '' }}">

                </div>

                {{-- BUTTON --}}
                <div class="col-md-2 d-flex align-items-end">

                    <button type="submit"
                            class="btn btn-primary w-100 download-btn">

                        Download

                    </button>

                </div>

            </div>

        </form>

        {{-- INFO --}}
        <div class="info-box">

            <div class="info-title">

                Excel Report Includes

            </div>

            <div class="info-text">

                Date, Invoice Number, Customer State,
                GSTIN, Sale Type (LOCAL / CENTRAL),
                Taxable Value, CGST, SGST, IGST,
                Total Invoice Amount and GST Computation Summary.

            </div>

        </div>

        {{-- SUMMARY --}}
        @if(!empty($summary))

            <div class="row mt-4">

                <div class="col-lg-5">

                    <div class="card summary-card">

                        <div class="card-body">

                            <div class="summary-title">

                                Report Summary

                            </div>

                            <table class="table summary-table mb-0">

                                <tr>

                                    <th>

                                        Total Invoices

                                    </th>

                                    <td>

                                        {{ $summary['count'] }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>

                                        Taxable Amount

                                    </th>

                                    <td>

                                        ₹{{ number_format($summary['taxable_amount'], 2) }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>

                                        CGST

                                    </th>

                                    <td>

                                        ₹{{ number_format($summary['cgst_amount'], 2) }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>

                                        SGST

                                    </th>

                                    <td>

                                        ₹{{ number_format($summary['sgst_amount'], 2) }}

                                    </td>

                                </tr>

                                <tr>

                                    <th>

                                        IGST

                                    </th>

                                    <td>

                                        ₹{{ number_format($summary['igst_amount'], 2) }}

                                    </td>

                                </tr>

                                <tr class="total-row">

                                    <th>

                                        Total Sales

                                    </th>

                                    <td>

                                        ₹{{ number_format($summary['total_amount'], 2) }}

                                    </td>

                                </tr>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        @endif

    </div>

</div>

@endsection