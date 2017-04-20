CREATE TABLE `powerball` (
  `powerball_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `draw_num1` smallint(6) DEFAULT NULL,
  `draw_num2` smallint(6) DEFAULT NULL,
  `draw_num3` smallint(6) DEFAULT NULL,
  `draw_num4` smallint(6) DEFAULT NULL,
  `draw_num5` smallint(6) DEFAULT NULL,
  `draw_num6` smallint(11) DEFAULT NULL,
  `multiplier` smallint(6) DEFAULT NULL,
  `draw_date` datetime DEFAULT NULL,
  `insert_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`powerball_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `powerball_used_numbers` (
  `powerball_used_numbers_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `powerball_id` int(11) DEFAULT NULL,
  `number_used` smallint(6) DEFAULT NULL,
  `is_powerball` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`powerball_used_numbers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `sql_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_location` text NOT NULL,
  `date_ran` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8;