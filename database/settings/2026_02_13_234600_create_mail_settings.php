<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateMailSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('mail.mail_host', '127.0.0.1');
        $this->migrator->add('mail.mail_port', 2525);
        $this->migrator->add('mail.mail_username', '');
        $this->migrator->add('mail.mail_password', '');
        $this->migrator->add('mail.mail_encryption', 'tls');
        $this->migrator->add('mail.mail_from_address', 'hello@yemenimarket.com');
        $this->migrator->add('mail.mail_from_name', 'Yemeni Market');
    }
}
