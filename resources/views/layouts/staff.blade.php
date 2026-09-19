<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>@yield('title', 'GST Staff Panel')</title>

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>

        :root{
            --sidebar-bg:#020617;
            --sidebar-hover:#0f172a;
            --sidebar-text:#cbd5e1;
            --sidebar-active:#fff;
            --border:#e5e7eb;
            --body-bg:#f1f5f9;
        }

        *{
            box-sizing:border-box;
        }

        body{
            margin:0;
            font-family:'Inter',sans-serif;
            background:var(--body-bg);
            overflow-x:hidden;
        }

        /* SIDEBAR */

        .sidebar{
            width:260px;
            background:var(--sidebar-bg);
            color:#fff;
            position:fixed;
            left:0;
            top:0;
            bottom:0;
            z-index:1045;
            padding:20px 14px;
            transition:.25s ease;
            overflow-y:auto;
        }

        .sidebar::-webkit-scrollbar{
            width:4px;
        }

        .sidebar::-webkit-scrollbar-thumb{
            background:#334155;
            border-radius:10px;
        }

        .brand{
            font-size:22px;
            font-weight:800;
            margin-bottom:22px;
            letter-spacing:.3px;
        }

        .user-block{
            padding:14px;
            border-radius:14px;
            background:#0f172a;
            margin-bottom:20px;
        }

        .user-name{
            font-size:15px;
            font-weight:700;
            margin-bottom:2px;
        }

        .user-role{
            font-size:11px;
            color:#94a3b8;
            text-transform:uppercase;
            letter-spacing:.5px;
        }

        .sidebar-menu{
            margin-top:10px;
        }

        .sidebar a.nav-link{
            display:flex;
            align-items:center;
            gap:10px;
            padding:12px 14px;
            border-radius:12px;
            color:var(--sidebar-text);
            text-decoration:none;
            font-size:14px;
            font-weight:600;
            margin-bottom:6px;
            transition:.2s ease;
        }

        .sidebar a.nav-link:hover{
            background:var(--sidebar-hover);
            color:var(--sidebar-active);
        }

        .sidebar a.nav-link.active{
            background:#2563eb;
            color:#fff;
        }

        /* MAIN */

        .main-wrapper{
            margin-left:260px;
            min-height:100vh;
            transition:.25s ease;
        }

        .topbar{
            height:70px;
            background:#fff;
            border-bottom:1px solid var(--border);
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 22px;
            position:sticky;
            top:0;
            z-index:1030;
        }

        .page-title{
            font-size:18px;
            font-weight:700;
            margin:0;
        }

        .content-wrapper{
            padding:22px;
        }

        /* MOBILE TOGGLE */

        .mobile-menu-btn{
            display:none;
            width:42px;
            height:42px;
            border:none;
            border-radius:10px;
            background:#0f172a;
            color:#fff;
            align-items:center;
            justify-content:center;
            font-size:20px;
        }

        .sidebar-overlay{
            position:fixed;
            inset:0;
            background:rgba(0,0,0,.5);
            z-index:1040;
            opacity:0;
            visibility:hidden;
            transition:.25s ease;
        }

        .sidebar-overlay.show{
            opacity:1;
            visibility:visible;
        }

        /* FORM */

        .description-field{
            min-height:90px;
            resize:vertical;
            white-space:pre-wrap;
        }

        /* MOBILE */

        @media (max-width: 991.98px){

            .sidebar{
                transform:translateX(-100%);
                width:280px;
            }

            .sidebar.show{
                transform:translateX(0);
            }

            .main-wrapper{
                margin-left:0;
            }

            .mobile-menu-btn{
                display:flex;
            }

            .topbar{
                padding:0 16px;
            }

            .content-wrapper{
                padding:16px;
            }

        }

        @media (max-width: 575.98px){

            .page-title{
                font-size:16px;
            }

            .topbar{
                height:64px;
            }

            .content-wrapper{
                padding:14px;
            }

        }

        /* PRINT */

        @media print{

            body{
                background:#fff !important;
            }

            .sidebar,
            .topbar,
            .mobile-menu-btn,
            .sidebar-overlay,
            .btn,
            .alert{
                display:none !important;
            }

            .main-wrapper{
                margin:0 !important;
            }

            .content-wrapper{
                padding:0 !important;
            }

            .card{
                border:none !important;
                box-shadow:none !important;
            }

        }

    </style>

@stack('styles')
</head>

<body>

{{-- OVERLAY --}}
<div class="sidebar-overlay"
     id="sidebarOverlay"></div>

{{-- SIDEBAR --}}
<div class="sidebar"
     id="sidebar">

    <div class="brand d-flex align-items-center gap-2">
        <span style="color:#22c55e;">🌿</span>
        <span>Green Studio</span>
    </div>

    {{-- USER --}}
    <div class="user-block">

        <div class="user-name">
            {{ auth()->user()->name ?? '' }}
        </div>

        <div class="user-role">
            🛡️ {{ strtoupper(auth()->user()->role ?? 'Support') }} TEAM
        </div>

    </div>

    {{-- MENU --}}
    <div class="sidebar-menu">

        <a href="{{ route('staff.dashboard') }}"
           class="nav-link @if(request()->routeIs('staff.dashboard')) active @endif">

            <span>🏠</span>
            <span>Dashboard</span>

        </a>

        <a href="{{ route('staff.invoices.create') }}"
           class="nav-link @if(request()->routeIs('staff.invoices.create')) active @endif"
           style="background:rgba(34,197,94,0.12); color:#4ade80; border:1px dashed rgba(34,197,94,0.3);">

            <span>➕</span>
            <span>Create Invoice</span>

        </a>

        <a href="{{ route('staff.customers.index') }}"
           class="nav-link @if(request()->routeIs('staff.customers.*')) active @endif">

            <span>👥</span>
            <span>Customers</span>

        </a>

        <a href="{{ route('staff.invoices.index') }}"
           class="nav-link @if(request()->routeIs('staff.invoices.*') && !request()->routeIs('staff.invoices.create')) active @endif">

            <span>🧾</span>
            <span>Invoices</span>

        </a>

        @if(auth()->check() && auth()->user()->role === 'admin')
            <div class="nav-section-title text-uppercase mt-4 mb-2" style="font-size:11px; letter-spacing:0.08em; color:#64748b; font-weight:700;">
                Admin Controls
            </div>

            <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
                <span>⚙️</span>
                <span>Admin Dashboard</span>
            </a>

            <a href="{{ route('admin.gstReports.index') }}" class="nav-link @if(request()->routeIs('admin.gstReports.*')) active @endif">
                <span>📊</span>
                <span>GST Reports</span>
            </a>

            <a href="{{ route('admin.users.index') }}" class="nav-link @if(request()->routeIs('admin.users.*')) active @endif">
                <span>👨‍💼</span>
                <span>Users</span>
            </a>

            <a href="{{ route('companies.index') }}" class="nav-link @if(request()->routeIs('companies.*')) active @endif">
                <span>🏢</span>
                <span>Companies</span>
            </a>

            <a href="{{ route('admin.activityLogs.index') }}" class="nav-link @if(request()->routeIs('admin.activityLogs.*')) active @endif">
                <span>📜</span>
                <span>Activity Logs</span>
            </a>
        @endif

    </div>

    {{-- LOGOUT --}}
    <form method="POST"
          action="{{ route('logout') }}"
          class="mt-4">

        @csrf

        <button type="submit"
                class="btn btn-outline-light w-100 rounded-3 py-2 fw-semibold">

            Logout

        </button>

    </form>

</div>

{{-- MAIN --}}
<div class="main-wrapper">

    {{-- TOPBAR --}}
    <div class="topbar">

        <div class="d-flex align-items-center gap-3">

            {{-- MOBILE MENU BTN --}}
            <button class="mobile-menu-btn"
                    id="mobileMenuBtn">

                ☰

            </button>

            <h5 class="page-title">
                @yield('page_title', 'Staff Dashboard')
            </h5>

        </div>

        <div class="d-flex align-items-center gap-3">

            <a href="{{ route('staff.invoices.create') }}" class="btn btn-sm btn-primary rounded-pill px-3 py-2 fw-bold d-flex align-items-center gap-1 shadow-sm">
                <span>➕</span> <span>New Invoice</span>
            </a>

            <div class="small text-muted fw-semibold d-none d-md-block">

                {{ now()->format('d M Y') }}

            </div>

        </div>

    </div>

    {{-- CONTENT --}}
    <div class="content-wrapper">

        @yield('content')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

    const sidebar = document.getElementById('sidebar');

    const overlay = document.getElementById('sidebarOverlay');

    const mobileMenuBtn = document.getElementById('mobileMenuBtn');

    function openSidebar(){

        sidebar.classList.add('show');

        overlay.classList.add('show');

    }

    function closeSidebar(){

        sidebar.classList.remove('show');

        overlay.classList.remove('show');

    }

    mobileMenuBtn.addEventListener('click', openSidebar);

    overlay.addEventListener('click', closeSidebar);

</script>

@yield('scripts')

</body>
</html>