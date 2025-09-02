# 🎉 KUDOS App  

## 📖 Description  
**KUDOS App** est une application **Symfony** qui permet à des employés d'un starttup de se remercier et de valoriser leurs contributions mutuelles.  
L’objectif est de favoriser une **culture de gratitude** et d’encourager les interactions positives entre collègues.  

## 🚀 Fonctionnalités  
- ✨ Envoi de remerciements entre employés  
- 📜 Historique des remerciements reçus et envoyés  
- 👤 Gestion des utilisateurs (authentification Symfony)  
- 🗄️ Persistance des données via base de données relationnelle  

## 🛠️ Installation

1. **Clonez le dépôt** :  
```bash
git clone https://github.com/ton-compte/kudos-app.git
cd kudos-app
``` 

2. **Installez les dépendances** :  
```bash
composer install
```

3. **Configurez l’environnement** :
Copiez le fichier .env et modifiez-le selon votre configuration (base de données, mailer, etc.) :
```bash
cp .env .env.local
```

5. **Initialisez la base de données** :
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

6. **(Optionnel) Chargez des données de test** :
```bash
php bin/console doctrine:fixtures:load
```

7. **▶️ Utilisation** :

  Lancez le serveur Symfony :
```bash
symfony server:start
ou
php -S localhost:8000 -t public
```

