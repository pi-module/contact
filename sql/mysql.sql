CREATE TABLE `{message}` (
  `id`           INT(10) UNSIGNED       NOT NULL AUTO_INCREMENT,
  `subject`      VARCHAR(255)           NOT NULL DEFAULT '',
  `department`   TINYINT(3) UNSIGNED    NOT NULL DEFAULT '0',
  `email`        VARCHAR(64)            NOT NULL DEFAULT '',
  `name`         VARCHAR(64)            NOT NULL DEFAULT '',
  `organization` VARCHAR(64)            NOT NULL DEFAULT '',
  `homepage`     VARCHAR(64)            NOT NULL DEFAULT '',
  `location`     VARCHAR(64)            NOT NULL DEFAULT '',
  `phone`        VARCHAR(50)            NOT NULL DEFAULT '',
  `ip`           CHAR(15)               NOT NULL DEFAULT '',
  `address`      TINYTEXT,
  `message`      TEXT,
  `mid`          INT(10) UNSIGNED       NOT NULL DEFAULT '0',
  `answered`     TINYINT(1) UNSIGNED    NOT NULL DEFAULT '0',
  `uid`          INT(10) UNSIGNED       NOT NULL DEFAULT '0',
  `time_create`  INT(10) UNSIGNED       NOT NULL DEFAULT '0',
  `platform`     ENUM ('web', 'mobile') NOT NULL DEFAULT 'web',
  PRIMARY KEY (`id`),
  KEY `subject` (`subject`),
  KEY `department` (`department`),
  KEY `mid` (`mid`),
  KEY `mid_department` (`mid`, `department`),
  KEY `id_create` (`id`, `time_create`)
);

CREATE TABLE `{department}` (
  `id`     INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `title`  VARCHAR(255)        NOT NULL DEFAULT '',
  `slug`   VARCHAR(255)        NOT NULL DEFAULT '',
  `email`  VARCHAR(64)         NOT NULL DEFAULT '',
  `status` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `status` (`status`)
);