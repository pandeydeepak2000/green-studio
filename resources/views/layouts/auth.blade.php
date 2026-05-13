<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>
        @yield('title', 'GST Invoice')
    </title>

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            min-height:100vh;
            background:
                radial-gradient(circle at top left,#2563eb22,transparent 35%),
                radial-gradient(circle at bottom right,#1e40af22,transparent 35%),
                linear-gradient(135deg,#020617,#0f172a 45%,#172554);

            font-family:
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            display:flex;
            align-items:center;
            justify-content:center;

            padding:24px;

            overflow-x:hidden;
        }

        .auth-page{
            width:100%;
            max-width:1180px;

            display:grid;
            grid-template-columns:1fr 520px;

            background:rgba(255,255,255,.04);

            backdrop-filter:blur(16px);

            border:1px solid rgba(255,255,255,.08);

            border-radius:32px;

            overflow:hidden;

            box-shadow:
                0 20px 60px rgba(0,0,0,.35);
        }

        /* LEFT SIDE */

        .auth-left{
            padding:70px 60px;

            color:#fff;

            display:flex;
            flex-direction:column;
            justify-content:center;

            position:relative;
            overflow:hidden;
        }

        .auth-badge{
            display:inline-flex;
            align-items:center;
            gap:10px;

            padding:10px 18px;

            border-radius:999px;

            background:rgba(255,255,255,.08);

            border:1px solid rgba(255,255,255,.10);

            width:max-content;

            font-size:13px;
            font-weight:600;

            margin-bottom:28px;
        }

        .auth-main-title{
            font-size:52px;
            line-height:1.1;
            font-weight:900;

            margin-bottom:22px;
        }

        .auth-main-subtitle{
            font-size:18px;
            line-height:1.9;

            color:rgba(255,255,255,.78);

            max-width:520px;
        }

        .auth-features{
            margin-top:42px;

            display:grid;
            gap:18px;
        }

        .feature-item{
            display:flex;
            align-items:flex-start;
            gap:14px;
        }

        .feature-icon{
            width:42px;
            height:42px;

            border-radius:14px;

            background:rgba(255,255,255,.10);

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:18px;

            flex-shrink:0;
        }

        .feature-text{
            color:rgba(255,255,255,.84);
            line-height:1.7;
            font-size:14px;
        }

        /* RIGHT SIDE */

        .auth-right{
            background:#ffffff;

            display:flex;
            align-items:center;
            justify-content:center;

            padding:50px 42px;
        }

        .auth-card{
            width:100%;
            max-width:420px;
        }

        .brand-title{
            font-size:46px;
            font-weight:900;
            line-height:1.1;

            color:#0f172a;

            margin-bottom:14px;
        }

        .brand-subtitle{
            font-size:15px;
            line-height:1.8;

            color:#64748b;

            margin-bottom:12px;
        }

        .brand-mini{
            font-size:13px;
            font-weight:700;
            color:#94a3b8;

            margin-bottom:36px;
        }

        /* MOBILE */

        @media(max-width:991px){

            .auth-page{
                grid-template-columns:1fr;
                max-width:560px;
            }

            .auth-left{
                display:none;
            }

            .auth-right{
                padding:42px 24px;
            }

            .brand-title{
                font-size:40px;
            }

        }

        @media(max-width:576px){

            body{
                padding:14px;
            }

            .auth-page{
                border-radius:24px;
            }

            .auth-right{
                padding:34px 20px;
            }

            .brand-title{
                font-size:34px;
            }

            .brand-subtitle{
                font-size:14px;
            }

        }

    </style>

    @stack('styles')

</head>

<body>

<div class="auth-page">

    {{-- LEFT SIDE --}}
    <div class="auth-left">

        <div class="auth-badge">

            ⚡ Smart GST Billing Platform

        </div>

        <div class="auth-main-title">

            GST Invoice
            Management
            System

        </div>

        <div class="auth-main-subtitle">

            Create professional GST invoices,
            manage customers, track payments,
            generate reports and run your
            complete billing business from one
            modern dashboard.

        </div>

        <div class="auth-features">

            <div class="feature-item">

                <div class="feature-icon">
                    🧾
                </div>

                <div class="feature-text">

                    Professional invoice creation with
                    automatic GST calculations.

                </div>

            </div>

            <div class="feature-item">

                <div class="feature-icon">
                    📊
                </div>

                <div class="feature-text">

                    Sales reports, GST reports and
                    payment tracking dashboard.

                </div>

            </div>

            <div class="feature-item">

                <div class="feature-icon">
                    🔐
                </div>

                <div class="feature-text">

                    Secure admin and staff login
                    system with role management.

                </div>

            </div>

        </div>

    </div>

    {{-- RIGHT SIDE --}}
    <div class="auth-right">

        <div class="auth-card">

            <div class="brand-title">

                GST Invoice Panel

            </div>

            <div class="brand-subtitle">

                Smart GST billing, invoice generation,
                customer management & sales tracking system.

            </div>

            <div class="brand-mini">

                Ambition Management • Billing System

            </div>

            @yield('content')

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>