
CREATE TABLE `workout` (

 `workoutType` varchar(100) NOT NULL,
 `workoutName` varchar(100) NOT NULL,
 `AreaFocus`  varchar(100) NOT NULL,
 `workoutIntes`  varchar(100) NOT NULL,
 `date`  DATE NOT NULL
);



CREATE TABLE `meal` (

 `mealType` varchar(100) NOT NULL,
 `Food Group` varchar(100) NOT NULL,
 `Macros` varchar(10) DEFAULT NULL,
 `Calories` int(4) NOT NULL,
 `Meal Name` varchar(100) NOT NULL,
 `Date` DATE NOT NULL
);
