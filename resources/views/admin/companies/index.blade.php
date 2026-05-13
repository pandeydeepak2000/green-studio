@extends('layouts.admin')

@section('title', 'Companies')
@section('page_title', 'Companies')

@section('content')

<style>

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    flex-wrap:wrap;
    margin-bottom:24px;
}

.page-title{
    font-size:28px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:4px;
}

.page-subtitle{
    color:#64748b;
    font-size:14px;
}

.company-card{
    border:none;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.company-table thead{
    background:#f8fafc;
}

.company-table th{
    padding:16px;
    font-size:13px;
    font-weight:700;
    color:#475569;
    white-space:nowrap;
}

.company-table td{
    padding:18px 16px;
    vertical-align:middle;
}

.company-logo{
    width:52px;
    height:52px;
    border-radius:16px;
    object-fit:cover;
    border:1px solid #e2e8f0;
    background:#fff;
}

.company-avatar{
    width:52px;
    height:52px;
    border-radius:16px;
    background:#2563eb;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
    font-weight:800;
}

.company-name{
    font-size:15px;
    font-weight:800;
    color:#0f172a;
}

.company-gstin{
    font-size:13px;
    color:#64748b;
}

.default-badge{
    background:#dcfce7;
    color:#15803d;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.normal-badge{
    background:#e2e8f0;
    color:#475569;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.action-btn{
    border-radius:12px;
    font-size:13px;
    font-weight:700;
    padding:8px 14px;
}

.empty-box{
    padding:70px 20px;
    text-align:center;
}

.empty-title{
    font-size:20px;
    font-weight:800;
    color:#0f172a;
    margin-top:12px;
}

.empty-subtitle{
    color:#64748b;
    font-size:14px;
}

@media(max-width:768px){

    .page-title{
        font-size:22px;
    }

    .company-table th,
    .company-table td{
        white-space:nowrap;
    }

}

</style>

@if(session('status'))

    <div class="alert alert-success border-0 shadow-sm rounded-4">

        {{ session('status') }}

    </div>

@endif

<div class="page-header">

    <div>

        <div class="page-title">

            Company Management

        </div>

        <div class="page-subtitle">

            Manage billing companies and GST profiles

        </div>

    </div>

    <div>

        <a href="{{ route('companies.create') }}"
           class="btn btn-primary action-btn">

            + Add Company

        </a>

    </div>

</div>

<div class="card company-card">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0 company-table">

                <thead>

                    <tr>

                        <th>Company</th>
                        <th>State</th>
                        <th>Default</th>
                        <th class="text-end">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($companies as $company)

                        <tr>

                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    @if($company->logo_path)

                                        <img src="{{ asset('storage/'.$company->logo_path) }}"
                                             class="company-logo"
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

                            </td>

                            <td>

                                {{ $company->state ?? '-' }}

                            </td>

                            <td>

                                @if($company->is_default)

                                    <span class="default-badge">

                                        Default

                                    </span>

                                @else

                                    <span class="normal-badge">

                                        Standard

                                    </span>

                                @endif

                            </td>

                            <td class="text-end">

                                <a href="{{ route('companies.edit', $company) }}"
                                   class="btn btn-outline-primary action-btn">

                                    Edit

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4">

                                <div class="empty-box">

                                    <div style="font-size:48px;">

                                        🏢

                                    </div>

                                    <div class="empty-title">

                                        No Companies Found

                                    </div>

                                    <div class="empty-subtitle">

                                        Add your first company to start GST billing.

                                    </div>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection