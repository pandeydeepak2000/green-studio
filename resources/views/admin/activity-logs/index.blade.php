@extends('layouts.admin')

@section('title', 'Activity Logs')
@section('page_title', 'Activity Logs')

@section('content')

@if(session('status'))
    <div class="alert alert-success border-0 shadow-sm rounded-4">
        {{ session('status') }}
    </div>
@endif

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

    <div>
        <h2 class="fw-bold mb-1" style="color:#0f172a;">
            Activity Logs
        </h2>

        <div class="text-muted">
            Track invoice creation, updates and payment activities.
        </div>
    </div>

    <div class="text-muted small">
        Total Logs:
        <strong>{{ $logs->total() }}</strong>
    </div>

</div>

{{-- FILTER CARD --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">

        <form method="GET">

            <div class="row g-3 align-items-end">

                {{-- SEARCH --}}
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-semibold small">
                        Search
                    </label>

                    <input type="text"
                           name="q"
                           class="form-control form-control-lg rounded-3"
                           placeholder="User, email, invoice..."
                           value="{{ request('q') }}">
                </div>

                {{-- ACTION --}}
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-semibold small">
                        Action
                    </label>

                    <select name="action"
                            class="form-select form-select-lg rounded-3">

                        <option value="">All Actions</option>

                        <option value="create"
                            @selected(request('action') == 'create')>
                            Create
                        </option>

                        <option value="update"
                            @selected(request('action') == 'update')>
                            Update
                        </option>

                        <option value="payment"
                            @selected(request('action') == 'payment')>
                            Payment
                        </option>

                    </select>
                </div>

                {{-- FROM --}}
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-semibold small">
                        From Date
                    </label>

                    <input type="date"
                           name="from"
                           class="form-control form-control-lg rounded-3"
                           value="{{ request('from') }}">
                </div>

                {{-- TO --}}
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-semibold small">
                        To Date
                    </label>

                    <input type="date"
                           name="to"
                           class="form-control form-control-lg rounded-3"
                           value="{{ request('to') }}">
                </div>

                {{-- BUTTON --}}
                <div class="col-lg-2">
                    <button class="btn btn-dark btn-lg w-100 rounded-3">
                        Apply
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

{{-- LOG LIST --}}
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">

    <div class="card-body p-0">

        @forelse($logs as $log)

            <div class="p-4 border-bottom">

                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                    {{-- LEFT --}}
                    <div style="max-width: 850px;">

                        <div class="d-flex align-items-center flex-wrap gap-2 mb-2">

                            {{-- USER --}}
                            <div class="fw-bold fs-5 text-dark">
                                {{ $log->user_name ?? 'Unknown User' }}
                            </div>

                            {{-- ROLE --}}
                            @if($log->role)
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                    {{ strtoupper($log->role) }}
                                </span>
                            @endif

                            {{-- ACTION --}}
                            @php
                                $badgeClass = match($log->action) {
                                    'create' => 'bg-success',
                                    'update' => 'bg-warning text-dark',
                                    'payment' => 'bg-primary',
                                    'delete' => 'bg-danger',
                                    default => 'bg-dark',
                                };
                            @endphp

                            <span class="badge {{ $badgeClass }}">
                                {{ strtoupper($log->action) }}
                            </span>

                        </div>

                        {{-- EMAIL --}}
                        <div class="text-muted small mb-2">
                            {{ $log->user_email ?? '-' }}
                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="mb-2"
                             style="font-size:15px; color:#111827; line-height:1.6;">
                            {{ $log->description }}
                        </div>

                        {{-- META --}}
                        <div class="d-flex flex-wrap gap-3 small text-muted">

                            <div>
                                <strong>Module:</strong>
                                {{ ucfirst($log->module ?? '-') }}
                            </div>

                            <div>
                                <strong>IP:</strong>
                                {{ $log->ip_address ?? '-' }}
                            </div>

                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="text-end">

                        <div class="fw-semibold text-dark">
                            {{ $log->created_at->format('d M Y') }}
                        </div>

                        <div class="small text-muted">
                            {{ $log->created_at->format('h:i A') }}
                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="text-center py-5">

                <div style="font-size:60px;">
                    📜
                </div>

                <h4 class="fw-bold mt-3">
                    No activity logs found
                </h4>

                <div class="text-muted">
                    Activities will appear here automatically.
                </div>

            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    @if($logs->hasPages())

        <div class="card-footer bg-white border-0 py-3">

            {{ $logs->links() }}

        </div>

    @endif

</div>

@endsection