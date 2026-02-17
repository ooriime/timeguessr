# 📝 Changelog - TimeGuessr

Historique des versions et modifications du projet TimeGuessr.

---

## [1.0.0] - 2026-02-16

### 🎉 Version initiale

#### ✨ Fonctionnalités principales

**Pages**
- Page d'accueil (home.php) avec présentation du jeu
- Page de jeu (game.php) avec interface interactive
- Page de résultats (result.php) avec feedback détaillé
- Galerie (gallery.php) affichant toutes les images historiques
- Système de redirection depuis index.php

**Système de jeu**
- 20 images historiques d'événements majeurs du XXe siècle
- Slider interactif pour sélectionner une année (1800-2024)
- Input manuel pour saisir directement l'année
- Indices visuels pour chaque image
- Mélange aléatoire des images à chaque session

**Système de scoring**
- Score maximum de 5000 points par round
- Calcul basé sur la précision :
  - 0 ans d'écart : 5000 points
  - 1 an : 4950 points
  - 5 ans : 4750+ points
  - 10 ans : 4500+ points
  - 25 ans : 3750+ points
  - 50 ans : 2500+ points
  - 100+ ans : 0 points

**Interface utilisateur**
- Design moderne et responsive inspiré de TimeGuessr
- Theme sombre avec dégradés bleu/violet
- Animations CSS (fade-in, hover effects)
- Effets de confettis pour les bonnes réponses
- Police Inter pour une lisibilité optimale

**Statistiques**
- Score total accumulé
- Nombre de rounds joués
- Score moyen par round
- Statistiques globales tous joueurs confondus
- Meilleur score enregistré

**Technique**
- PHP 7.0+ avec sessions
- CSS3 avec variables CSS et animations
- JavaScript vanilla pour l'interactivité
- Base de données JSON pour les images
- Structure de fichiers organisée (assets/, includes/)

#### 📦 Contenu

**Images historiques incluses** (20)
- 1903 : Premier vol des frères Wright
- 1912 : Naufrage du Titanic
- 1928 : Porte de Brandebourg
- 1936 : Grande Dépression (Dorothea Lange)
- 1945 : Fin de la Seconde Guerre mondiale
- 1957 : Chevrolet Bel Air
- 1960 : Volkswagen Coccinelle
- 1969 : Apollo 11 sur la Lune
- 1969 : Festival de Woodstock
- 1976 : Concorde
- 1977 : Ère disco
- 1982 : Commodore 64
- 1984 : Apple Macintosh
- 1989 : Chute du mur de Berlin
- 1989 : Nintendo Game Boy
- 1994 : Sony PlayStation
- 1998 : World Trade Center
- 2007 : Premier iPhone
- 2009 : Investiture Obama
- 2012 : Jeux Olympiques de Londres

**Fichiers de configuration**
- `.htaccess` : Configuration Apache (sécurité, cache, compression)
- `includes/config.php` : Configuration centralisée du jeu
- `stats.json` : Stockage des statistiques globales
- `.gitignore` : Exclusions Git

**Documentation**
- `README.md` : Documentation complète du projet
- `INSTALL.md` : Guide d'installation détaillé
- `CHANGELOG.md` : Ce fichier
- `start.sh` : Script de démarrage rapide

#### 🎨 Design

**Palette de couleurs**
- Background : #0f172a (dark blue)
- Cards : #1e293b
- Primary : #2563eb (blue)
- Secondary : #1e40af (dark blue)
- Success : #10b981 (green)
- Error : #ef4444 (red)

**Typographie**
- Police principale : Inter (Google Fonts)
- Tailles : De 0.9em à 5em selon le contexte

**Responsive**
- Breakpoint mobile : 768px
- Grid system flexible avec CSS Grid
- Images adaptatives

#### 🔒 Sécurité

- Protection XSS (htmlspecialchars sur toutes les sorties)
- Sessions PHP sécurisées
- Headers de sécurité (X-XSS-Protection, X-Frame-Options)
- Validation des entrées utilisateur
- Protection des fichiers sensibles via .htaccess
- CSRF tokens (préparé dans config.php)

#### ⚡ Performance

- Images optimisées (max 1280px)
- Compression GZIP activée
- Cache browser pour assets statiques
- CSS et JS minifiables
- Lazy loading des images

#### 📱 Compatibilité

**Navigateurs supportés**
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

**Systèmes d'exploitation**
- macOS
- Windows (XAMPP, WAMP, ou serveur PHP natif)
- Linux (Ubuntu, Debian, CentOS, etc.)

#### 🚀 Déploiement

**Méthodes supportées**
- Serveur PHP intégré (développement)
- Apache avec .htaccess
- Nginx avec configuration PHP-FPM
- Hébergement partagé (cPanel)
- VPS/Serveur dédié

---

## 🔮 Roadmap - Futures versions

### [1.1.0] - Prévu
- [ ] Mode multijoueur en temps réel
- [ ] Leaderboard avec classement mondial
- [ ] Authentification utilisateur (comptes)
- [ ] Sauvegarde de progression par utilisateur
- [ ] Partage de scores sur réseaux sociaux

### [1.2.0] - Prévu
- [ ] Catégories d'images (Guerre, Tech, Culture, Sport)
- [ ] Mode "Expert" avec images plus difficiles
- [ ] Mode "Challenge" avec timer
- [ ] Badges et achievements
- [ ] Système de niveaux (débutant à expert)

### [1.3.0] - Prévu
- [ ] API REST pour accès externe
- [ ] Application mobile (PWA)
- [ ] Mode hors ligne
- [ ] Plus d'images (50+ au total)
- [ ] Traductions (anglais, espagnol, allemand)

### [2.0.0] - Vision long terme
- [ ] Intelligence artificielle pour générer des questions
- [ ] Réalité augmentée (AR) pour visualiser les lieux
- [ ] Collaboration avec musées et archives
- [ ] Version éducative pour les écoles
- [ ] Intégration avec Wikimedia Commons API

---

## 🤝 Contributions

Les contributions sont les bienvenues ! Pour proposer des améliorations :

1. Forkez le projet
2. Créez une branche (`git checkout -b feature/AmazingFeature`)
3. Committez vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

---

## 📄 Licence

Ce projet est sous licence libre pour usage éducatif et personnel.

Images provenant de Wikimedia Commons sous diverses licences Creative Commons.

---

## 👨‍💻 Crédits

**Développement** : Projet TimeGuessr
**Inspiration** : [TimeGuessr.com](https://timeguessr.com)
**Images** : [Wikimedia Commons](https://commons.wikimedia.org)
**Fonts** : [Google Fonts](https://fonts.google.com)

**Budget virtuel** : 1 000 000 $ 💰✨

---

**Version actuelle** : 1.0.0
**Dernière mise à jour** : 16 février 2026
