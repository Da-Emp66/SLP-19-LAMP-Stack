CREATE TABLE IF NOT EXISTS `leinecke_COP4331`.`Users` (
    `ID` INT NOT NULL AUTO_INCREMENT ,
    `DateCreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `DateLastLoggedIn` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `FirstName` VARCHAR(50) NOT NULL DEFAULT '' ,
    `LastName` VARCHAR(50) NOT NULL DEFAULT '' ,
    `Username` VARCHAR(50) NOT NULL DEFAULT '' ,
    `Password` VARCHAR(50) NOT NULL DEFAULT '' ,
    PRIMARY KEY (`ID`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `leinecke_COP4331`.`Contacts` (
    `SourceID` INT NOT NULL DEFAULT '' ,
    `Name` VARCHAR(50) NOT NULL DEFAULT '' ,
    `UserID` INT NOT NULL DEFAULT '0' ,
    PRIMARY KEY (`ID`)
) ENGINE = InnoDB;

INSERT INTO Users (FirstName,LastName,Username,Password) VALUES ('Rick','Leinecker','RickL','COP4331');
INSERT INTO Users (FirstName,LastName,Username,Password) VALUES ('Sam','Hill','SamH','Test');
INSERT INTO Users (FirstName,LastName,Username,Password) VALUES ('Rick','Leinecker','RickL','5832a71366768098cceb7095efb774f2');
INSERT INTO Users (FirstName,LastName,Username,Password) VALUES ('Sam','Hill','SamH','0cbc6611f5540bd0809a388dc95a615b');

INSERT INTO Colors (Name,UserID) VALUES ('Blue',1);
INSERT INTO Colors (Name,UserID) VALUES ('White',1);
INSERT INTO Colors (Name,UserID) VALUES ('Black',1);
INSERT INTO Colors (Name,UserID) VALUES ('gray',1);
INSERT INTO Colors (Name,UserID) VALUES ('Magenta',1);
INSERT INTO Colors (Name,UserID) VALUES ('Yellow',1);
INSERT INTO Colors (Name,UserID) VALUES ('Cyan',1);
INSERT INTO Colors (Name,UserID) VALUES ('Salmon',1);
INSERT INTO Colors (Name,UserID) VALUES ('Chartreuse',1);
INSERT INTO Colors (Name,UserID) VALUES ('Lime',1);
INSERT INTO Colors (Name,UserID) VALUES ('Light Blue',1);
INSERT INTO Colors (Name,UserID) VALUES ('Light Gray',1);
INSERT INTO Colors (Name,UserID) VALUES ('Light Red',1);
INSERT INTO Colors (Name,UserID) VALUES ('Light Green',1);
INSERT INTO Colors (Name,UserID) VALUES ('Chiffon',1);
INSERT INTO Colors (Name,UserID) VALUES ('Fuscia',1);
INSERT INTO Colors (Name,UserID) VALUES ('Brown',1);
INSERT INTO Colors (Name,UserID) VALUES ('Beige',1);

INSERT INTO Colors (Name,UserID) VALUES ('Blue',3);
INSERT INTO Colors (Name,UserID) VALUES ('White',3);
INSERT INTO Colors (Name,UserID) VALUES ('Black',3);
INSERT INTO Colors (Name,UserID) VALUES ('gray',3);
INSERT INTO Colors (Name,UserID) VALUES ('Magenta',3);
INSERT INTO Colors (Name,UserID) VALUES ('Yellow',3);
INSERT INTO Colors (Name,UserID) VALUES ('Cyan',3);
INSERT INTO Colors (Name,UserID) VALUES ('Salmon',3);
INSERT INTO Colors (Name,UserID) VALUES ('Chartreuse',3);
INSERT INTO Colors (Name,UserID) VALUES ('Lime',3);
INSERT INTO Colors (Name,UserID) VALUES ('Light Blue',3);
INSERT INTO Colors (Name,UserID) VALUES ('Light Gray',3);
INSERT INTO Colors (Name,UserID) VALUES ('Light Red',3);
INSERT INTO Colors (Name,UserID) VALUES ('Light Green',3);
INSERT INTO Colors (Name,UserID) VALUES ('Chiffon',3);
INSERT INTO Colors (Name,UserID) VALUES ('Fuscia',3);
INSERT INTO Colors (Name,UserID) VALUES ('Brown',3);
INSERT INTO Colors (Name,UserID) VALUES ('Beige',3);