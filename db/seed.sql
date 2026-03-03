-- TimeGuessr - Photos historiques celebres
-- Usage : mysql -u root timeguessr < db/seed.sql

USE timeguessr;

-- On vide les tables pour repartir proprement
DELETE FROM score_history;
DELETE FROM rounds;
DELETE FROM games;
DELETE FROM images;

INSERT INTO images (title, url, year, latitude, longitude, location) VALUES
('Discours de Martin Luther King', 'https://upload.wikimedia.org/wikipedia/commons/8/81/Martin_Luther_King_-_March_on_Washington.jpg', 1963, 38.8893, -77.0450, 'Lincoln Memorial, Washington D.C., Etats-Unis'),
('Chute du mur de Berlin', 'https://upload.wikimedia.org/wikipedia/commons/1/1c/West_and_East_Germans_at_the_Brandenburg_Gate_in_1989.jpg', 1989, 52.5163, 13.3777, 'Porte de Brandebourg, Berlin, Allemagne'),
('Buzz Aldrin sur la Lune - Apollo 11', 'https://upload.wikimedia.org/wikipedia/commons/9/98/Aldrin_Apollo_11_original.jpg', 1969, 28.5721, -80.6480, 'Cap Canaveral, Floride, Etats-Unis'),
('Drapeau americain sur Iwo Jima', 'https://upload.wikimedia.org/wikipedia/commons/b/b0/Raising_the_Flag_on_Iwo_Jima%2C_larger_-_edit1.jpg', 1945, 24.7501, 141.2891, 'Mont Suribachi, Iwo Jima, Japon'),
('Rosa Parks dans le bus', 'https://upload.wikimedia.org/wikipedia/commons/2/23/Rosa_Parks_Bus.jpg', 1956, 32.3765, -86.3113, 'Montgomery, Alabama, Etats-Unis'),
('Assassinat de John F. Kennedy', 'https://upload.wikimedia.org/wikipedia/commons/5/5c/JFK_limousine.png', 1963, 32.7797, -96.8086, 'Dealey Plaza, Dallas, Texas, Etats-Unis'),
('Bombe atomique sur Nagasaki', 'https://upload.wikimedia.org/wikipedia/commons/e/e0/Nagasakibomb.jpg', 1945, 32.7503, 129.8779, 'Nagasaki, Japon'),
('Les Beatles - Abbey Road', 'https://upload.wikimedia.org/wikipedia/commons/3/3d/Abbey_Road.jpg', 1969, 51.5320, -0.1778, 'Abbey Road, Londres, Royaume-Uni'),
('Debarquement en Normandie - D-Day', 'https://upload.wikimedia.org/wikipedia/commons/a/a5/Into_the_Jaws_of_Death_23-0455M_edit.jpg', 1944, 49.3715, -0.8885, 'Plage d\'Omaha, Normandie, France'),
('Nelson Mandela - discours a Hilton College', 'https://upload.wikimedia.org/wikipedia/commons/7/7a/Mandela_Hilton_College.jpg', 1994, -29.5333, 30.3000, 'Hilton College, KwaZulu-Natal, Afrique du Sud');

INSERT INTO score_history (image_id, play_count, avg_year_error, avg_geo_error, avg_score)
SELECT id, 0, 0, 0, 0 FROM images;
