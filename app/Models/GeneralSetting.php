<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_description',
        'logo',
        'top_bar_announcements',
        'contact_email',
        'contact_phone',
        'social_links',
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
    ];

    protected $casts = [
        'top_bar_announcements' => 'array',
        'social_links' => 'array',
        'mail_password' => 'encrypted',
    ];
}
