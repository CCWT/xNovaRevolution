ALTER TABLE prefix_planets CHANGE `small_protection_shield` `small_protection_shield` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `planet_protector` `planet_protector` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `big_protection_shield` `big_protection_shield` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0';
