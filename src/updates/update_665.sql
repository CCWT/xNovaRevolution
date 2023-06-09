ALTER TABLE `prefix_alliance`
ADD INDEX (`ally_tag`);
ALTER TABLE `prefix_alliance`
ADD INDEX (`ally_name`);
ALTER TABLE `prefix_chat`
ADD INDEX (`timestamp`);
ALTER TABLE `prefix_chat`
ADD INDEX (`ally_id`);
ALTER TABLE `prefix_fleets` CHANGE `fleet_mess` `fleet_mess` ENUM('0', '1', '2') NOT NULL DEFAULT '0';
ALTER TABLE `prefix_fleets` CHANGE `fleet_mission` `fleet_mission` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `fleet_array` `fleet_array` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
    CHANGE `fleet_start_galaxy` `fleet_start_galaxy` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `fleet_start_system` `fleet_start_system` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `fleet_start_planet` `fleet_start_planet` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `fleet_start_type` `fleet_start_type` ENUM('1', '2', '3') NOT NULL DEFAULT '1',
    CHANGE `fleet_end_galaxy` `fleet_end_galaxy` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `fleet_end_system` `fleet_end_system` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `fleet_end_planet` `fleet_end_planet` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `fleet_end_type` `fleet_end_type` ENUM('1', '2', '3') NOT NULL DEFAULT '1';
ALTER TABLE `prefix_fleets`
ADD INDEX (`fleet_mess`);
ALTER TABLE `prefix_fleets`
ADD INDEX (`fleet_target_owner`);
ALTER TABLE `prefix_fleets`
ADD INDEX (`fleet_end_stay`);
ALTER TABLE `prefix_fleets`
ADD INDEX (`fleet_end_time`);
ALTER TABLE `prefix_fleets`
ADD INDEX (`fleet_start_time`);
ALTER TABLE `prefix_messages`
ADD INDEX (`message_sender`);
ALTER TABLE `prefix_messages`
ADD INDEX (`message_type`);
ALTER TABLE `prefix_messages`
ADD INDEX (`message_owner`);
ALTER TABLE `prefix_rw` DROP INDEX `rid`;
ALTER TABLE `prefix_rw` DROP INDEX `time`;
ALTER TABLE `prefix_rw` DROP INDEX `raport`;
ALTER TABLE `prefix_rw`
ADD PRIMARY KEY (`rid`);
ALTER TABLE `prefix_rw` DROP `a_zestrzelona`;
ALTER TABLE `prefix_planets` CHANGE `planet_type` `planet_type` ENUM('1', '3') NOT NULL DEFAULT '1',
    CHANGE `small_protection_shield` `small_protection_shield` ENUM('0', '1') NOT NULL DEFAULT '0',
    CHANGE `planet_protector` `planet_protector` ENUM('0', '1') NOT NULL DEFAULT '0',
    CHANGE `big_protection_shield` `big_protection_shield` ENUM('0', '1') NOT NULL DEFAULT '0',
    CHANGE `graviton_canyon` `graviton_canyon` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `metal_mine_porcent` `metal_mine_porcent` ENUM(
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10'
    ) NOT NULL DEFAULT '10',
    CHANGE `crystal_mine_porcent` `crystal_mine_porcent` ENUM(
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10'
    ) NOT NULL DEFAULT '10',
    CHANGE `deuterium_sintetizer_porcent` `deuterium_sintetizer_porcent` ENUM(
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10'
    ) NOT NULL DEFAULT '10',
    CHANGE `solar_plant_porcent` `solar_plant_porcent` ENUM(
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10'
    ) NOT NULL DEFAULT '10',
    CHANGE `fusion_plant_porcent` `fusion_plant_porcent` ENUM(
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10'
    ) NOT NULL DEFAULT '10',
    CHANGE `solar_satelit_porcent` `solar_satelit_porcent` ENUM(
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10'
    ) NOT NULL DEFAULT '10',
    CHANGE `mondbasis` `mondbasis` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `phalanx` `phalanx` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `sprungtor` `sprungtor` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `lune_noir` `lune_noir` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `ev_transporter` `ev_transporter` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `star_crasher` `star_crasher` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `giga_recykler` `giga_recykler` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `prefix_planets`
ADD INDEX (`id_luna`);
ALTER TABLE `prefix_planets`
ADD INDEX (`galaxy`, `system`, `planet`, `planet_type`);
ALTER TABLE `prefix_planets`
ADD INDEX (`id_owner`);
ALTER TABLE `prefix_planets`
ADD INDEX (`destruyed`);
ALTER TABLE `prefix_supp`
ADD INDEX (`player_id`);
ALTER TABLE `prefix_topkb` DROP INDEX `raport`;
ALTER TABLE `prefix_topkb` DROP INDEX `id_owner2`;
ALTER TABLE `prefix_topkb` DROP INDEX `time`;
ALTER TABLE `prefix_topkb` DROP INDEX `id_owner1`;
ALTER TABLE `prefix_topkb`
ADD INDEX (`gesamtunits`);
ALTER TABLE `prefix_topkb` DROP `id`;
ALTER TABLE `prefix_topkb`
ADD PRIMARY KEY (`rid`);
ALTER TABLE `prefix_topkb` DROP `gesamttruemmer`;
ALTER TABLE `prefix_topkb` DROP `a_zestrzelona`;
ALTER TABLE `prefix_topkb` CHANGE `time` `time` INT(11) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `prefix_users` CHANGE `authlevel` `authlevel` ENUM('0', '1', '2', '3') NOT NULL DEFAULT '0',
    CHANGE `user_agent` `user_agent` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
    CHANGE `settings_tooltiptime` `settings_tooltiptime` TINYINT(1) UNSIGNED NOT NULL DEFAULT '5',
    CHANGE `settings_fleetactions` `settings_fleetactions` ENUM('0', '1') NOT NULL DEFAULT '0',
    CHANGE `settings_planetmenu` `settings_planetmenu` ENUM('0', '1') NOT NULL DEFAULT '1',
    CHANGE `settings_esp` `settings_esp` ENUM('0', '1') NOT NULL DEFAULT '1',
    CHANGE `settings_wri` `settings_wri` ENUM('0', '1') NOT NULL DEFAULT '1',
    CHANGE `settings_bud` `settings_bud` ENUM('0', '1') NOT NULL DEFAULT '1',
    CHANGE `settings_mis` `settings_mis` ENUM('0', '1') NOT NULL DEFAULT '1',
    CHANGE `settings_rep` `settings_rep` ENUM('0', '1') NOT NULL DEFAULT '0',
    CHANGE `settings_tnstor` `settings_tnstor` ENUM('0', '1') NOT NULL DEFAULT '1',
    CHANGE `urlaubs_modus` `urlaubs_modus` ENUM('0', '1') NOT NULL DEFAULT '0',
    CHANGE `rpg_geologue` `rpg_geologue` TINYINT(2) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `rpg_amiral` `rpg_amiral` TINYINT(2) NOT NULL DEFAULT '0',
    CHANGE `rpg_ingenieur` `rpg_ingenieur` TINYINT(2) NOT NULL DEFAULT '0',
    CHANGE `rpg_technocrate` `rpg_technocrate` TINYINT(2) NOT NULL DEFAULT '0',
    CHANGE `rpg_espion` `rpg_espion` TINYINT(2) NOT NULL DEFAULT '0',
    CHANGE `rpg_constructeur` `rpg_constructeur` TINYINT(2) NOT NULL DEFAULT '0',
    CHANGE `rpg_scientifique` `rpg_scientifique` TINYINT(2) NOT NULL DEFAULT '0',
    CHANGE `rpg_commandant` `rpg_commandant` TINYINT(2) NOT NULL DEFAULT '0',
    CHANGE `rpg_stockeur` `rpg_stockeur` TINYINT(2) NOT NULL DEFAULT '0',
    CHANGE `rpg_defenseur` `rpg_defenseur` TINYINT(2) NOT NULL DEFAULT '0',
    CHANGE `rpg_destructeur` `rpg_destructeur` TINYINT(2) NOT NULL DEFAULT '0',
    CHANGE `rpg_general` `rpg_general` TINYINT(2) NOT NULL DEFAULT '0',
    CHANGE `rpg_bunker` `rpg_bunker` TINYINT(2) NOT NULL DEFAULT '0',
    CHANGE `rpg_raideur` `rpg_raideur` TINYINT(2) NOT NULL DEFAULT '0',
    CHANGE `rpg_empereur` `rpg_empereur` TINYINT(22) NOT NULL DEFAULT '0',
    CHANGE `bana` `bana` ENUM('0', '1') NULL DEFAULT '0',
    CHANGE `banaday` `banaday` INT(11) NOT NULL DEFAULT '0',
    CHANGE `hof` `hof` ENUM('0', '1') NOT NULL DEFAULT '1';
ALTER TABLE `prefix_users`
ADD `lang` VARCHAR(10) NOT NULL DEFAULT 'deutsch'
AFTER `email_2`;
ALTER TABLE `prefix_users`
ADD INDEX (`ally_id`);
ALTER TABLE `prefix_users` DROP `current_luna`;
ALTER TABLE `prefix_users` CHANGE `fb_id` `fb_id` VARCHAR(15) NOT NULL DEFAULT '0';
