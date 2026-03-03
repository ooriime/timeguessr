# TimeGuessr Clone

Clone du jeu [TimeGuessr](https://timeguessr.com) developpe en **vanilla PHP, HTML et CSS** dans le cadre du projet final ESGI T2.

---

## Instructions pour lancer le projet

### Prerequis

| Outil | Version minimale |
|-------|-----------------|
| PHP | 8.1 |
| MySQL / MariaDB | 8.0 |
| Serveur web | Apache 2.4 ou PHP built-in server |

### 1. Cloner le depot

```bash
git clone https://github.com/<votre-username>/timeguessr.git
cd timeguessr
```

### 2. Creer la base de donnees

```bash
mysql -u root -p < db/schema.sql
mysql -u root -p timeguessr < db/seed.sql
```

### 3. Configurer la connexion BDD

Variables d environnement disponibles :

```bash
export DB_HOST=localhost
export DB_USER=root
export DB_PASS=
export DB_NAME=timeguessr
```

Par defaut : localhost / root / (vide) / timeguessr.

### 4. Lancer le serveur

```bash
php -S localhost:8080 -t .
```

Ouvrez **http://localhost:8080** dans votre navigateur.

---

## Etat d avancement

### Jalon A (10 pts)
- Depot public clonable, README present
- MCD (voir docs/MCD.md), schema.sql, seed.sql
- Demarrage de partie, navigation entre manches
- Code PHP documente

### Jalon B (16 pts)
- Chaque manche affiche une image differente avec inputs
- HTML semantique, CSS avec charte graphique
- Proposition de rejouer en fin de partie
- Validation des inputs cote serveur, PDO

### Jalon C (20 pts)
- Images tirees aleatoirement en BDD (5 par partie)
- Algorithme de score annee + geo (Haversine)
- Carte interactive Leaflet avec epingle
- Score prenant en compte temps et distance

### Bonus
- Historique des scores par image (table score_history + page /history.php)
- Gestion gracieuse des erreurs (sans exposition des details)
- Design responsive

---

## Algorithme de score

### Score annee (max 5 000 pts)

```
year_score = max(0, 5000 * max(0, 1 - |annee_devinee - annee_reelle| / 50))
```

| Ecart | Score |
|-------|-------|
| 0 ans | 5 000 |
| 10 ans | 3 000 |
| 25 ans | 2 500 |
| 50 ans | 0 |

### Score localisation (max 5 000 pts)

Distance Haversine en km, decroissance exponentielle :

```
geo_score = floor(5000 * e^(-distance_km / 2000))
```

| Distance | Score |
|----------|-------|
| 0 km | 5 000 |
| 500 km | ~2 850 |
| 2000 km | ~1 840 |
| 5000 km | ~82 |

### Total

```
max_total = 5 * (5000 + 5000) = 50 000 pts
```

---

## Dictionnaire de donnees

| Table | Champ | Type | Description |
|-------|-------|------|-------------|
| images | id | INT PK | Identifiant |
| images | title | VARCHAR(255) | Legende |
| images | url | VARCHAR(500) | URL de l image |
| images | year | SMALLINT | Annee reelle |
| images | latitude | DECIMAL(10,7) | Latitude WGS84 |
| images | longitude | DECIMAL(10,7) | Longitude WGS84 |
| images | location | VARCHAR(255) | Nom du lieu |
| games | id | INT PK | Identifiant de partie |
| games | total_score | INT | Score cumule |
| games | created_at | TIMESTAMP | Debut |
| games | finished_at | TIMESTAMP | Fin |
| rounds | id | INT PK | Identifiant manche |
| rounds | game_id | FK | Partie |
| rounds | image_id | FK | Image |
| rounds | round_number | TINYINT | Numero (1-5) |
| rounds | guessed_year | SMALLINT | Annee soumise |
| rounds | guessed_lat/lng | DECIMAL | Coords soumises |
| rounds | year_score | INT | Score annee |
| rounds | geo_score | INT | Score geo |
| rounds | total_score | INT | Score manche |
| score_history | image_id | FK PK | Image |
| score_history | play_count | INT | Nb parties |
| score_history | avg_year_error | FLOAT | Ecart moyen (ans) |
| score_history | avg_geo_error | FLOAT | Ecart moyen (km) |
| score_history | avg_score | FLOAT | Score moyen |

---

## Structure du projet

```
timeguessr/
+-- index.php          Accueil / demarrage de partie
+-- game.php           Manche en cours
+-- results.php        Fin de partie
+-- history.php        Statistiques (bonus)
+-- css/
|   +-- style.css      Feuille de style principale
+-- includes/
|   +-- db.php         Connexion PDO singleton
|   +-- functions.php  Logique metier + calcul score
|   +-- header.php     En-tete HTML commun
|   +-- footer.php     Pied de page HTML commun
+-- db/
|   +-- schema.sql     Creation des tables
|   +-- seed.sql       Donnees de test (10 images)
+-- docs/
|   +-- MCD.md         Modele Conceptuel de Donnees
+-- README.md
```

---

## Commentaires

Ce projet m a permis de consolider la gestion de session PHP, les requetes preparees PDO et l integration de Leaflet.js.
Le principal defi a ete l equilibrage du calcul de score entre les dimensions temporelle et geographique.

Developpe par Paul - ESGI 1 - Fevrier/Mars 2025.
