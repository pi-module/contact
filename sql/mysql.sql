CREATE TABLE `{message}` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `department` tinyint(3) unsigned NOT NULL,
  `email` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `organization` varchar(64) NOT NULL,
  `homepage` varchar(64) NOT NULL,
  `location` varchar(64) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `ip` char(15) NOT NULL,
  `address` tinytext,
  `message` tinytext,
  `mid` int(10) unsigned NOT NULL,
  `answered` tinyint(1) unsigned NOT NULL,
  `author` int(10) unsigned NOT NULL,
  `create` int(10) unsigned NOT NULL,
  `platform` enum('web','android','ios') NOT NULL default 'web',
  PRIMARY KEY (`id`),
  KEY `subject` (`subject`),
  KEY `department` (`department`),
  KEY `mid` (`mid`),
  KEY `mid_department` (`mid`, `department`),
  KEY `id_create` (`id`, `create`)
);

CREATE TABLE `{department}` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `email` varchar(64) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `status` (`status`)
);