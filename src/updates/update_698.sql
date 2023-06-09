ALTER TABLE prefix_planets CHANGE `galaxy` `galaxy` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `system` `system` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `planet` `planet` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE prefix_users CHANGE `galaxy` `galaxy` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `system` `system` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
    CHANGE `planet` `planet` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE prefix_messages
ADD `message_unread` ENUM('0', '1') NOT NULL DEFAULT '1';
ALTER TABLE prefix_messages
ADD INDEX (`message_unread`);
