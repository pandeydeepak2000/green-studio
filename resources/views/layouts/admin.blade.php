<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>@yield('title', 'GST Invoice Admin')</title>

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
            --sidebar-active:#2563eb;
            --sidebar-text:#cbd5e1;
            --sidebar-muted:#94a3b8;
            --body-bg:#f1f5f9;
            --border:#e5e7eb;
        }

        *{
            box-sizing:border-box;
        }

        body{
            margin:0;
            font-family:'Inter',system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;
            background:var(--body-bg);
            overflow-x:hidden;
        }

        /* SIDEBAR */

        .sidebar{
            width:270px;
            background:var(--sidebar-bg);
            color:#fff;
            position:fixed;
            inset:0 auto 0 0;
            z-index:1045;
            padding:20px 16px;
            overflow-y:auto;
            transition:.25s ease;
        }

        .sidebar::-webkit-scrollbar{
            width:4px;
        }

        .sidebar::-webkit-scrollbar-thumb{
            background:#334155;
            border-radius:10px;
        }

        .brand{
            font-size:24px;
            font-weight:800;
            margin-bottom:22px;
            letter-spacing:.3px;
        }

        .user-block{
            background:#0f172a;
            padding:14px;
            border-radius:14px;
            margin-bottom:22px;
        }

        .user-name{
            font-size:15px;
            font-weight:700;
            margin-bottom:2px;
        }

        .user-role{
            font-size:11px;
            text-transform:uppercase;
            color:var(--sidebar-muted);
            letter-spacing:.5px;
        }

        .nav-section-title{
            font-size:11px;
            text-transform:uppercase;
            letter-spacing:.08em;
            color:#64748b;
            margin:18px 8px 8px;
            font-weight:700;
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
            color:#fff;
        }

        .sidebar a.nav-link.active{
            background:var(--sidebar-active);
            color:#fff;
        }

        /* MAIN */

        .main-wrapper{
            margin-left:270px;
            min-height:100vh;
            transition:.25s ease;
        }

        .topbar{
            height:70px;
            background:#fff;
            border-bottom:1px solid var(--border);
            display:flex;
            justify-content:space-between;
            align-items:center;
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

        .topbar-right{
            display:flex;
            align-items:center;
            gap:14px;
        }

        .admin-badge{
            background:#eff6ff;
            color:#2563eb;
            font-size:12px;
            font-weight:700;
            padding:6px 12px;
            border-radius:30px;
        }

        .content-wrapper{
            padding:22px;
        }

        /* MOBILE MENU */

        .mobile-menu-btn{
            display:none;
            width:42px;
            height:42px;
            border:none;
            border-radius:10px;
            background:#0f172a;
            color:#fff;
            font-size:20px;
            align-items:center;
            justify-content:center;
        }

        .sidebar-overlay{
            position:fixed;
            inset:0;
            background:rgba(0,0,0,.45);
            z-index:1040;
            opacity:0;
            visibility:hidden;
            transition:.25s ease;
        }

        .sidebar-overlay.show{
            opacity:1;
            visibility:visible;
        }

        /* MOBILE */

        @media (max-width: 991.98px){

            .sidebar{
                transform:translateX(-100%);
                width:290px;
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
            .sidebar-overlay,
            .topbar,
            .mobile-menu-btn,
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

    {{-- BRAND --}}
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
            👑 {{ strtoupper(auth()->user()->role ?? '') }}
        </div>

    </div>

    {{-- MAIN --}}
    <div class="nav-section-title">
        Main
    </div>

    <a href="{{ route('admin.dashboard') }}"
       class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">

        <span>🏠</span>
        <span>Dashboard</span>

    </a>

    <a href="{{ route('staff.invoices.create') }}"
       class="nav-link @if(request()->routeIs('staff.invoices.create')) active @endif"
       style="background:rgba(34,197,94,0.12); color:#4ade80; border:1px dashed rgba(34,197,94,0.3);">

        <span>➕</span>
        <span>Create Invoice</span>

    </a>

    <a href="{{ route('customers.index') }}"
       class="nav-link @if(request()->routeIs('customers.*') || request()->routeIs('staff.customers.*')) active @endif">

        <span>👥</span>
        <span>Customers</span>

    </a>

    <a href="{{ route('admin.invoices.index') }}"
       class="nav-link @if(request()->routeIs('admin.invoices.*') || (request()->routeIs('staff.invoices.*') && !request()->routeIs('staff.invoices.create'))) active @endif">

        <span>🧾</span>
        <span>Invoices</span>

    </a>

    <a href="{{ route('admin.gstReports.index') }}"
       class="nav-link @if(request()->routeIs('admin.gstReports.*')) active @endif">

        <span>📊</span>
        <span>GST Reports</span>

    </a>

    {{-- SETUP --}}
    <div class="nav-section-title">
        Setup
    </div>

    <a href="{{ route('admin.users.index') }}"
       class="nav-link @if(request()->routeIs('admin.users.*')) active @endif">

        <span>👨‍💼</span>
        <span>Users</span>

    </a>

    <a href="{{ route('companies.index') }}"
       class="nav-link @if(request()->routeIs('companies.*')) active @endif">

        <span>🏢</span>
        <span>Companies</span>

    </a>

    <a href="{{ route('admin.activityLogs.index') }}"
       class="nav-link @if(request()->routeIs('admin.activityLogs.*')) active @endif">

        <span>📜</span>
        <span>Activity Logs</span>

    </a>

    <a href="{{ route('admin.mailSettings.index') }}"
       class="nav-link @if(request()->routeIs('admin.mailSettings.*')) active @endif">

        <span>✉️</span>
        <span>Email Settings</span>

    </a>

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

            {{-- MOBILE MENU --}}
            <button class="mobile-menu-btn"
                    id="mobileMenuBtn">

                ☰

            </button>

            <h5 class="page-title">
                @yield('page_title', 'Admin Dashboard')
            </h5>

        </div>

        <div class="topbar-right">

            <a href="{{ route('staff.invoices.create') }}" class="btn btn-sm btn-primary rounded-pill px-3 py-2 fw-bold d-flex align-items-center gap-1 shadow-sm">
                <span>➕</span> <span>New Invoice</span>
            </a>

            <div class="admin-badge">
                ADMIN PANEL
            </div>

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

    const menuBtn = document.getElementById('mobileMenuBtn');

    function openSidebar(){

        sidebar.classList.add('show');

        overlay.classList.add('show');

    }

    function closeSidebar(){

        sidebar.classList.remove('show');

        overlay.classList.remove('show');

    }

    menuBtn.addEventListener('click', openSidebar);

    overlay.addEventListener('click', closeSidebar);

    // Session & Connection Keep-Alive: keeps worker & session warm every 2 minutes
    setInterval(function() {
        if (navigator.onLine) {
            fetch("{{ route('ping') }}", {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            }).catch(function() {});
        }
    }, 120000);

</script>

@yield('scripts')

</body>

</html>