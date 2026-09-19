@extends('layouts.admin')

@section('title', 'Users')
@section('page_title', 'Users')

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

.user-card{
    border:none;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
}

.user-table thead{
    background:#f8fafc;
}

.user-table th{
    padding:16px;
    font-size:13px;
    font-weight:700;
    color:#475569;
    white-space:nowrap;
}

.user-table td{
    padding:16px;
    vertical-align:middle;
}

.user-avatar{
    width:42px;
    height:42px;
    border-radius:50%;
    background:#2563eb;
    color:#fff;
    font-weight:700;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:15px;
}

.user-name{
    font-weight:700;
    color:#0f172a;
}

.user-email{
    font-size:13px;
    color:#64748b;
}

.role-badge{
    border-radius:999px;
    padding:7px 14px;
    font-size:12px;
    font-weight:700;
}

.role-admin{
    background:#dbeafe;
    color:#1d4ed8;
}

.role-staff{
    background:#dcfce7;
    color:#15803d;
}

.action-btn{
    border-radius:12px;
    font-size:13px;
    font-weight:600;
    padding:8px 14px;
}

.empty-box{
    padding:70px 20px;
    text-align:center;
}

.empty-title{
    font-size:18px;
    font-weight:700;
    color:#0f172a;
    margin-top:14px;
}

.empty-subtitle{
    color:#64748b;
    font-size:14px;
}

@media(max-width:768px){

    .page-title{
        font-size:22px;
    }

    .user-table th,
    .user-table td{
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

            User Management

        </div>

        <div class="page-subtitle">

            Manage admin and staff accounts

        </div>

    </div>

    <div>

        <a href="{{ route('admin.users.create') }}"
           class="btn btn-dark action-btn">

            + Add User

        </a>

    </div>

</div>

<div class="card user-card">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0 user-table">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Company</th>
                        <th>Approval</th>
                        <th class="text-end">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr>

                            <td>

                                {{ $users->firstItem() + $loop->index }}

                            </td>

                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    <div class="user-avatar">

                                        {{ strtoupper(substr($user->name,0,1)) }}

                                    </div>

                                    <div>

                                        <div class="user-name">

                                            {{ $user->name }}

                                        </div>

                                        <div class="user-email">

                                            {{ $user->email }}

                                        </div>

                                    </div>

                                </div>

                            </td>

                            <td>

                                @if($user->role === 'admin')

                                    <span class="role-badge role-admin">

                                        ADMIN

                                    </span>

                                @else

                                    <span class="role-badge role-staff">

                                        STAFF

                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ $user->company->name ?? '-' }}

                            </td>

                            <td>

                                @if($user->is_approved || $user->role === 'admin')

                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                        ✓ Approved
                                    </span>

                                @else

                                    <div class="d-flex align-items-center gap-1">
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1 rounded-pill">
                                            ⏳ Pending
                                        </span>

                                        <form action="{{ route('admin.users.approve', $user) }}"
                                              method="POST"
                                              onsubmit="return confirm('Approve user {{ $user->name }}?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-2 py-0" style="font-size: 11px;">
                                                Approve
                                            </button>
                                        </form>
                                    </div>

                                @endif

                            </td>

                            <td class="text-end">

                                <div class="d-flex justify-content-end gap-2 flex-wrap">

                                    <form action="{{ route('admin.users.sendResetLink', $user) }}"
                                          method="POST"
                                          onsubmit="return confirm('Send password reset email to {{ $user->email }}?')">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-outline-secondary action-btn"
                                                title="Send password reset link to user email">
                                            ✉️ Reset Pass
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="btn btn-outline-primary action-btn">

                                        Edit

                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this user?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-outline-danger action-btn">

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6">

                                <div class="empty-box">

                                    <div style="font-size:46px;">
                                        👤
                                    </div>

                                    <div class="empty-title">

                                        No Users Found

                                    </div>

                                    <div class="empty-subtitle">

                                        Create your first staff or admin user.

                                    </div>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    @if($users->hasPages())

        <div class="card-footer bg-white border-0 py-3">

            {{ $users->links() }}

        </div>

    @endif

</div>

@endsection