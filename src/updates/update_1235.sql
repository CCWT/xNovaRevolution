ALTER TABLE prefix_config CHANGE `uni` `uni` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE prefix_users CHANGE `username` `username` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
    CHANGE `password` `password` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
