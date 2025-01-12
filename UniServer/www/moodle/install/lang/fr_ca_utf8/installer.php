<?php
/// Please, do not edit this file manually! It's auto generated from
/// contents stored in your standard lang pack files:
/// (langconfig.php, install.php, moodle.php, admin.php and error.php)
///
/// If you find some missing string in Moodle installation, please,
/// keep us informed using http://moodle.org/bugs Thanks!
///
/// File generated by cvs://contrib/lang2installer/installer_builder
/// using strings defined in stringnames.txt (same dir)

$string['admindirerror'] = 'Le dossier d\'administration spécifié est incorrect';
$string['admindirname'] = 'Dossier d\'administration';
$string['caution'] = 'Attention';
$string['closewindow'] = 'Fermer cette fenêtre';
$string['configfilenotwritten'] = 'Le programme d\'installation n\'a pas pu créer automatiquement le fichier de configuration « config.php » contenant vos réglages, vraisemblablement parce que le dossier principal de Moodle n\'est pas accessible en écriture. Vous pouvez copier le code ci-dessous dans un fichier appelé « config.php », que vous placerez à l\'intérieur du dossier principal de Moodle (là où se trouve un fichier « config-dist.php »).';
$string['configfilewritten'] = 'Le fichier « config.php » a été créé avec succès';
$string['continue'] = 'Continuer';
$string['database'] = 'Base de données';
$string['dataroot'] = 'Dossier de données';
$string['datarooterror'] = 'Le dossier de données indiqué n\'a pas pu être trouvé, ni créé. Veuillez corriger le paramètre ou créer manuellement le dossier.';
$string['dbconnectionerror'] = 'Moodle n\'a pas pu se connecter à la base de données indiquée. Veuillez vérifier les paramètres de votre base de données';
$string['dbcreationerror'] = 'Erreur lors de la création de la base de données. Impossible de créer la base de données avec les paramètres fournis';
$string['dbhost'] = 'Serveur hôte';
$string['dbprefix'] = 'Préfixe des tables';
$string['dbtype'] = 'Type';
$string['dirroot'] = 'Dossier Moodle';
$string['dirrooterror'] = 'Le dossier Moodle semble incorrect : aucune installation de Moodle ne se trouve dans ce dossier. Le dossier Moodle indiqué ci-dessous est vraisemblablement correct.';
$string['download'] = 'Télécharger';
$string['error'] = 'Erreur';
$string['fail'] = 'Échec';
$string['fileuploads'] = 'Téléchargement des fichiers';
$string['fileuploadserror'] = 'Le téléchargement des fichiers sur le serveur doit être activé';
$string['fileuploadshelp'] = '<p>Le téléchargement des fichiers semble désactivé sur votre serveur.</p> <p>Moodle peut être installé malgré tout, mais personne ne pourra déposer aucun fichier de cours, ni aucune image dans les profils utilisateurs.</p> <p>Pour activer le téléchargement des fichiers sur votre serveur, vous (ou l\'administrateur du serveur) devez modifier le fichier « php.ini » du système en donnant au paramètre <b>file_uploads</b> la valeur 1.</p>';
$string['gdversion'] = 'Version de GD';
$string['gdversionerror'] = 'La librairie GD doit être activée pour traiter et créer les images';
$string['gdversionhelp'] = '<p>Il semble que la librairie GD n\'est pas installée sur votre serveur.</p> <p>GD est une librairie requise par PHP pour permettre à Moodle de traiter les images (comme les photos des profils) et de créer des graphiques (par exemple ceux des historiques). Moodle fonctionnera sans GD, mais ces fonctionnalités ne seront pas disponibles pour vous.</p> <p>Sous Unix ou Mac OS X, pour ajouter GD à PHP, vous pouvez compiler PHP avec l\'option <i>--with-gd</i>.</p> <p>Sous Windows, on peut normalement modifier le fichier « php.ini » en enlevant le commentaire de la ligne référençant la librairie php_gd2.dll.</p>';
$string['help'] = 'Aide';
$string['installation'] = 'Installation';
$string['language'] = 'Langue';
$string['magicquotesruntime'] = 'Magic Quotes Run Time';
$string['magicquotesruntimeerror'] = 'Ce réglage doit être désactivé';
$string['magicquotesruntimehelp'] = '<p>Le réglage « Magic quotes runtime » doit être désactivé pour que Moodle fonctionne correctement.</p> <p>Il est normalement désactivé par défaut. Voyez le paramètre <b>magic_quotes_runtime</b> du fichier « php.ini » de votre serveur.</p> <p>Si vous n\'avez pas accès à votre fichier « php.ini », vous pouvez créer dans le dossier principal de Moodle un fichier « .htaccess » contenant cette ligne : <p><blockquote>php_value magic_quotes_runtime Off</blockquote></p>';
$string['memorylimit'] = 'Limite de mémoire';
$string['memorylimiterror'] = 'La limite de mémoire de PHP est très basse. Vous risquez de rencontrer des problèmes ultérieurement.';
$string['memorylimithelp'] = '<p>La limite de mémoire de PHP sur votre serveur est actuellement de $a.</p> <p>Cette valeur très faible risque de générer des problèmes de manque de mémoire pour Moodle, notamment si vous utilisez beaucoup de modules et/ou si vous avez un grand nombre d\'utilisateurs.</p> <p>Il est recommandé de configurer PHP avec une limite de mémoire aussi élevée que possible, par exemple 16 Mo. Vous pouvez obtenir cela de différentes façons :
<ol>
<li>si vous en avez la possibilité, recompilez PHP avec l\'option <i>--enable-memory-limit</i>. Cela permettra à Moodle de fixer lui-même sa limite de mémoire ;</li>
<li>si vous avez accès à votre fichier « php.ini », vous pouvez attribuer au paramètre <b>memory_limit</b> une valeur comme 40M. Si vous n\'y avez pas accès, demandez à l\'administrateur de le faire pour vous ;</li>
<li>sur certains serveur, vous pouvez créer dans le dossier principal de Moodle un fichier « .htaccess » contenant cette ligne : <p><blockquote>php_value memory_limit 40M</blockquote></p> <p>Cependant, sur certains serveur, cela empêchera le fonctionnement correcte de <b>tous</b> les fichiers PHP (vous verrez s\'afficher des erreurs lors de la consultation de pages). Dans ce cas, vous devrez supprimer le fichier « .htaccess ».</li>
</ol>';
$string['name'] = 'Nom';
$string['next'] = 'Suivant';
$string['ok'] = 'Ok';
$string['parentlanguage'] = 'fr_utf8';
$string['pass'] = 'Réussi';
$string['password'] = 'Mot de passe';
$string['phpversion'] = 'Version de PHP';
$string['phpversionerror'] = 'La version du programme PHP doit être au moins 4.1.0';
$string['phpversionhelp'] = '<p>Moodle nécessite au minimum la version 4.1.0 de PHP.</p> <p>Vous utilisez actuellement la version $a.</p> <p>Pour que Moodle fonctionne, vous devez mettre à jour PHP ou aller chez un hébergeur ayant une version récente de PHP.</p>';
$string['previous'] = 'Précédent';
$string['safemode'] = 'Safe Mode';
$string['safemodeerror'] = 'Moodle risque de rencontrer des problèmes lorsque le mode « safe mode » est activé';
$string['safemodehelp'] = '<p>Moodle risque de rencontrer un certain nombre de problèmes lorsque le mode « safe mode » est activé. Il pourra notamment être incapable de créer de nouveaux fichiers.</p> <p>Ce mode n\'est habituellement activé que chez certains hébergeurs paranoïaques. Il vous faudra donc trouver un autre hébergeur pour votre site Moodle.</p> <p>Vous pouvez continuer l\'installation de Moodle, mais attendez-vous à des problèmes ultérieurement.</p>';
$string['sessionautostart'] = 'Démarrage automatique des sessions';
$string['sessionautostarterror'] = 'Ce paramètre doit être désactivé';
$string['sessionautostarthelp'] = '<p>Moodle a besoin du support des sessions. il ne fonctionnera pas sans cela.</p> <p>Les sessions peuvent être activées dans le fichier « php.ini » de votre serveur, en changeant la valeur du paramètre <b>session.auto_start</b>.</p>';
$string['status'] = 'Statuts';
$string['thischarset'] = 'UTF-8';
$string['thisdirection'] = 'ltr';
$string['thislanguage'] = 'Français - Canada';
$string['user'] = 'Utilisateur';
$string['wwwroot'] = 'Adresse web';
$string['wwwrooterror'] = 'L\'adresse web indiquée semble incorrecte : aucune installation de Moodle ne se trouve à cette adresse.';
?>
