
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- folder
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `folder`;

CREATE TABLE `folder`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `parent_id` INTEGER NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- file
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `file`;

CREATE TABLE `file`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `folder_id` INTEGER NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
