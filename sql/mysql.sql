CREATE TABLE `{message}` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `subject` varchar(255) NOT NULL default '',
    `department` tinyint(3) unsigned NOT NULL default '0',
    `email` varchar(64) NOT NULL default '',
    `name` varchar(64) NOT NULL default '',
    `organization` varchar(64) NOT NULL default '',
    `homepage` varchar(64) NOT NULL default '',
    `location` varchar(64) NOT NULL default '',
    `phone` varchar(50) NOT NULL default '',
    `ip` char(15) NOT NULL default '',
    `address` tinytext,
    `message` tinytext,
    `mid` int(10) unsigned NOT NULL default '0',
    `answered` tinyint(1) unsigned NOT NULL default '0',
    `uid` int(10) unsigned NOT NULL default '0',
    `time_create` int(10) unsigned NOT NULL default '0',
    `platform` enum('web','mobile') NOT NULL default 'web',
    PRIMARY KEY (`id`),
    KEY `subject` (`subject`),
    KEY `department` (`department`),
    KEY `mid` (`mid`),
    KEY `mid_department` (`mid`, `department`),
    KEY `id_create` (`id`, `time_create`)
);

CREATE TABLE `{department}` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL default '',
    `slug` varchar(255) NOT NULL default '',
    `email` varchar(64) NOT NULL default '',
    `status` tinyint(1) unsigned NOT NULL default '1',
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`),
    KEY `status` (`status`)
);