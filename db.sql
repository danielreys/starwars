CREATE DATABASE characters_movies;

USE characters_movies;

CREATE TABLE characters (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
mass FLOAT,
height FLOAT,
gender VARCHAR(10),
picture VARCHAR(255)
);

CREATE TABLE movies (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL
);

CREATE TABLE movies_characters (
movie_id INT NOT NULL,
character_id INT NOT NULL,
PRIMARY KEY (movie_id, character_id),
FOREIGN KEY (movie_id) REFERENCES movies(id),
FOREIGN KEY (character_id) REFERENCES characters(id)
);