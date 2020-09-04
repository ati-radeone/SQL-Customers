DROP TABLE `history`;
DROP TABLE `customers`;

CREATE TABLE `customers` (
  `Personid` int NOT NULL AUTO_INCREMENT,
  `titel` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Personid`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `history` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Personid` int NOT NULL,
  `ChangedFrom` varchar(1700) DEFAULT NULL,
  `ChangedTo` varchar(1700) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Personid` (`Personid`),
  CONSTRAINT `history_ibfk_1` FOREIGN KEY (`Personid`) REFERENCES `customers` (`Personid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
