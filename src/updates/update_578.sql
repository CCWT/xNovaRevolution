ALTER TABLE prefix_users
ADD `metal_proc_tech` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0'
AFTER `expedition_tech`,
    ADD `crystal_proc_tech` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0'
AFTER `metal_proc_tech`,
    ADD `deuterium_proc_tech` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0'
AFTER `crystal_proc_tech`;
ALTER TABLE prefix_planets
ADD `starcatcher` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0'
AFTER `bahamut`,
    ADD `ifrit` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0'
AFTER `starcatcher`,
    ADD `shiva` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0'
AFTER `ifrit`,
    ADD `catoblepas` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0'
AFTER `shiva`,
    ADD `oxion` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0'
AFTER `catoblepas`,
    ADD `odin` BIGINT(11) UNSIGNED NOT NULL DEFAULT '0'
AFTER `oxion`;
