# 🗄️ Guide Base de Données - TimeGuessr

Ce guide explique comment utiliser une base de données SQLite au lieu du fichier JSON.

---

## 📊 **Deux options disponibles**

### **Option 1 : JSON (Actuel - Recommandé)**
- ✅ Simple et rapide
- ✅ Pas de configuration
- ✅ Fonctionne immédiatement
- ✅ Facile à éditer manuellement

### **Option 2 : SQLite (Avancé)**
- ✅ Plus performant pour beaucoup d'images
- ✅ Requêtes SQL puissantes
- ✅ Possibilité d'ajouter des images dynamiquement
- ✅ Meilleure gestion des données complexes

---

## 🚀 **Passer à SQLite**

### **Étape 1 : Créer la base de données**

Accédez à cette URL dans votre navigateur :
```
http://localhost:8000/setup_database.php
```

Cela va créer le fichier `timeguessr.db` avec toutes les images.

### **Étape 2 : Activer SQLite dans le code**

Ouvrez `includes/database.php` et changez cette ligne :

```php
$db = new ImageDatabase(false); // false = JSON
```

En :

```php
$db = new ImageDatabase(true); // true = SQLite
```

### **Étape 3 : Redémarrer le serveur**

```bash
# Arrêter le serveur (Ctrl+C)
# Relancer
./start.sh
```

---

## 📝 **Utiliser la base de données**

### **Lire toutes les images**

```php
<?php
require_once 'includes/database.php';

$db = new ImageDatabase(true);
$images = $db->getAllImages();

foreach ($images as $image) {
    echo $image['year'] . ' - ' . $image['location'] . '<br>';
}

$db->close();
?>
```

### **Ajouter une nouvelle image**

```php
<?php
require_once 'includes/database.php';

$db = new ImageDatabase(true);

$db->addImage(
    'https://example.com/image.jpg',  // URL
    1990,                              // Année
    'New York, USA',                   // Localisation
    'Description de l\'image',         // Description
    'Indice pour le joueur'            // Indice
);

$db->close();
?>
```

---

## 🔧 **Structure de la base de données**

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

## 🛠️ **Commandes SQL utiles**

### **Voir toutes les images**
```bash
sqlite3 timeguessr.db "SELECT * FROM images;"
```

### **Ajouter une image manuellement**
```bash
sqlite3 timeguessr.db "INSERT INTO images (url, year, location, description, hint) VALUES ('https://example.com/img.jpg', 2000, 'Paris', 'Description', 'Indice');"
```

### **Compter les images**
```bash
sqlite3 timeguessr.db "SELECT COUNT(*) FROM images;"
```

### **Supprimer une image**
```bash
sqlite3 timeguessr.db "DELETE FROM images WHERE id = 1;"
```

---

## 📦 **Avantages de SQLite**

### **Pour ce projet**
- ✅ Pas besoin de serveur MySQL
- ✅ Base de données dans un seul fichier
- ✅ Portable (copiez le fichier .db)
- ✅ Supporte les transactions
- ✅ Recherche rapide

### **Fonctionnalités futures possibles**
- Système de catégories (guerre, tech, culture...)
- Système de difficulté (facile, moyen, difficile)
- Statistiques par image (taux de réussite)
- Tags et filtres
- Commentaires des joueurs
- Système de notation

---

## 🔄 **Revenir au JSON**

Si vous voulez revenir au système JSON :

1. Ouvrez `includes/database.php`
2. Changez `true` en `false` :
   ```php
   $db = new ImageDatabase(false);
   ```
3. Redémarrez le serveur

---

## 📊 **Comparaison JSON vs SQLite**

| Critère | JSON | SQLite |
|---------|------|--------|
| **Simplicité** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ |
| **Performance** | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Requêtes complexes** | ⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Édition manuelle** | ⭐⭐⭐⭐⭐ | ⭐⭐ |
| **Scalabilité** | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Portabilité** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ |

---

## 🎯 **Recommandation**

Pour ce projet avec **20 images** :
- ✅ **Utilisez JSON** (plus simple, largement suffisant)

Si vous prévoyez d'avoir **100+ images** :
- ✅ **Passez à SQLite** (meilleures performances)

---

## 🐛 **Dépannage**

### Erreur : "Base de données non trouvée"
**Solution** : Exécutez d'abord `setup_database.php`

### Erreur : "SQLite3 class not found"
**Solution** : Installez l'extension PHP SQLite3
```bash
# Ubuntu/Debian
sudo apt-get install php-sqlite3

# macOS (généralement déjà installé)
# Vérifier : php -m | grep sqlite3
```

### La base de données ne se met pas à jour
**Solution** : Supprimez `timeguessr.db` et réexécutez `setup_database.php`

---

## 📚 **Ressources**

- [Documentation SQLite](https://www.sqlite.org/docs.html)
- [PHP SQLite3](https://www.php.net/manual/en/book.sqlite3.php)
- [SQL Tutorial](https://www.w3schools.com/sql/)

---

**Pour l'instant, le projet fonctionne avec JSON et c'est parfait ! ✨**
