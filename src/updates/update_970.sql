ALTER TABLE prefix_users CHANGE `user_agent` `user_agent` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
    CHANGE `current_page` `current_page` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
ALTER TABLE prefix_planets CHANGE `b_building_id` `b_building_id` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
    CHANGE `b_hangar_id` `b_hangar_id` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
