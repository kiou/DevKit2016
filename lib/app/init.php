<?php

	/* Fichier de configuration */
	include 'config.php';

	/* Autoloader via composer */
	include dirname(dirname(__DIR__)).'/vendor/autoload.php';

	/* Connexion à la BDD */
	$database = new Lib\Database();
	$bdd = $database->getBdd();

	/* Session */
	include 'session.php';
	
?>