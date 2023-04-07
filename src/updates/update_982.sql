ALTER TABLE prefix_fleets CHANGE `fleet_mission` `fleet_mission` ENUM(
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '15'
    ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '3',
    CHANGE `fleet_amount` `fleet_amount` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0';
