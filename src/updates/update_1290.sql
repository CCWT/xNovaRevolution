ALTER TABLE prefix_users CHANGE `user_lastip` `user_lastip` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
    CHANGE `ip_at_reg` `ip_at_reg` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';
ALTER TABLE prefix_session CHANGE `user_ip` `user_ip` VARCHAR(40) NOT NULL;
