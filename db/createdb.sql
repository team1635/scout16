SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `bradubv_scout15` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `bradubv_scout15` ;

-- -----------------------------------------------------
-- Table `bradubv_scout15`.`event`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bradubv_scout15`.`event`;
CREATE  TABLE IF NOT EXISTS `bradubv_scout15`.`event` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `code` VARCHAR(10) NOT NULL ,
  `eventcol` VARCHAR(45) NULL ,
  `eventcol1` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

-- -----------------------------------------------------
-- Table `bradubv_scout15`.`current_`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bradubv_scout15`.`current_`;
CREATE  TABLE IF NOT EXISTS `bradubv_scout15`.`current_` (
  `event_code` VARCHAR(10) NOT NULL ,
  `match_type` VARCHAR(10) NOT NULL ,
  `match_number` TINYINT NOT NULL )
ENGINE = MyISAM;

-- -----------------------------------------------------
-- Table `bradubv_scout15`.`team`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bradubv_scout15`.`team`;
CREATE  TABLE IF NOT EXISTS `bradubv_scout15`.`team` (
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
-- Table `bradubv_scout15`.`match_`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bradubv_scout15`.`match_`;
CREATE  TABLE IF NOT EXISTS `bradubv_scout15`.`match_` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `event_id` INT(11) NOT NULL ,
  `type_` VARCHAR(10) NOT NULL,
  `number_` TINYINT NOT NULL,
  `red_team1_id` SMALLINT(6) NOT NULL ,
  `red_team2_id` SMALLINT(6) NOT NULL ,
  `red_team3_id` SMALLINT(6) NOT NULL ,
  `blue_team1_id` SMALLINT(6) NOT NULL ,
  `blue_team2_id` SMALLINT(6) NOT NULL ,
  `blue_team3_id` SMALLINT(6) NOT NULL ,
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
-- Table `bradubv_scout15`.`stat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bradubv_scout15`.`stat`;
CREATE  TABLE IF NOT EXISTS `bradubv_scout15`.`stat` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `team_id` SMALLINT(6) NOT NULL ,
  `match__id` INT(11) NOT NULL ,

  `auto_robot` TINYINT(1) NULL ,
  `auto_tote` TINYINT(4) NULL ,
  `auto_can` TINYINT(4) NULL ,
  `auto_stack` TINYINT(1) NULL ,
  `auto_position` TINYINT(4) NULL ,

  `scored_gray` TINYINT(4) NULL ,
  `scored_can_level` TINYINT(4) NULL DEFAULT NULL ,
  `score_stack` TINYINT(4) NULL DEFAULT NULL ,
  `carry_stack` TINYINT(4) NULL DEFAULT NULL ,
  `handle_litter` TINYINT(4) NULL DEFAULT NULL ,
  `fallen_can` TINYINT(4) NULL DEFAULT NULL ,
  `noodle_in_can` TINYINT(4) NULL DEFAULT NULL ,
  `clear_recycle` TINYINT(4) NULL,
  `grab_step_can` TINYINT(4) NULL,

  `coop` TINYINT(4) NULL,
  `coop_stack` TINYINT(4) NULL,

  `fouls` TINYINT(4) NULL,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_stat_team1_idx` (`team_id` ASC) ,
  INDEX `fk_stat_match_1_idx` (`match__id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

/*
CREATE USER `bradubv_app` IDENTIFIED BY 'password';

grant SELECT on TABLE `bradubv_scout15`.`event` to bradubv_app;
grant UPDATE on TABLE `bradubv_scout15`.`event` to bradubv_app;
grant INSERT on TABLE `bradubv_scout15`.`event` to bradubv_app;
grant INSERT on TABLE `bradubv_scout15`.`match_` to bradubv_app;
grant SELECT on TABLE `bradubv_scout15`.`match_` to bradubv_app;
grant UPDATE on TABLE `bradubv_scout15`.`match_` to bradubv_app;
grant INSERT on TABLE `bradubv_scout15`.`stat` to bradubv_app;
grant SELECT on TABLE `bradubv_scout15`.`stat` to bradubv_app;
grant UPDATE on TABLE `bradubv_scout15`.`stat` to bradubv_app;
grant INSERT on TABLE `bradubv_scout15`.`team` to bradubv_app;
grant SELECT on TABLE `bradubv_scout15`.`team` to bradubv_app;
grant UPDATE on TABLE `bradubv_scout15`.`team` to bradubv_app;
 */

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
