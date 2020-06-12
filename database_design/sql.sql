-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema homestead
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema homestead
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `homestead` ;
USE `homestead` ;

-- -----------------------------------------------------
-- Table `homestead`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  `email` VARCHAR(80) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_persian_ci;


-- -----------------------------------------------------
-- Table `homestead`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_orders_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_orders_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `homestead`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_persian_ci;


-- -----------------------------------------------------
-- Table `homestead`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`products` (
  `id` INT NOT NULL,
  `name` VARCHAR(90) NOT NULL,
  `description` TEXT(1000) NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_products_users_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_products_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `homestead`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_persian_ci;


-- -----------------------------------------------------
-- Table `homestead`.`colors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`colors` (
  `id` TINYINT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `hex` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_persian_ci;


-- -----------------------------------------------------
-- Table `homestead`.`product_types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`product_types` (
  `product_id` INT NOT NULL,
  `color_id` TINYINT NOT NULL,
  `price` INT NOT NULL,
  `date` DATETIME NOT NULL,
  INDEX `fk_product_types_products1_idx` (`product_id` ASC) VISIBLE,
  INDEX `fk_product_types_colors1_idx` (`color_id` ASC) VISIBLE,
  PRIMARY KEY (`product_id`, `color_id`),
  CONSTRAINT `fk_product_types_products`
    FOREIGN KEY (`product_id`)
    REFERENCES `homestead`.`products` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_types_colors1`
    FOREIGN KEY (`color_id`)
    REFERENCES `homestead`.`colors` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_persian_ci;


-- -----------------------------------------------------
-- Table `homestead`.`order_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homestead`.`order_items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `count` INT NULL DEFAULT 1,
  `order_id` INT NOT NULL,
  `product_type_product_id` INT NOT NULL,
  `product_type_color_id` TINYINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_order_items_orders1_idx` (`order_id` ASC) VISIBLE,
  INDEX `fk_order_items_product_types1_idx` (`product_type_product_id` ASC, `product_type_color_id` ASC) VISIBLE,
  CONSTRAINT `fk_order_items_orders`
    FOREIGN KEY (`order_id`)
    REFERENCES `homestead`.`orders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_items_product_types`
    FOREIGN KEY (`product_type_product_id` , `product_type_color_id`)
    REFERENCES `homestead`.`product_types` (`product_id` , `color_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_persian_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
