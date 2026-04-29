CREATE TABLE articles (
	id SERIAL PRIMARY KEY,
	title TEXT,
	text TEXT,
	labels VARCHAR(255),
	source VARCHAR(255),
	url VARCHAR(500)
);

ALTER TABLE articles
ADD COLUMN search_vector tsvector;

UPDATE articles
SET search_vector =
    to_tsvector('english', title || ' ' || text);
	
CREATE INDEX ft_articles
ON articles
USING gin (search_vector);