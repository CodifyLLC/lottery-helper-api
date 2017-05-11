CREATE TABLE `mega` (
  `mega_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `draw_num1` smallint(6) DEFAULT NULL,
  `draw_num2` smallint(6) DEFAULT NULL,
  `draw_num3` smallint(6) DEFAULT NULL,
  `draw_num4` smallint(6) DEFAULT NULL,
  `draw_num5` smallint(6) DEFAULT NULL,
  `draw_num6` smallint(11) DEFAULT NULL,
  `multiplier` smallint(6) DEFAULT NULL,
  `draw_date` datetime DEFAULT NULL,
  `insert_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`mega_id`)
) ENGINE=InnoDB AUTO_INCREMENT=750 DEFAULT CHARSET=latin1;

CREATE TABLE `mega_weights` (
  `mega_weights_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weight` decimal(7,3) DEFAULT '0.000',
  `weight_by_two` decimal(7,3) DEFAULT '0.000',
  `weight_by_three` decimal(7,3) DEFAULT '0.000',
  PRIMARY KEY (`mega_weights_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;