ALTER TABLE prefix_planets CHANGE `small_ship_cargo` `small_ship_cargo` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `big_ship_cargo` `big_ship_cargo` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `light_hunter` `light_hunter` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `heavy_hunter` `heavy_hunter` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `crusher` `crusher` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `battle_ship` `battle_ship` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `colonizer` `colonizer` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `recycler` `recycler` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `spy_sonde` `spy_sonde` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `bomber_ship` `bomber_ship` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `solar_satelit` `solar_satelit` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `destructor` `destructor` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `dearth_star` `dearth_star` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `battleship` `battleship` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `supernova` `supernova` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `bahamut` `bahamut` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `starcatcher` `starcatcher` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `ifrit` `ifrit` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `shiva` `shiva` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `catoblepas` `catoblepas` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `oxion` `oxion` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `odin` `odin` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `orbital_station` `orbital_station` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `misil_launcher` `misil_launcher` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `small_laser` `small_laser` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `big_laser` `big_laser` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `gauss_canyon` `gauss_canyon` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `ionic_canyon` `ionic_canyon` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `buster_canyon` `buster_canyon` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `graviton_canyon` `graviton_canyon` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `lune_noir` `lune_noir` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `ev_transporter` `ev_transporter` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `star_crasher` `star_crasher` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `giga_recykler` `giga_recykler` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `der_metal` `der_metal` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `der_crystal` `der_crystal` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `thriller` `thriller` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0';
UPDATE prefix_config
SET `config_value` = 'de'
WHERE `config_value` = 'deutsch';
UPDATE prefix_config
SET `config_value` = 'en'
WHERE `config_value` = 'english';
UPDATE prefix_config
SET `config_value` = 'ru'
WHERE `config_value` = 'russian';
UPDATE prefix_config
SET `config_value` = 'es'
WHERE `config_value` = 'spanish';
UPDATE prefix_config
SET `config_value` = 'pt'
WHERE `config_value` = 'portuguese';
UPDATE prefix_users
SET `lang` = 'en'
WHERE `lang` = 'english';
UPDATE prefix_users
SET `lang` = 'ru'
WHERE `lang` = 'russian';
UPDATE prefix_users
SET `lang` = 'es'
WHERE `lang` = 'spanish';
UPDATE prefix_users
SET `lang` = 'pt'
WHERE `lang` = 'portuguese';
ALTER TABLE prefix_users CHANGE `lang` `lang` ENUM('de', 'en', 'es', 'ru', 'pt', 'cn', 'hr') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'de';
ALTER TABLE prefix_users_valid CHANGE `lang` `lang` ENUM('de', 'en', 'es', 'ru', 'pt', 'cn', 'hr') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'de';
UPDATE prefix_users
SET `lang` = 'de'
WHERE `lang` = '';
