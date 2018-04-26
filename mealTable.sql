


CREATE TABLE `meal` (
 `mealId` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `mealType` varchar(100) NOT NULL,
 `foodGroup` varchar(100) NOT NULL,
 `macros` varchar(10) DEFAULT NULL,
 `calories` int(4) NOT NULL,
 `mealName` varchar(100) DEFAULT NULL,
 `date` DATE NOT NULL,

 PRIMARY KEY (`mealId`)
);
