ALTER TABLE prefix_aks DROP `flotten`;
ALTER TABLE prefix_alliance
ADD `ally_universe` TINYINT(3) UNSIGNED NOT NULL,
    ADD INDEX (`ally_universe`);
ALTER TABLE prefix_banned
ADD `universe` TINYINT(3) UNSIGNED NOT NULL,
    ADD INDEX (`universe`);
ALTER TABLE prefix_chat
ADD `universe` TINYINT(3) UNSIGNED NOT NULL,
    ADD INDEX (`universe`);
ALTER TABLE prefix_fleets
ADD `fleet_start_id` INT(11) UNSIGNED NOT NULL,
    ADD INDEX (`fleet_start_id`);
ALTER TABLE prefix_fleets CHANGE `fleet_id` `fleet_id` BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE prefix_fleets
ADD `fleet_end_id` INT(11) UNSIGNED NOT NULL
AFTER `fleet_end_stay`,
    ADD INDEX (`fleet_end_id`);
ALTER TABLE prefix_fleets CHANGE `fleet_target_obj` `fleet_target_obj` TINYINT(2) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE prefix_fleets
ADD `fleet_universe` TINYINT(3) UNSIGNED NOT NULL
AFTER `fleet_array`,
    ADD INDEX (`fleet_universe`);
ALTER TABLE prefix_messages
ADD `message_universe` TINYINT(3) UNSIGNED NOT NULL,
    ADD INDEX (`message_universe`);
ALTER TABLE prefix_planets
ADD `universe` TINYINT(3) UNSIGNED NOT NULL
AFTER `id_level`,
    ADD INDEX (`universe`);
ALTER TABLE prefix_statpoints
ADD `universe` TINYINT(3) UNSIGNED NOT NULL
AFTER `stat_type`,
    ADD INDEX (`universe`);
ALTER TABLE prefix_topkb
ADD `universe` TINYINT(3) UNSIGNED NOT NULL,
    ADD INDEX (`universe`);
ALTER TABLE prefix_users DROP INDEX `username`,
    ADD INDEX `username` (`username`);
ALTER TABLE prefix_users
ADD `universe` TINYINT(3) UNSIGNED NOT NULL
AFTER `id_planet`,
    ADD INDEX (`universe`);
ALTER TABLE prefix_users_valid
ADD UNIQUE (`cle`);
ALTER TABLE prefix_users_valid
ADD `universe` TINYINT(3) UNSIGNED NOT NULL;
UPDATE prefix_alliance
SET `ally_universe` = '1';
UPDATE prefix_topkb
SET `universe` = '1';
UPDATE prefix_banned
SET `universe` = '1';
UPDATE prefix_chat
SET `universe` = '1';
UPDATE prefix_fleets
SET `fleet_universe` = '1';
UPDATE prefix_messages
SET `message_universe` = '1';
UPDATE prefix_statpoints
SET `universe` = '1';
UPDATE prefix_planets
SET `universe` = '1';
UPDATE prefix_topkb
SET `universe` = '1';
UPDATE prefix_users
SET `universe` = '1';
