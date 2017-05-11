DROP TABLE IF EXISTS `fantasy_weights`;
DROP TABLE IF EXISTS `classic_weights`;
DROP TABLE IF EXISTS `power_weights`;

CREATE TABLE `fantasy_weights` (
  `fantasy_weights_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weight` decimal(7,3) DEFAULT '0.000',
  `weight_by_two` decimal(7,3) DEFAULT '0.000',
  `weight_by_three` decimal(7,3) DEFAULT '0.000',
  PRIMARY KEY (`fantasy_weights_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `classic_weights` (
  `classic_weights_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weight` decimal(7,3) DEFAULT '0.000',
  `weight_by_two` decimal(7,3) DEFAULT '0.000',
  `weight_by_three` decimal(7,3) DEFAULT '0.000',
  PRIMARY KEY (`classic_weights_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `powerball_weights` (
  `powerball_weights_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weight` decimal(7,3) DEFAULT '0.000',
  `weight_by_two` decimal(7,3) DEFAULT '0.000',
  `weight_by_three` decimal(7,3) DEFAULT '0.000',
  PRIMARY KEY (`powerball_weights_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;