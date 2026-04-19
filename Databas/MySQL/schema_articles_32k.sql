CREATE TABLE `articles` (
  `id` int NOT NULL,
  `title` mediumtext,
  `text` longtext,
  `labels` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  PRIMARY KEY(`id`),
  FULLTEXT KEY `ft_articles_32k` (`title, text`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;