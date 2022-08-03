CREATE TABLE IF NOT EXISTS `laliga_jornadas` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(15) NOT NULL,
  `resultados` json,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;

