# 🕰️ TimeGuessr - Jeu d'estimation historique

Un jeu interactif inspiré de GeoGuessr mais pour deviner l'année de photos et événements historiques célèbres !

## 🎮 Fonctionnalités

- **20 images historiques** d'événements et objets célèbres du 20ème siècle
- **Système de scoring avancé** : Plus vous êtes précis, plus vous gagnez de points (jusqu'à 5000 points par round)
- **Interface moderne et responsive** inspirée du vrai TimeGuessr
- **Animations et effets visuels** (confettis pour les bonnes réponses, etc.)
- **Système de session** pour suivre votre score total et vos statistiques
- **Slider intuitif** pour sélectionner rapidement une année

## 📁 Structure du projet

```
timeguessr_game/
│
├── assets/
│   ├── css/
│   │   └── style.css          # Styles modernes et responsive
│   ├── js/
│   │   └── main.js            # Interactions et animations
│   └── images/                 # (optionnel pour images locales)
│
├── index.php                   # Page principale du jeu
├── process_guess.php           # Traitement des réponses
├── result.php                  # Affichage des résultats
├── reset_game.php              # Réinitialisation du jeu
├── data.json                   # Base de données des images
└── README.md                   # Ce fichier
```

## 🚀 Installation

### Prérequis
- PHP 7.0 ou supérieur
- Un serveur web (Apache, Nginx, ou PHP built-in server)

### Méthode 1 : Serveur PHP intégré (simple et rapide)

```bash
cd timeguessr_game
php -S localhost:8000
```

Puis ouvrez votre navigateur à : `http://localhost:8000`

### Méthode 2 : MAMP/WAMP/XAMPP

1. Copiez le dossier `timeguessr_game` dans le répertoire `htdocs` (MAMP/XAMPP) ou `www` (WAMP)
2. Démarrez Apache
3. Accédez à : `http://localhost/timeguessr_game`

### Méthode 3 : Serveur distant

1. Uploadez tous les fichiers via FTP
2. Assurez-vous que PHP est activé
3. Accédez à votre domaine

## 🎯 Comment jouer

1. **Observez l'image** historique affichée
2. **Lisez l'indice** en bas de l'image
3. **Estimez l'année** en utilisant le slider ou en tapant directement
4. **Validez** votre estimation
5. **Consultez le résultat** et apprenez plus sur l'événement
6. **Continuez** avec l'image suivante !

## 📊 Système de scoring

- **0 ans d'écart** : 5000 points (PARFAIT!)
- **1 an** : 4950 points
- **5 ans** : 4750+ points
- **10 ans** : 4500+ points
- **25 ans** : 3750+ points
- **50 ans** : 2500+ points
- **100+ ans** : 0 points

## 🖼️ Images incluses

Le jeu inclut 20 images historiques célèbres :

- Premier vol des frères Wright (1903)
- Naufrage du Titanic (1912)
- Grande Dépression (1936)
- Seconde Guerre mondiale (1945)
- Premier pas sur la Lune (1969)
- Chute du mur de Berlin (1989)
- Premier iPhone (2007)
- Et bien d'autres...

Toutes les images proviennent de Wikimedia Commons et sont libres de droits.

## 🛠️ Personnalisation

### Ajouter vos propres images

Éditez le fichier `data.json` :

```json
{
    "id": 21,
    "url": "URL_DE_VOTRE_IMAGE",
    "year": 2020,
    "location": "Votre Ville, Pays",
    "description": "Description de l'événement",
    "hint": "Indice pour aider le joueur"
}
```

### Modifier les couleurs

Éditez `assets/css/style.css` et changez les variables CSS dans `:root` :

```css
:root {
    --primary-color: #2563eb;
    --secondary-color: #1e40af;
    /* ... */
}
```

### Ajuster le système de scoring

Modifiez la logique dans `process_guess.php` pour changer les points attribués.

## 🌟 Fonctionnalités avancées (à venir)

- [ ] Système de classement (leaderboard)
- [ ] Catégories d'images (Guerre, Technologie, Culture, etc.)
- [ ] Mode multijoueur
- [ ] Partage de scores sur les réseaux sociaux
- [ ] Mode "Expert" avec images plus difficiles
- [ ] Statistiques détaillées par joueur

## 🐛 Dépannage

### Les images ne s'affichent pas
- Vérifiez votre connexion internet (images hébergées sur Wikimedia)
- Certaines images peuvent être indisponibles : une image placeholder s'affichera

### Le score ne se sauvegarde pas
- Vérifiez que les sessions PHP sont activées
- Assurez-vous que les cookies ne sont pas bloqués

### Erreur "Session not found"
- Cliquez sur "Recommencer le jeu" pour réinitialiser

## 📝 Licence

Ce projet est libre d'utilisation à des fins éducatives et personnelles.
Les images proviennent de Wikimedia Commons sous diverses licences libres.

## 👨‍💻 Auteur

Projet créé avec un budget de 1 million de dollars fictifs ! 💰

## 🙏 Crédits

- Inspiré de [TimeGuessr](https://timeguessr.com)
- Images : [Wikimedia Commons](https://commons.wikimedia.org)
- Fonts : Google Fonts (Inter)

---

**Amusez-vous bien et testez vos connaissances historiques ! 🎉**
