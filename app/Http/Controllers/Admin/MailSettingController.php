<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\MailSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailSettingController extends Controller
{
    public function index()
    {
        $setting = MailSetting::first();

        if (!$setting) {
            $setting = new MailSetting([
                'mail_from_name' => config('mail.from.name', 'Green Studio'),
                'mail_from_address' => config('mail.from.address', 'billing@greenstudio.com'),
                'mail_mailer' => config('mail.default', 'smtp'),
                'mail_host' => config('mail.mailers.smtp.host', 'mail.greenstudio.com'),
                'mail_port' => (int) config('mail.mailers.smtp.port', 465),
                'mail_username' => config('mail.mailers.smtp.username', ''),
                'mail_encryption' => config('mail.mailers.smtp.encryption', 'ssl'),
            ]);
        }

        return view('admin.mail_settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'mail_from_name' => 'required|string|max:255',
            'mail_from_address' => 'required|email|max:255',
            'mail_mailer' => 'required|string|in:smtp,sendmail,log',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'required|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|in:ssl,tls,none',
        ]);

        $setting = MailSetting::first();

        $data = [
            'mail_from_name' => $request->mail_from_name,
            'mail_from_address' => $request->mail_from_address,
            'mail_mailer' => $request->mail_mailer,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_encryption' => $request->mail_encryption === 'none' ? null : $request->mail_encryption,
        ];

        if ($request->filled('mail_password')) {
            $data['mail_password'] = $request->mail_password;
        }

        if ($setting) {
            $setting->update($data);
        } else {
            $data['mail_password'] = $request->mail_password ?? '';
            $setting = MailSetting::create($data);
        }

        MailSetting::applyConfig();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'user_role' => auth()->user()->role ?? 'admin',
            'action' => 'mail_settings_updated',
            'description' => "Updated email sender address to {$setting->mail_from_address} ({$setting->mail_from_name})",
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', '✅ Email sender & SMTP settings updated successfully!');
    }

    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email|max:255',
        ]);

        $setting = MailSetting::first();
        if ($setting) {
            MailSetting::applyConfig();
        }

        $recipient = $request->test_email;
        $fromName = $setting->mail_from_name ?? config('mail.from.name', 'Green Studio');
        $fromEmail = $setting->mail_from_address ?? config('mail.from.address', 'billing@greenstudio.com');

        try {
            Mail::html(
                '<div style="font-family: Arial, sans-serif; max-width: 580px; margin: 0 auto; padding: 28px; border: 1px solid #e2e8f0; border-radius: 16px; background: #ffffff;">'
                . '<div style="margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">'
                . '<h2 style="color: #16a34a; margin: 0; font-size: 24px; font-weight: 800;">🌿 Green Studio</h2>'
                . '</div>'
                . '<h3 style="color: #0f172a; margin-top: 0; margin-bottom: 12px; font-size: 18px;">Email Configuration Test Verification</h3>'
                . '<p style="color: #334155; font-size: 14px; line-height: 1.6;">Hello,</p>'
                . '<p style="color: #334155; font-size: 14px; line-height: 1.6;">This is a test verification email sent from <strong>Green Studio GST Invoicing Portal</strong> to confirm that your outgoing email configuration is active and working.</p>'
                . '<div style="background: #f0fdf4; border-left: 4px solid #16a34a; padding: 14px 18px; margin: 20px 0; border-radius: 8px;">'
                . '<p style="margin: 0; font-size: 14px; color: #166534; font-weight: 700;">✅ Outgoing Email / SMTP is Working Perfectly!</p>'
                . '<p style="margin: 6px 0 0; font-size: 13px; color: #14532d;"><strong>Sender:</strong> ' . htmlspecialchars($fromName) . ' &lt;' . htmlspecialchars($fromEmail) . '&gt;</p>'
                . '<p style="margin: 4px 0 0; font-size: 13px; color: #14532d;"><strong>Time Sent:</strong> ' . now()->format('d M Y, h:i A') . '</p>'
                . '</div>'
                . '<p style="color: #64748b; font-size: 13px; line-height: 1.6;">Customer invoices, account notifications, and password reset links will be delivered through this configured email.</p>'
                . '<hr style="border: none; border-top: 1px solid #e2e8f0; margin: 24px 0;">'
                . '<p style="font-size: 12px; color: #94a3b8; margin: 0;">Green Studio • Koshi College Road, Chitragupt Nagar, Khagaria, Bihar - 851205</p>'
                . '</div>',
                function ($message) use ($recipient, $fromName, $fromEmail) {
                    $message->to($recipient)
                        ->subject('Green Studio - Email Configuration Test')
                        ->from($fromEmail, $fromName);
                }
            );

            ActivityLog::create([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name ?? 'Admin',
                'user_role' => auth()->user()->role ?? 'admin',
                'action' => 'test_email_sent',
                'description' => "Sent test verification email to {$recipient}",
                'ip_address' => $request->ip(),
            ]);

            return back()->with('status', "✅ Test email sent successfully to {$recipient}! Please check your inbox or spam folder.");
        } catch (\Throwable $e) {
            return back()->with('error', "❌ Email sending failed: " . $e->getMessage());
        }
    }
}
