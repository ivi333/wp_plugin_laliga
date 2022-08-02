CREATE TABLE IF NOT EXISTS `laliga_jornadas` (
  `jor_id` INT unsigned NOT NULL AUTO_INCREMENT,
  `jor_title` VARCHAR(255) NOT NULL,
  `jor_resultados` json,
  PRIMARY KEY (`jor_id`)
) ENGINE=MyISAM /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;

