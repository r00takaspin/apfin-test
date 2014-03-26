DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(11) DEFAULT NULL,
  `required_third_name` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы currency_rates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `currency_rates`;

CREATE TABLE `currency_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency` varchar(20) NOT NULL,
  `rate` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы friendship
# ------------------------------------------------------------

DROP TABLE IF EXISTS `friendship`;

CREATE TABLE `friendship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `friendship_unique_from_to_pair` (`from_id`,`to_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы tbl_migration
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tbl_migration`;

CREATE TABLE `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `third_name` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
