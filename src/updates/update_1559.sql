ALTER TABLE prefix_users
ADD `b_tech_queue` VARCHAR(500) NOT NULL DEFAULT ''
AFTER `b_tech_id`;
