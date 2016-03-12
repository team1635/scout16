SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `_scout16_` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `_scout16_` ;

-- -----------------------------------------------------
-- Table `event`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `_scout16_`.`event` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL ,
  `code` VARCHAR(10) NULL ,
  `week` TINYINT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

-- -----------------------------------------------------
-- Table `team`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `_scout16_`.`team` (
  `id` SMALLINT(6) NOT NULL ,
  `name` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL ,
  `nick` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL ,
  `school` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL ,
  `location` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL ,
  `link` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `id` (`id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `match_`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `_scout16_`.`match_` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `event_id` INT(11) NOT NULL ,
  `type_` varchar(10) NOT NULL,
  `number_` TINYINT NULL ,
  `red_team1_id` SMALLINT(6) NOT NULL ,
  `red_team2_id` SMALLINT(6) NOT NULL ,
  `red_team3_id` SMALLINT(6) NOT NULL ,
  `blue_team1_id` SMALLINT(6) NOT NULL ,
  `blue_team2_id` SMALLINT(6) NOT NULL ,
  `blue_team3_id` SMALLINT(6) NOT NULL ,
  
  `red_def2` VARCHAR(20) NULL ,
  `red_def3` VARCHAR(20) NULL ,
  `red_def4` VARCHAR(20) NULL ,
  `red_def5` VARCHAR(20) NULL ,
  `blue_def2` VARCHAR(20) NULL ,
  `blue_def3` VARCHAR(20) NULL ,
  `blue_def4` VARCHAR(20) NULL ,
  `blue_def5` VARCHAR(20) NULL ,
  
  PRIMARY KEY (`id`) ,
  INDEX `fk_match__event_idx` (`event_id` ASC) ,
  INDEX `fk_match__team1_idx` (`red_team1_id` ASC) ,
  INDEX `fk_match__team2_idx` (`red_team2_id` ASC) ,
  INDEX `fk_match__team3_idx` (`red_team3_id` ASC) ,
  INDEX `fk_match__team4_idx` (`blue_team1_id` ASC) ,
  INDEX `fk_match__team5_idx` (`blue_team2_id` ASC) ,
  INDEX `fk_match__team6_idx` (`blue_team3_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `flat_stat`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `_scout16_`.`flat_stat` (
  `id` INT(11) NOT NULL ,

  `had_portcullis` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_portcullis` TINYINT(4) NULL DEFAULT NULL ,
  `open_portcullis` TINYINT(4) NULL DEFAULT NULL ,

  `had_cheval` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_cheval` TINYINT(4) NULL DEFAULT NULL ,

  `had_moat` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_moat` TINYINT(4) NULL DEFAULT NULL ,

  `had_ramparts` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_ramparts` TINYINT(4) NULL DEFAULT NULL ,

  `had_drawbridge` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_drawbridge` TINYINT(4) NULL DEFAULT NULL ,
  `open_drawbridge` TINYINT(4) NULL DEFAULT NULL ,

  `had_sally_port` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_sally_port` TINYINT(4) NULL DEFAULT NULL ,
  `open_sally_port` TINYINT(4) NULL DEFAULT NULL ,

  `had_rock_wall` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_rock_wall` TINYINT(4) NULL DEFAULT NULL ,
  
  `had_rough_terrain` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_rough_terrain` TINYINT(4) NULL DEFAULT NULL ,
  
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `flat_id_UNIQUE` (`id` ASC) ,
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `stat`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `_scout16_`.`stat` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `team_id` SMALLINT(6) NOT NULL ,
  `match__id` INT(11) NOT NULL ,

  `auto_position` TINYINT(4) NULL ,
  `auto_reach_defense` TINYINT(1) NULL ,
  `auto_cross_defense` TINYINT(1) NULL ,
  `auto_low_goal` TINYINT(4) NULL ,
  `auto_high_goal` TINYINT(4) NULL ,

  `cross_low_bar` TINYINT(4) NULL DEFAULT NULL,
  `cross_defense2` TINYINT(4) NULL DEFAULT NULL ,
  `cross_defense3` TINYINT(4) NULL DEFAULT NULL ,
  `cross_defense4` TINYINT(4) NULL DEFAULT NULL ,
  `cross_defense5` TINYINT(4) NULL DEFAULT NULL ,
  `open_defense2` TINYINT(4) NULL DEFAULT NULL ,
  `open_defense3` TINYINT(4) NULL DEFAULT NULL ,
  `open_defense4` TINYINT(4) NULL DEFAULT NULL ,
  `open_defense5` TINYINT(4) NULL DEFAULT NULL ,

  `pick_boulder` TINYINT(4) NULL DEFAULT NULL ,
  `pass_boulder` TINYINT(4) NULL DEFAULT NULL ,
  
  `score_low` TINYINT(4) NULL DEFAULT NULL ,
  `score_high` TINYINT(4) NULL DEFAULT NULL ,

  `get_on_tower` TINYINT(4) NULL DEFAULT NULL ,
  `climb_tower` TINYINT(4) NULL DEFAULT NULL ,

  `defense` TINYINT(1) NULL,
  `fouls` TINYINT(4) NULL,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_stat_team1_idx` (`team_id` ASC) ,
  INDEX `fk_stat_match_1_idx` (`match__id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `flat_stat`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `_scout16_`.`flat_stat` (
  `id` INT(11) NOT NULL ,

  `had_portcullis` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_portcullis` TINYINT(4) NULL DEFAULT NULL ,
  `open_portcullis` TINYINT(4) NULL DEFAULT NULL ,

  `had_cheval` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_cheval` TINYINT(4) NULL DEFAULT NULL ,

  `had_moat` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_moat` TINYINT(4) NULL DEFAULT NULL ,

  `had_ramparts` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_ramparts` TINYINT(4) NULL DEFAULT NULL ,

  `had_drawbridge` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_drawbridge` TINYINT(4) NULL DEFAULT NULL ,
  `open_drawbridge` TINYINT(4) NULL DEFAULT NULL ,

  `had_sally_port` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_sally_port` TINYINT(4) NULL DEFAULT NULL ,
  `open_sally_port` TINYINT(4) NULL DEFAULT NULL ,

  `had_rock_wall` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_rock_wall` TINYINT(4) NULL DEFAULT NULL ,
  
  `had_rough_terrain` TINYINT(4) NULL DEFAULT NULL ,
  `crossed_rough_terrain` TINYINT(4) NULL DEFAULT NULL ,
  
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `flat_id_UNIQUE` (`id` ASC) ,
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `current_`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `_scout16_`.`current_` (
  `event_code` VARCHAR(10) NULL ,
  `match_type` VARCHAR(10) NULL ,
  `match_number` TINYINT NULL )
ENGINE = MyISAM;

/*
create this in cpanel, because the dba doesn't have create user

CREATE USER `_app_` IDENTIFIED BY '_password_';

grant SELECT, UPDATE and INSERT to the app account in cpanel because
the commands below do not work.

grant SELECT on TABLE `_scout16_`.`event` to `_app_`;
grant UPDATE on TABLE `_scout16_`.`event` to `_app_`;
grant INSERT on TABLE `_scout16_`.`event` to `_app_`;
grant INSERT on TABLE `_scout16_`.`match_` to `_app_`;
grant SELECT on TABLE `_scout16_`.`match_` to `_app_`;
grant UPDATE on TABLE `_scout16_`.`match_` to `_app_`;
grant INSERT on TABLE `_scout16_`.`stat` to `_app_`;
grant SELECT on TABLE `_scout16_`.`stat` to `_app_`;
grant UPDATE on TABLE `_scout16_`.`stat` to `_app_`;
grant INSERT on TABLE `_scout16_`.`team` to `_app_`;
grant SELECT on TABLE `_scout16_`.`team` to `_app_`;
grant UPDATE on TABLE `_scout16_`.`team` to `_app_`;
 */

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
