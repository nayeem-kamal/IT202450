insert into
  users(username, email, password)
values("system user", "system@user.com", "pass123");
INSERT INTO
  `nhk6`.`Accounts` (
    `account_number`,
    `user_id`,
    `balance`,
    `account_type`
  )
VALUES
  ("000000000000", 11, 0, "world");

  CREATE TABLE `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `accountsrc` int NOT NULL,
  `accountdst` int NOT NULL,
  `balanceChange` float NOT NULL,
  `transactionType` varchar(255) DEFAULT NULL,
  `memo` longtext,
  `expectedTotal` float NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `accountsrc` (`accountsrc`),
  KEY `accountdst` (`accountdst`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`accountsrc`) REFERENCES `Accounts` (`id`),
  CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`accountdst`) REFERENCES `Accounts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
