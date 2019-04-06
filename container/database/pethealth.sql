-- MySQL Script generated by MySQL Workbench
-- Sat Apr  6 14:28:07 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema pethealth
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema pethealth
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `pethealth` DEFAULT CHARACTER SET utf8 ;
USE `pethealth` ;

-- -----------------------------------------------------
-- Table `pethealth`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pethealth`.`user` (
  `uuid` VARCHAR(36) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `firstname` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `passwd` VARCHAR(255) NOT NULL,
  `rec_st` VARCHAR(45) NOT NULL DEFAULT 'C',
  `date_time` DATETIME NOT NULL DEFAULT NOW() ON UPDATE NOW(),
  PRIMARY KEY (`uuid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pethealth`.`pet_race`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pethealth`.`pet_race` (
  `uuid` VARCHAR(36) NOT NULL,
  `label` VARCHAR(45) NOT NULL,
  `rec_st` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`uuid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pethealth`.`recall_time`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pethealth`.`recall_time` (
  `uuid` VARCHAR(36) NOT NULL,
  `day` INT NULL,
  `month` INT NULL,
  `year` INT NULL,
  PRIMARY KEY (`uuid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pethealth`.`vaccine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pethealth`.`vaccine` (
  `uuid` VARCHAR(36) NOT NULL,
  `label` VARCHAR(45) NULL,
  `recall_time_id` VARCHAR(36) NULL,
  `rec_st` VARCHAR(45) NULL,
  PRIMARY KEY (`uuid`),
  INDEX `index2` (`recall_time_id` ASC),
  CONSTRAINT `fk_vaccine_1`
    FOREIGN KEY (`recall_time_id`)
    REFERENCES `pethealth`.`recall_time` (`uuid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pethealth`.`pet_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pethealth`.`pet_type` (
  `uuid` VARCHAR(36) NOT NULL,
  `label` VARCHAR(45) NULL,
  `vaccin_id` VARCHAR(36) NULL,
  `rec_st` VARCHAR(45) NOT NULL DEFAULT 'C',
  PRIMARY KEY (`uuid`),
  INDEX `index2` (`vaccin_id` ASC),
  CONSTRAINT `fk_pet_type_1`
    FOREIGN KEY (`vaccin_id`)
    REFERENCES `pethealth`.`vaccine` (`uuid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pethealth`.`pet`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pethealth`.`pet` (
  `uuid` VARCHAR(36) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `birthdate` DATE NOT NULL,
  `user_id` VARCHAR(36) NOT NULL,
  `race` VARCHAR(45) NULL,
  `sex` VARCHAR(1) NULL,
  `pet_race_id` VARCHAR(36) BINARY NULL,
  `pet_type_id` VARCHAR(36) NULL,
  `matricule` VARCHAR(45) NULL,
  PRIMARY KEY (`uuid`),
  INDEX `index2` (`user_id` ASC),
  INDEX `index3` (`pet_race_id` ASC),
  INDEX `index4` (`pet_type_id` ASC),
  CONSTRAINT `fk_pet_1`
    FOREIGN KEY (`user_id`)
    REFERENCES `pethealth`.`user` (`uuid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pet_3`
    FOREIGN KEY (`pet_race_id`)
    REFERENCES `pethealth`.`pet_race` (`uuid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pet_2`
    FOREIGN KEY (`pet_type_id`)
    REFERENCES `pethealth`.`pet_type` (`uuid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pethealth`.`health_book_main`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pethealth`.`health_book_main` (
  `uuid` VARCHAR(36) NOT NULL,
  `pet_id` VARCHAR(36) NOT NULL,
  `rec_st` VARCHAR(45) NOT NULL DEFAULT 'C',
  `date_time` DATE NULL,
  PRIMARY KEY (`uuid`),
  INDEX `index2` (`pet_id` ASC),
  CONSTRAINT `fk_health_book_main_1`
    FOREIGN KEY (`pet_id`)
    REFERENCES `pethealth`.`pet` (`uuid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pethealth`.`pest_control`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pethealth`.`pest_control` (
  `uuid` VARCHAR(36) NOT NULL,
  `label` VARCHAR(45) NULL,
  `recall_time_id` VARCHAR(36) NULL,
  `rec_st` VARCHAR(45) NULL,
  PRIMARY KEY (`uuid`),
  INDEX `index2` (`recall_time_id` ASC),
  CONSTRAINT `fk_pest_control_1`
    FOREIGN KEY (`recall_time_id`)
    REFERENCES `pethealth`.`recall_time` (`uuid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pethealth`.`health_book_detail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pethealth`.`health_book_detail` (
  `uuid` VARCHAR(36) NOT NULL,
  `health_book_main_id` VARCHAR(36) NOT NULL,
  `vaccin_id` VARCHAR(36) NULL,
  `pest_control_id` VARCHAR(36) NULL,
  `rec_st` VARCHAR(45) NULL,
  PRIMARY KEY (`uuid`),
  INDEX `index2` (`vaccin_id` ASC),
  INDEX `index3` (`pest_control_id` ASC),
  INDEX `index4` (`health_book_main_id` ASC),
  CONSTRAINT `fk_health_book_detail_2`
    FOREIGN KEY (`vaccin_id`)
    REFERENCES `pethealth`.`vaccine` (`uuid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_health_book_detail_3`
    FOREIGN KEY (`pest_control_id`)
    REFERENCES `pethealth`.`pest_control` (`uuid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_health_book_detail_1`
    FOREIGN KEY (`health_book_main_id`)
    REFERENCES `pethealth`.`health_book_main` (`uuid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
