ALTER TABLE prefix_aks CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE prefix_alliance CHANGE `ally_request_notallow` `ally_request_notallow` ENUM('0', '1') NOT NULL DEFAULT '0',
    CHANGE `ally_members` `ally_members` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `ally_stats` `ally_stats` ENUM('0', '1') NOT NULL DEFAULT '1',
    CHANGE `ally_diplo` `ally_diplo` ENUM('0', '1') NOT NULL DEFAULT '1';
ALTER TABLE prefix_banned CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE prefix_buddy CHANGE `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    CHANGE `active` `active` ENUM('0', '1') NOT NULL DEFAULT '0';
