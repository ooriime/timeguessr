#!/bin/bash

# Script de démarrage pour TimeGuessr
# Lance un serveur PHP local sur le port 8000

echo "╔═══════════════════════════════════════════╗"
echo "║                                           ║"
echo "║       ⏰  TimeGuessr  ⏰                  ║"
echo "║                                           ║"
echo "║   Jeu d'estimation historique            ║"
echo "║                                           ║"
echo "╚═══════════════════════════════════════════╝"
echo ""
echo "🚀 Démarrage du serveur PHP..."
echo "📍 URL: http://localhost:8000"
echo ""
echo "Appuyez sur Ctrl+C pour arrêter le serveur"
echo ""

# Lancer le serveur PHP
php -S localhost:8000 -t .

# Note: Si le port 8000 est déjà utilisé, vous pouvez utiliser:
# php -S localhost:8080 -t .
