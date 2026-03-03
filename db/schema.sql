-- TimeGuessr Clone - Schema BDD
-- Usage : mysql -u root < db/schema.sql

CREATE DATABASE IF NOT EXISTS timeguessr CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE timeguessr;

DROP TABLE IF EXISTS score_history;
DROP TABLE IF EXISTS rounds;
DROP TABLE IF EXISTS games;
DROP TABLE IF EXISTS images;

CREATE TABLE images (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(255)  NOT NULL,
    url         VARCHAR(500)  NOT NULL,
    year        SMALLINT      NOT NULL,
    latitude    DECIMAL(10,7) NOT NULL,
    longitude   DECIMAL(10,7) NOT NULL,
    location    VARCHAR(255)  NOT NULL,
    created_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE games (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    total_score INT           DEFAULT 0,
    created_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    finished_at TIMESTAMP     NULL
) ENGINE=InnoDB;

CREATE TABLE rounds (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    game_id      INT UNSIGNED  NOT NULL,
    image_id     INT UNSIGNED  NOT NULL,
    round_number TINYINT       NOT NULL,
    guessed_year SMALLINT      NULL,
    guessed_lat  DECIMAL(10,7) NULL,
    guessed_lng  DECIMAL(10,7) NULL,
    year_score   INT           DEFAULT 0,
    geo_score    INT           DEFAULT 0,
    total_score  INT           DEFAULT 0,
    answered_at  TIMESTAMP     NULL,
    FOREIGN KEY (game_id)  REFERENCES games(id)  ON DELETE CASCADE,
    FOREIGN KEY (image_id) REFERENCES images(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE score_history (
    image_id       INT UNSIGNED NOT NULL PRIMARY KEY,
    play_count     INT          DEFAULT 0,
    avg_year_error FLOAT        DEFAULT 0,
    avg_geo_error  FLOAT        DEFAULT 0,
    avg_score      FLOAT        DEFAULT 0,
    FOREIGN KEY (image_id) REFERENCES images(id) ON DELETE CASCADE
) ENGINE=InnoDB;
