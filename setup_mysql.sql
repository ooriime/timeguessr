CREATE DATABASE IF NOT EXISTS timeguessr;
USE timeguessr;

CREATE TABLE IF NOT EXISTS images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NOT NULL,
    year INT NOT NULL,
    location VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    hint VARCHAR(255) NOT NULL
);

INSERT INTO images (url, year, location, description, hint) VALUES
('assets/images/historical/1906_earthquake_sf.jpg', 1906, 'San Francisco, USA', 'Tremblement de terre de San Francisco - Foules dans les rues', 'Catastrophe naturelle majeure aux USA'),
('assets/images/historical/1929_wall_street_crash.jpg', 1929, 'New York, USA', 'Krach boursier de Wall Street - Foule devant la bourse', 'Debut de la Grande Depression'),
('assets/images/historical/1945_ve_day.jpg', 1945, 'Londres, UK', 'Jour de la Victoire en Europe - Foules celebrant', 'Fin de la guerre en Europe'),
('assets/images/historical/1963_march_washington.jpg', 1963, 'Washington D.C., USA', 'Marche pour les droits civiques - I Have a Dream', 'Discours de Martin Luther King'),
('assets/images/historical/1968_prague_spring.jpg', 1968, 'Prague, Tchecoslovaquie', 'Printemps de Prague - Invasion sovietique', 'Resistance pacifique contre les chars'),
('assets/images/historical/1986_chernobyl.jpg', 1986, 'Tchernobyl, Ukraine', 'Catastrophe nucleaire de Tchernobyl', 'Pire accident nucleaire de l histoire'),
('assets/images/historical/1989_berlin_wall.jpg', 1989, 'Berlin, Allemagne', 'Chute du mur de Berlin - Foules euphoriques', 'Fin de la Guerre froide'),
('assets/images/historical/2001_september_11.jpg', 2001, 'New York, USA', 'World Trade Center avant le 11 septembre', 'Annee des attentats terroristes'),
('assets/images/historical/2011_arab_spring.jpg', 2011, 'Le Caire, Egypte', 'Printemps arabe - Manifestations place Tahrir', 'Revolutions au Moyen-Orient');
