ALTER TABLE prefix_config
ADD `mail_use` TINYINT(1) NOT NULL DEFAULT '0',
    ADD `smail_path` VARCHAR(30) NOT NULL DEFAULT '/usr/sbin/sendmail'
