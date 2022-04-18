- Méthode de déploiement du site en local:

j'ai utilisé ici xammp pour le déploiement de mon site en local.

Après l'installation de xammp allez dans le dossier ou vous lavez installer, 
puis allez dans les dossiers xampp/htdocs et glisser ou créer votre site ici, 
pour la mise en place d'une base de données, xampp offre la possibilité d'utiliser 
PHPmyAdmin qui est utilisable dans le panel de xampp après l'exécution.

Pour implementer la base de données il vous suffit de saisir le code suivant dans Phpmyadmin dans l'onglet SQL.
le code se trouve dans le dossier annexe/base de donnée/hypnos.txt

- Méthode de déploiement du site en ligne:

j'ai utilisé ici heroku pour le déploiement de mon site en ligne.
j'ai principalement utilisé les informations du tuto pour pouvoir mettre mon application en ligne : 
https://www.doabledanny.com/Deploy-PHP-And-MySQL-to-Heroku

Résumer du tuto :
1. Lier votre projet git à votre projet heroku en implémentent à votre projet git un fichier 'composer.json'.
2. Installer la ressource "ClearDB MySQL" puis dans les réglages dans le config var la clé 'CLEARDB_DATABASE_URL' 
est une URL avec toutes les informations à la connexion à la base de donnée.
3. Dans xampp créé un nouvel accès à une nouvelle base grace au fichier "config.inc.php".
4. implementer la base de données.

Pour implementer la base de données il vous suffit de saisir le code suivant dans Phpmyadmin dans l'onglet SQL.

le code se trouve dans le dossier annexe/base de donnée/hypnos.txt

Pour ajouter un administrateur il vous suffit de créer un compte utilisateur sur le site (cela permettra de bien sécuriser le compte) 
puis dans l'onglet SQL de PHPmyadmin de modifier le rôle customer par le rôle admin grace à la commande suivante :

UPDATE users
SET role = 'admin'
WHERE email = 'email de l'admin'