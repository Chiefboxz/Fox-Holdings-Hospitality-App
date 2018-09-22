create database Project_database;

use Project_database;

CREATE TABLE IF NOT EXISTS `Project_database`.`Customer` (
  `cID` INT NOT NULL,
  `cName` VARCHAR(45) NULL,
  `cNumber` INT(10) NULL,
  `cEmail` VARCHAR(45) NULL,
  `cPassword` VARCHAR(45) NULL,
  PRIMARY KEY (`cID`));



CREATE TABLE IF NOT EXISTS `Project_database`.`Ingredients` (
  `ingreID` INT NOT NULL,
  `ingreName` VARCHAR(45) NULL,
  `ingreDescription` TEXT NULL,
  PRIMARY KEY (`ingreID`));


CREATE TABLE IF NOT EXISTS `Project_database`.`Menu` (
  `menuID` INT NOT NULL,
  `menuItem` VARCHAR(45) NULL,
  `menuPrice` DOUBLE NULL,
  `menuCatagory` VARCHAR(45) NULL,
  PRIMARY KEY (`menuID`));

CREATE TABLE IF NOT EXISTS `Project_database`.`IngredientsUsed` (
  `ingreID` INT NOT NULL,
  `menuID` INT NOT NULL,
  `Quantity` INT NULL,
  PRIMARY KEY (`ingreID`, `menuID`),
  CONSTRAINT `ingreID`
    FOREIGN KEY (`ingreID`)
    REFERENCES `Project_database`.`Ingredients` (`ingreID`),
  CONSTRAINT `menuID`
    FOREIGN KEY (`menuID`)
    REFERENCES `Project_database`.`Menu` (`menuID`));

CREATE TABLE IF NOT EXISTS `Project_database`.`Order` (
  `cID` INT NOT NULL,
  `menuID` INT NOT NULL,
  `orderDescription` TEXT NULL,
  `orderQuantity` INT NULL,
  `orderTime` DATETIME NULL,
  `orderCollection` VARCHAR(10) NULL,
  PRIMARY KEY (`cID`, `menuID`),
  CONSTRAINT `cID`
    FOREIGN KEY (`cID`)
    REFERENCES `Project_database`.`Customer` (`cID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `menuID`
    FOREIGN KEY (`menuID`)
    REFERENCES `Project_database`.`Menu` (`menuID`));
