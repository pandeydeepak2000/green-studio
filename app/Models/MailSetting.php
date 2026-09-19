<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class MailSetting extends Model
{
    protected $fillable = [
        'mail_from_name',
        'mail_from_address',
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
    ];

    /**
     * Apply the mail settings to runtime Laravel mail configuration.
     */
    public static function applyConfig(): ?self
    {
        $setting = self::first();

        if ($setting) {
            if (!empty($setting->mail_mailer)) {
                Config::set('mail.default', $setting->mail_mailer);
            }
            if (!empty($setting->mail_host)) {
                Config::set('mail.mailers.smtp.host', $setting->mail_host);
            }
            if (!empty($setting->mail_port)) {
                Config::set('mail.mailers.smtp.port', (int) $setting->mail_port);
            }
            if (!empty($setting->mail_username)) {
                Config::set('mail.mailers.smtp.username', $setting->mail_username);
            }
            if (!empty($setting->mail_password)) {
                Config::set('mail.mailers.smtp.password', $setting->mail_password);
            }
            if (!empty($setting->mail_encryption)) {
                Config::set('mail.mailers.smtp.encryption', $setting->mail_encryption === 'none' ? null : $setting->mail_encryption);
            }
            if (!empty($setting->mail_from_address)) {
                Config::set('mail.from.address', $setting->mail_from_address);
            }
            if (!empty($setting->mail_from_name)) {
                Config::set('mail.from.name', $setting->mail_from_name);
            }
        }

        return $setting;
    }
}
