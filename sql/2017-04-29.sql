CREATE TABLE `fantasy` (
  `fantasy_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `draw_num1` smallint(6) DEFAULT NULL,
  `draw_num2` smallint(6) DEFAULT NULL,
  `draw_num3` smallint(6) DEFAULT NULL,
  `draw_num4` smallint(6) DEFAULT NULL,
  `draw_num5` smallint(6) DEFAULT NULL,
  `draw_date` datetime DEFAULT NULL,
  `insert_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`fantasy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `classic` (
  `classic_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `draw_num1` smallint(6) DEFAULT NULL,
  `draw_num2` smallint(6) DEFAULT NULL,
  `draw_num3` smallint(6) DEFAULT NULL,
  `draw_num4` smallint(6) DEFAULT NULL,
  `draw_num5` smallint(6) DEFAULT NULL,
  `draw_num6` smallint(11) DEFAULT NULL,
  `draw_date` datetime DEFAULT NULL,
  `insert_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`classic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
