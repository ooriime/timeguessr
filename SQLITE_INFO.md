# 🗄️ TimeGuessr - Configuration SQLite

Le site utilise maintenant **SQLite** au lieu de fichiers JSON !

---

## ✅ **Avantages**

- ⚡ **Plus rapide** : Requêtes optimisées
- 🔍 **Recherche avancée** : Filtres par année, lieu, etc.
- 📊 **Statistiques** : Analyse des données facilitée
- 🛠️ **Gestion** : Ajout/modification/suppression d'images plus simple
- 📈 **Scalabilité** : Peut gérer des centaines d'images

---

## 📁 **Fichiers créés**

- `timeguessr.db` - Base de données SQLite
- `includes/db.php` - Classe de gestion BDD
- `setup_sqlite.php` - Script d'installation

---

## 🎯 **Commandes utiles**

### **Voir toutes les images dans la BDD**
```bash
sqlite3 timeguessr.db "SELECT id, year, location FROM images;"
```

### **Compter les images**
```bash
sqlite3 timeguessr.db "SELECT COUNT(*) FROM images;"
```

### **Rechercher par année**
```bash
sqlite3 timeguessr.db "SELECT * FROM images WHERE year = 1989;"
```

### **Ajouter une image manuellement**
```bash
sqlite3 timeguessr.db "INSERT INTO images (url, year, location, description, hint) VALUES ('chemin/image.jpg', 2024, 'Paris, France', 'Description', 'Indice');"
```

### **Sauvegarder la base de données**
```bash
cp timeguessr.db timeguessr_backup.db
```

---

## 🔧 **Gestion des images**

### **Depuis PHP**

```php
<?php
require_once 'includes/db.php';
$db = Database::getInstance();

// Récupérer toutes les images
$images = $db->getAllImages();

// Ajouter une image
$db->addImage(
    'assets/images/historical/new.jpg',
    2024,
    'Paris, France',
    'Nouvel événement',
    'Indice'
);

// Compter les images
$count = $db->countImages();
?>
```

---

## 📊 **Structure de la table**

```sql
CREATE TABLE images (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    url TEXT NOT NULL,
    year INTEGER NOT NULL,
    location TEXT NOT NULL,
    description TEXT NOT NULL,
    hint TEXT NOT NULL
);
```

---

## 🔄 **Revenir à JSON**

Si vous voulez revenir au système JSON :

1. Modifier `game.php` ligne 4-5 :
   ```php
   // Au lieu de :
   require_once 'includes/db.php';
   $db = Database::getInstance();
   $images = $db->getAllImages();

   // Remettre :
   $images_json = file_get_contents('data.json');
   $images = json_decode($images_json, true);
   ```

2. Le fichier `data.json` reste intact et peut être réutilisé

---

## 🚀 **Fonctionnalités futures possibles**

Avec SQLite, vous pouvez facilement ajouter :

- 🏷️ **Catégories** : Guerre, Technologie, Culture, etc.
- ⭐ **Difficulté** : Facile, Moyen, Difficile
- 📈 **Stats par image** : Taux de réussite, moyenne des joueurs
- 🔍 **Filtres** : Jouer seulement certaines catégories/époques
- 💬 **Commentaires** : Les joueurs commentent les images
- 👥 **Multi-utilisateurs** : Comptes et classements personnalisés

---

## ✅ **Le système est opérationnel !**

SQLite est maintenant activé. Le jeu fonctionne exactement pareil pour les joueurs, mais avec une base de données robuste derrière.

**Profitez-en !** 🎮
