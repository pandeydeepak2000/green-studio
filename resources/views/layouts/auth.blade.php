<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Green Studio - Invoicing Portal')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            min-height:100vh;
            background:
                radial-gradient(circle at top left, rgba(22, 163, 74, 0.16), transparent 35%),
                radial-gradient(circle at bottom right, rgba(37, 99, 235, 0.12), transparent 35%),
                linear-gradient(135deg, #060b13, #0b1322 55%, #071710);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:16px;
        }

        .auth-page{
            width:100%;
            max-width:860px;
            display:grid;
            grid-template-columns:1fr 400px;
            background:rgba(255,255,255,.03);
            backdrop-filter:blur(16px);
            border:1px solid rgba(255,255,255,.1);
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 20px 45px -10px rgba(0,0,0,0.55);
        }

        /* LEFT BRANDING SIDE */
        .auth-left{
            padding:32px 30px;
            color:#fff;
            display:flex;
            flex-direction:column;
            justify-content:center;
            position:relative;
            border-right:1px solid rgba(255,255,255,0.07);
            background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(22,163,74,0.04));
        }

        .auth-badge{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:4px 12px;
            border-radius:999px;
            background:rgba(22, 163, 74, 0.15);
            border:1px solid rgba(22, 163, 74, 0.35);
            width:max-content;
            font-size:11px;
            font-weight:700;
            color:#4ade80;
            margin-bottom:14px;
            letter-spacing:0.3px;
        }

        .auth-main-title{
            font-size:24px;
            line-height:1.2;
            font-weight:900;
            margin-bottom:8px;
            letter-spacing:-0.4px;
        }

        .auth-main-subtitle{
            font-size:12.5px;
            line-height:1.55;
            color:rgba(255,255,255,.72);
            max-width:390px;
            margin-bottom:20px;
        }

        .auth-features{
            display:grid;
            gap:10px;
        }

        .feature-item{
            display:flex;
            align-items:center;
            gap:10px;
            background:rgba(255,255,255,0.03);
            border:1px solid rgba(255,255,255,0.05);
            padding:8px 12px;
            border-radius:10px;
        }

        .feature-icon{
            width:28px;
            height:28px;
            border-radius:7px;
            background:rgba(255,255,255,.08);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:13px;
            flex-shrink:0;
        }

        .feature-text{
            color:rgba(255,255,255,.84);
            line-height:1.35;
            font-size:11.5px;
        }

        /* RIGHT FORM SIDE */
        .auth-right{
            background:#ffffff;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:28px 28px;
        }

        .auth-card{
            width:100%;
        }

        /* COMMON AUTH FORM STYLES */
        .auth-title{
            font-size:21px;
            font-weight:800;
            color:#0f172a;
            margin-bottom:3px;
            letter-spacing:-0.3px;
        }

        .auth-subtitle{
            font-size:12px;
            color:#64748b;
            line-height:1.45;
            margin-bottom:18px;
        }

        .auth-form .form-label{
            font-size:11.5px;
            font-weight:700;
            color:#334155;
            margin-bottom:5px;
            text-transform:uppercase;
            letter-spacing:0.3px;
        }

        .auth-form .form-control{
            height:40px;
            min-height:40px;
            font-size:13.5px;
            border-radius:10px;
            border:1.5px solid #e2e8f0;
            background:#f8fafc;
            box-shadow:none !important;
            padding:6px 12px;
            transition:all 0.15s ease;
        }

        .auth-form .form-control:focus{
            background:#ffffff;
            border-color:#16a34a;
            box-shadow:0 0 0 3px rgba(22,163,74,.12) !important;
        }

        .auth-form .btn-primary{
            height:42px;
            min-height:42px;
            border-radius:10px;
            font-weight:700;
            font-size:13.5px;
            background:linear-gradient(135deg, #16a34a, #15803d);
            border:none;
            box-shadow:0 4px 12px rgba(22,163,74,.22);
            transition:all 0.15s ease;
        }

        .auth-form .btn-primary:hover{
            background:linear-gradient(135deg, #15803d, #166534);
            box-shadow:0 6px 16px rgba(22,163,74,.32);
            transform:translateY(-1px);
        }

        .auth-link{
            color:#16a34a;
            text-decoration:none;
            font-weight:700;
        }

        .auth-link:hover{
            color:#15803d;
            text-decoration:underline;
        }

        .auth-alert{
            border:none;
            border-radius:10px;
            font-size:12.5px;
            padding:10px 14px;
        }

        /* MOBILE RESPONSIVE */
        @media(max-width:820px){
            .auth-page{
                grid-template-columns:1fr;
                max-width:440px;
            }

            .auth-left{
                display:none;
            }

            .auth-right{
                padding:26px 22px;
            }
        }
    </style>
</head>

<body>

<div class="auth-page">
    {{-- LEFT BRANDING --}}
    <div class="auth-left">
        <div class="auth-badge">
            🌿 Green Studio • Official Portal
        </div>

        <div class="auth-main-title">
            GREEN STUDIO<br>
            <span style="color: #4ade80;">GST Invoicing System</span>
        </div>

        <div class="auth-main-subtitle">
            Manage GST invoices, clients, automatic tax calculations, and download government-compliant invoices for Green Studio.
        </div>

        <div class="auth-features">
            <div class="feature-item">
                <div class="feature-icon">🧾</div>
                <div class="feature-text">
                    <strong>GREEN STUDIO</strong><br>
                    GSTIN: 10DYFPA2189J1ZO (Bihar)
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">🏢</div>
                <div class="feature-text">
                    Koshi College Road, Chitragupt Nagar, Khagaria
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">🔐</div>
                <div class="feature-text">
                    Role-Based Access: Admin Security & Support Portal
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT FORM CONTAINER --}}
    <div class="auth-right">
        <div class="auth-card">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>