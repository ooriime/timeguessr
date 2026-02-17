# 🚀 Installation de TimeGuessr

Guide d'installation rapide pour lancer TimeGuessr sur votre machine.

## ⚡ Installation Rapide (Recommandé)

### Méthode 1 : Script de démarrage automatique

```bash
# Se placer dans le dossier du projet
cd timeguessr_game

# Lancer le script de démarrage
./start.sh
```

Le serveur démarrera automatiquement sur `http://localhost:8000`

### Méthode 2 : Commande PHP manuelle

```bash
# Se placer dans le dossier du projet
cd timeguessr_game

# Lancer le serveur PHP intégré
php -S localhost:8000
```

Puis ouvrez votre navigateur à : **http://localhost:8000**

---

## 📋 Prérequis

### Obligatoire
- **PHP 7.0 ou supérieur**
  - Vérifiez votre version : `php -v`
  - Téléchargement : [php.net](https://www.php.net/downloads)

### Recommandé
- Navigateur web moderne (Chrome, Firefox, Safari, Edge)
- Connexion internet (pour charger les images depuis Wikimedia Commons)

---

## 🖥️ Installation Détaillée

### Sur macOS

1. **Vérifier PHP (déjà installé sur macOS)**
   ```bash
   php -v
   ```

2. **Télécharger le projet**
   ```bash
   cd ~/Documents
   # Si vous avez le projet en ZIP, décompressez-le
   unzip timeguessr_game.zip
   cd timeguessr_game
   ```

3. **Lancer le serveur**
   ```bash
   ./start.sh
   ```

### Sur Windows

1. **Installer PHP**
   - Téléchargez XAMPP : [apachefriends.org](https://www.apachefriends.org/)
   - Ou installez PHP directement : [windows.php.net](https://windows.php.net/download/)

2. **Méthode A : Avec XAMPP**
   - Copiez le dossier `timeguessr_game` dans `C:\xampp\htdocs\`
   - Démarrez Apache depuis le panneau XAMPP
   - Ouvrez : `http://localhost/timeguessr_game`

3. **Méthode B : Serveur PHP manuel**
   ```cmd
   cd chemin\vers\timeguessr_game
   php -S localhost:8000
   ```
   - Ouvrez : `http://localhost:8000`

### Sur Linux (Ubuntu/Debian)

1. **Installer PHP**
   ```bash
   sudo apt update
   sudo apt install php php-cli
   ```

2. **Lancer le serveur**
   ```bash
   cd /chemin/vers/timeguessr_game
   php -S localhost:8000
   ```

3. **Accéder au jeu**
   - Ouvrez votre navigateur : `http://localhost:8000`

---

## 🔧 Configuration

### Changer le port

Si le port 8000 est déjà utilisé :

```bash
php -S localhost:8080
```

Puis accédez à : `http://localhost:8080`

### Permissions (Linux/macOS uniquement)

Si vous avez des problèmes de permissions :

```bash
chmod -R 755 timeguessr_game
chmod 666 stats.json
```

### Activer les erreurs (Développement)

Pour voir les erreurs PHP pendant le développement :

1. Éditez `.htaccess` et décommentez :
   ```apache
   php_flag display_errors On
   ```

---

## 🌐 Déploiement sur un serveur web

### Hébergement partagé (cPanel)

1. **Uploader les fichiers**
   - Connectez-vous via FTP (FileZilla, etc.)
   - Uploadez tous les fichiers dans `public_html/`

2. **Vérifier PHP**
   - Assurez-vous que PHP 7.0+ est activé
   - Vérifiez dans cPanel > "Sélectionner la version de PHP"

3. **Permissions**
   - `stats.json` : 666 (lecture/écriture)
   - Tous les autres fichiers : 644
   - Tous les dossiers : 755

4. **Accéder au site**
   - `http://votre-domaine.com`

### VPS/Serveur dédié (Nginx)

1. **Installer PHP-FPM**
   ```bash
   sudo apt install php-fpm
   ```

2. **Configuration Nginx**
   ```nginx
   server {
       listen 80;
       server_name votre-domaine.com;
       root /var/www/timeguessr_game;
       index index.php;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
           fastcgi_index index.php;
           include fastcgi_params;
           fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
       }
   }
   ```

3. **Redémarrer Nginx**
   ```bash
   sudo systemctl restart nginx
   ```

### VPS/Serveur dédié (Apache)

1. **Copier les fichiers**
   ```bash
   sudo cp -r timeguessr_game /var/www/html/
   ```

2. **Configurer Apache**
   - Le fichier `.htaccess` est déjà configuré
   - Assurez-vous que `mod_rewrite` est activé :
     ```bash
     sudo a2enmod rewrite
     sudo systemctl restart apache2
     ```

3. **Permissions**
   ```bash
   sudo chown -R www-data:www-data /var/www/html/timeguessr_game
   sudo chmod 666 /var/www/html/timeguessr_game/stats.json
   ```

---

## 🐛 Dépannage

### Le serveur ne démarre pas

**Problème** : `Address already in use`

**Solution** : Le port est déjà utilisé. Utilisez un autre port :
```bash
php -S localhost:8080
```

### Les images ne s'affichent pas

**Cause possible** : Pas de connexion internet ou Wikimedia Commons bloqué

**Solution** : Vérifiez votre connexion. Les images sont hébergées sur Wikimedia Commons.

### Erreur "Session not found"

**Solution** : Cliquez sur "Recommencer le jeu" ou supprimez les cookies du navigateur.

### Erreur 500 (Serveur)

**Causes possibles** :
- Permissions incorrectes sur `stats.json`
- PHP trop ancien (< 7.0)
- Extensions PHP manquantes

**Solutions** :
```bash
# Vérifier la version PHP
php -v

# Corriger les permissions
chmod 666 stats.json
```

### Le CSS ne se charge pas

**Solution** : Vérifiez que le dossier `assets/` est bien présent avec tous ses fichiers :
```bash
ls -la assets/css/
ls -la assets/js/
```

---

## ✅ Vérification de l'installation

Pour vérifier que tout fonctionne :

1. ✅ Accéder à `http://localhost:8000` affiche la page d'accueil
2. ✅ Cliquer sur "Commencer à jouer" affiche une image historique
3. ✅ Soumettre une estimation affiche le résultat
4. ✅ Le score s'incrémente correctement
5. ✅ Les images se chargent sans erreur

---

## 📞 Support

Si vous rencontrez des problèmes :

1. Vérifiez que vous avez bien suivi toutes les étapes
2. Consultez la section Dépannage ci-dessus
3. Vérifiez les logs d'erreur PHP
4. Ouvrez les outils de développement du navigateur (F12) pour voir les erreurs JavaScript/CSS

---

## 🎉 Installation réussie !

Si tout fonctionne, vous devriez voir :
- ⏰ La page d'accueil avec le logo TimeGuessr
- 🎮 Un bouton "Commencer à jouer"
- 🖼️ Un bouton "Voir les images"
- Des statistiques globales (si des parties ont été jouées)

**Amusez-vous bien !** 🎊
