DROP TABLE IF EXISTS `fantasy_modifiers`;
DROP TABLE IF EXISTS `classic_modifiers`;
DROP TABLE IF EXISTS `powerball_modifiers`;
DROP TABLE IF EXISTS `mega_modifiers`;

CREATE TABLE `fantasy_modifiers` (
  `fantasy_modifiers_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `min_redraw` decimal(7,3) DEFAULT '0.000',
  `max_redraw` decimal(7,3) DEFAULT '0.000',
  `current_redraw` decimal(7,3) DEFAULT '0.000',
  PRIMARY KEY (`fantasy_modifiers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `classic_modifiers` (
  `classic_modifiers_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `min_redraw` decimal(7,3) DEFAULT '0.000',
  `max_redraw` decimal(7,3) DEFAULT '0.000',
  `current_redraw` decimal(7,3) DEFAULT '0.000',
  PRIMARY KEY (`classic_modifiers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `powerball_modifiers` (
  `powerball_modifiers_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `min_redraw` decimal(7,3) DEFAULT '0.000',
  `max_redraw` decimal(7,3) DEFAULT '0.000',
  `current_redraw` decimal(7,3) DEFAULT '0.000',
  PRIMARY KEY (`powerball_modifiers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `mega_modifiers` (
  `mega_modifiers_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `min_redraw` decimal(7,3) DEFAULT '0.000',
  `max_redraw` decimal(7,3) DEFAULT '0.000',
  `current_redraw` decimal(7,3) DEFAULT '0.000',
  PRIMARY KEY (`mega_modifiers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;