ALTER TABLE prefix_users
ADD `setmail` INT(11) NOT NULL DEFAULT '0'
AFTER `uctime`;
