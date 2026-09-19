@extends('layouts.admin')

@section('title', 'Email Settings - Green Studio')
@section('page_title', 'Email Configuration')

@section('content')

<style>
.settings-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    flex-wrap:wrap;
    margin-bottom:24px;
}

.settings-title{
    font-size:26px;
    font-weight:800;
    color:#0f172a;
    letter-spacing:-0.4px;
}

.settings-subtitle{
    color:#64748b;
    font-size:13.5px;
}

.config-card{
    border:none;
    border-radius:20px;
    background:#ffffff;
    box-shadow:0 10px 30px rgba(15,23,42,.05);
    border:1px solid #e2e8f0;
    overflow:hidden;
}

.card-header-custom{
    background:#f8fafc;
    border-bottom:1px solid #e2e8f0;
    padding:18px 24px;
    display:flex;
    align-items:center;
    gap:10px;
}

.card-header-title{
    font-size:16px;
    font-weight:800;
    color:#0f172a;
    margin:0;
}

.form-label-custom{
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:0.4px;
    color:#475569;
    margin-bottom:6px;
}

.form-control-custom, .form-select-custom{
    height:44px;
    border-radius:10px;
    border:1.5px solid #cbd5e1;
    font-size:13.5px;
    padding:8px 14px;
    transition:all 0.2s;
}

.form-control-custom:focus, .form-select-custom:focus{
    border-color:#16a34a;
    box-shadow:0 0 0 3px rgba(22,163,74,.15) !important;
}

.btn-save{
    height:44px;
    padding:0 24px;
    border-radius:10px;
    font-weight:700;
    font-size:14px;
    background:linear-gradient(135deg, #16a34a, #15803d);
    border:none;
    color:#fff;
    box-shadow:0 4px 14px rgba(22,163,74,.25);
    transition:all 0.2s;
}

.btn-save:hover{
    background:linear-gradient(135deg, #15803d, #166534);
    transform:translateY(-1px);
    box-shadow:0 6px 18px rgba(22,163,74,.35);
    color:#fff;
}

.btn-test{
    height:44px;
    border-radius:10px;
    font-weight:700;
    font-size:14px;
    background:linear-gradient(135deg, #2563eb, #1d4ed8);
    border:none;
    color:#fff;
    box-shadow:0 4px 14px rgba(37,99,235,.25);
    transition:all 0.2s;
}

.btn-test:hover{
    background:linear-gradient(135deg, #1d4ed8, #1e40af);
    transform:translateY(-1px);
    color:#fff;
}

.info-badge{
    font-size:11.5px;
    background:rgba(22,163,74,0.1);
    color:#15803d;
    padding:3px 10px;
    border-radius:999px;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    gap:4px;
}
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="settings-header">
        <div>
            <div class="settings-title d-flex align-items-center gap-2">
                <span>✉️</span> Outgoing Email & SMTP Settings
            </div>
            <div class="settings-subtitle">
                Configure the email address and SMTP server through which customer invoices, notifications, and reset links will be sent.
            </div>
        </div>
        <div>
            <span class="info-badge">
                🌿 Green Studio Mail Service
            </span>
        </div>
    </div>

    {{-- ALERTS --}}
    @if(session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center gap-2">
            <span class="fs-5">✅</span>
            <div>{{ session('status') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center gap-2">
            <span class="fs-5">⚠️</span>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 p-3">
            <div class="fw-bold mb-1">Please fix the following issues:</div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        {{-- MAIN CONFIGURATION FORM (LEFT) --}}
        <div class="col-lg-8">
            <div class="config-card">
                <div class="card-header-custom">
                    <span>⚙️</span>
                    <h5 class="card-header-title">Sender & Mail Server Configuration</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.mailSettings.update') }}" method="POST">
                        @csrf

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label form-label-custom">Sender Name (From Name)</label>
                                <input type="text"
                                       name="mail_from_name"
                                       value="{{ old('mail_from_name', $setting->mail_from_name) }}"
                                       class="form-control form-control-custom"
                                       placeholder="Green Studio"
                                       required>
                                <div class="text-muted small mt-1" style="font-size: 11.5px;">
                                    The company/brand name that customers see in their inbox.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label form-label-custom">Sender Email (From Address)</label>
                                <input type="email"
                                       name="mail_from_address"
                                       value="{{ old('mail_from_address', $setting->mail_from_address) }}"
                                       class="form-control form-control-custom"
                                       placeholder="billing@greenstudio.com"
                                       required>
                                <div class="text-muted small mt-1" style="font-size: 11.5px;">
                                    The email address customers see as sender and reply-to.
                                </div>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-4">

                        <h6 class="fw-bold text-dark mb-3" style="font-size: 14px;">
                            🔌 SMTP Server Credentials (Optional / cPanel Webmail)
                        </h6>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label form-label-custom">Mail Driver</label>
                                <select name="mail_mailer" class="form-select form-select-custom">
                                    <option value="smtp" {{ old('mail_mailer', $setting->mail_mailer) === 'smtp' ? 'selected' : '' }}>SMTP (Recommended)</option>
                                    <option value="sendmail" {{ old('mail_mailer', $setting->mail_mailer) === 'sendmail' ? 'selected' : '' }}>Sendmail / PHP Mail</option>
                                    <option value="log" {{ old('mail_mailer', $setting->mail_mailer) === 'log' ? 'selected' : '' }}>Log (Testing Only)</option>
                                </select>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label form-label-custom">SMTP Host</label>
                                <input type="text"
                                       name="mail_host"
                                       value="{{ old('mail_host', $setting->mail_host) }}"
                                       class="form-control form-control-custom"
                                       placeholder="e.g. mail.jixsite.com or smtp.gmail.com">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label form-label-custom">SMTP Port</label>
                                <input type="number"
                                       name="mail_port"
                                       value="{{ old('mail_port', $setting->mail_port ?? 465) }}"
                                       class="form-control form-control-custom"
                                       placeholder="465"
                                       required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label form-label-custom">Encryption</label>
                                <select name="mail_encryption" class="form-select form-select-custom">
                                    <option value="ssl" {{ old('mail_encryption', $setting->mail_encryption) === 'ssl' ? 'selected' : '' }}>SSL (Port 465)</option>
                                    <option value="tls" {{ old('mail_encryption', $setting->mail_encryption) === 'tls' ? 'selected' : '' }}>TLS (Port 587)</option>
                                    <option value="none" {{ old('mail_encryption', $setting->mail_encryption) === null || old('mail_encryption', $setting->mail_encryption) === 'none' ? 'selected' : '' }}>None</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label form-label-custom">SMTP Username</label>
                                <input type="text"
                                       name="mail_username"
                                       value="{{ old('mail_username', $setting->mail_username) }}"
                                       class="form-control form-control-custom"
                                       placeholder="user@greenstudio.com">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label form-label-custom">SMTP Password</label>
                                <input type="password"
                                       name="mail_password"
                                       class="form-control form-control-custom"
                                       placeholder="{{ $setting->mail_password ? '•••••••• (Leave blank to keep current)' : 'Enter email password' }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-save d-inline-flex align-items-center gap-2">
                                <span>💾</span> Save Email Configuration
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- TEST EMAIL & HELPFUL TIPS (RIGHT) --}}
        <div class="col-lg-4">
            {{-- TEST EMAIL CARD --}}
            <div class="config-card mb-4" style="background: linear-gradient(to bottom, #ffffff, #f8fafc);">
                <div class="card-header-custom" style="background: rgba(37,99,235,0.06);">
                    <span>🧪</span>
                    <h5 class="card-header-title text-primary">Send Test Email</h5>
                </div>

                <div class="card-body p-4">
                    <p class="text-muted small mb-3" style="line-height: 1.6;">
                        Check your configuration immediately. Enter any recipient email address and click <strong>Send Test Email</strong> to verify outgoing delivery.
                    </p>

                    <form action="{{ route('admin.mailSettings.sendTestEmail') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label form-label-custom">Recipient Email</label>
                            <input type="email"
                                   name="test_email"
                                   value="{{ auth()->user()->email }}"
                                   class="form-control form-control-custom"
                                   placeholder="your-email@gmail.com"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-test w-100 d-inline-flex align-items-center justify-content-center gap-2">
                            <span>📤</span> Send Test Email
                        </button>
                    </form>
                </div>
            </div>

            {{-- HELPER CARD FOR CPANEL / HOSTING --}}
            <div class="config-card">
                <div class="card-header-custom">
                    <span>💡</span>
                    <h5 class="card-header-title">Quick Hosting Guide</h5>
                </div>

                <div class="card-body p-4 small" style="color: #475569; line-height: 1.65;">
                    <div class="mb-2">
                        <strong class="text-dark">cPanel Webmail (Recommended):</strong>
                        <ul class="mb-2 ps-3 mt-1">
                            <li><strong>Host:</strong> <code>mail.yourdomain.com</code></li>
                            <li><strong>Port:</strong> <code>465</code> (SSL)</li>
                            <li><strong>Username:</strong> Your full email address</li>
                        </ul>
                    </div>

                    <div>
                        <strong class="text-dark">Security Tip:</strong>
                        <p class="mb-0 mt-1" style="font-size: 12px;">
                            Always test with the button above after saving. Once verified, all customer invoice emails will be automatically sent from this address.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
