@extends('layouts.admin')

@section('title', 'Edit User')
@section('page_title', 'Edit User')

@section('content')

<style>

.user-form-card{
    border:none;
    border-radius:28px;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
    overflow:hidden;
}

.user-form-header{
    padding:28px 32px;
    border-bottom:1px solid #eef2f7;
    background:#f8fafc;
}

.user-form-title{
    font-size:24px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:4px;
}

.user-form-subtitle{
    font-size:14px;
    color:#64748b;
}

.user-form-body{
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

.action-btn{
    border-radius:16px;
    min-height:50px;
    padding:0 22px;
    font-weight:700;
}

.user-info-box{
    background:#f8fafc;
    border-radius:18px;
    padding:18px 20px;
    margin-bottom:28px;
    border:1px solid #eef2f7;
}

.user-avatar{
    width:60px;
    height:60px;
    border-radius:50%;
    background:#2563eb;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
    font-weight:800;
}

.user-name{
    font-size:18px;
    font-weight:800;
    color:#0f172a;
}

.user-email{
    color:#64748b;
    font-size:14px;
}

@media(max-width:768px){

    .user-form-header{
        padding:22px;
    }

    .user-form-body{
        padding:22px;
    }

    .user-info-box{
        flex-direction:column;
        align-items:flex-start !important;
    }

}

</style>

<div class="card user-form-card">

    <div class="user-form-header">

        <div class="user-form-title">

            Edit User

        </div>

        <div class="user-form-subtitle">

            Update admin or staff account details

        </div>

    </div>

    <div class="user-form-body">

        {{-- USER INFO --}}
        <div class="user-info-box d-flex align-items-center gap-3">

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

        {{-- ERRORS --}}
        @if ($errors->any())

            <div class="alert alert-danger rounded-4 border-0 mb-4">

                @foreach ($errors->all() as $error)

                    <div>{{ $error }}</div>

                @endforeach

            </div>

        @endif

        {{-- FORM --}}
        <form method="POST"
              action="{{ route('admin.users.update', $user) }}">

            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- NAME --}}
                <div class="col-md-6">

                    <label class="form-label">

                        Full Name

                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $user->name) }}"
                           placeholder="Enter full name"
                           required>

                </div>

                {{-- EMAIL --}}
                <div class="col-md-6">

                    <label class="form-label">

                        Email Address

                    </label>

                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $user->email) }}"
                           placeholder="Enter email address"
                           required>

                </div>

                {{-- PASSWORD --}}
                <div class="col-md-6">

                    <label class="form-label">

                        New Password

                    </label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Leave blank to keep current password">

                    <div class="small text-muted mt-2">

                        Leave blank if you don't want to change password.

                    </div>

                </div>

                {{-- ROLE --}}
                <div class="col-md-6">

                    <label class="form-label">

                        Role

                    </label>

                    <select name="role"
                            class="form-select"
                            required>

                        <option value="staff"
                            {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>

                            Staff

                        </option>

                        <option value="admin"
                            {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>

                            Admin

                        </option>

                    </select>

                </div>

                {{-- COMPANY --}}
                <div class="col-12">

                    <label class="form-label">

                        Company (Optional)

                    </label>

                    <select name="company_id"
                            class="form-select">

                        <option value="">
                            -- Select Company --
                        </option>

                        @foreach($companies as $company)

                            <option value="{{ $company->id }}"
                                {{ old('company_id', $user->company_id) == $company->id ? 'selected' : '' }}>

                                {{ $company->name }}

                            </option>

                        @endforeach

                    </select>

                    <div class="small text-muted mt-2">

                        Assign company for staff login access.

                    </div>

                </div>

                {{-- BUTTONS --}}
                <div class="col-12 pt-2">

                    <div class="d-flex gap-3 flex-wrap">

                        <button type="submit"
                                class="btn btn-primary action-btn">

                            Update User

                        </button>

                        <a href="{{ route('admin.users.index') }}"
                           class="btn btn-light border action-btn">

                            Cancel

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection