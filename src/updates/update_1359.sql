ALTER TABLE `prefix_fleets` CHANGE `fleet_resource_metal` `fleet_resource_metal` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `fleet_resource_crystal` `fleet_resource_crystal` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `fleet_resource_deuterium` `fleet_resource_deuterium` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `fleet_resource_darkmatter` `fleet_resource_darkmatter` BIGINT(20) UNSIGNED NOT NULL DEFAULT '0';
