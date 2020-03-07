INSERT INTO `app_admin` (`id`,`first_name`, `last_name`, `email`, `password`,`status`, `profile_status`, `type`, `company_name`, `created_on`,`cash_payment`)
VALUES (NULL,'admin_first_name', 'admin_last_name', 'admin_email', 'admin_password','A', 'V', 'A', 'admin_company_name','admin_created_at','0');
INSERT INTO `app_email_setting` (`id`,`mail_type`,`email_from`,`smtp_host`, `smtp_username`, `smtp_password`, `smtp_port`, `smtp_secure`)
VALUES (NULL,'email_mail_type','email_email_from','email_smtp_host', 'email_smtp_username', 'email_smtp_password', 'email_smtp_port', 'email_smtp_secure');
INSERT INTO `app_site_setting` (`id`,`company_logo`, `company_name`, `company_email1`, `time_zone`)
VALUES (NULL,'site_setting_company_logo','site_setting_company_name', 'site_setting_company_email','Asia/Kolkata');