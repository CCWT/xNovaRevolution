ALTER TABLE `prefix_config`
ADD `ts_cron_last` INT(11) NOT NULL
AFTER `ts_version`,
    ADD `ts_cron_interval` INT(11) NOT NULL
AFTER `ts_cron_last`,
    ADD `ts_login` VARCHAR(32) NOT NULL
AFTER `ts_cron_interval`,
    ADD `ts_password` VARCHAR(32) NOT NULL
AFTER `ts_login`;
