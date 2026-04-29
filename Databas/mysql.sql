CREATE TABLE `articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` mediumtext,
  `text` longtext,
  `labels` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  PRIMARY KEY(`id`)
);

LOAD DATA INFILE 'articles_96k.csv'
INTO TABLE articles
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(title, text, labels, source, url);

CREATE FULLTEXT INDEX ft_articles ON articles (title, text);