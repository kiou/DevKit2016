<?php

	/* Fichier de configuration */
	include dirname(dirname(__DIR__)).'/lib/app/config.php';

	/* Autoloader via composer */
	include dirname(dirname(__DIR__)).'/vendor/autoload.php';

	/* Connexion à la BDD */
	$bdd = Lib\Database::getInstance()->bdd;

	/* Session */
	include 'session.php';

?>