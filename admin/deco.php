<?php

	include 'lib/init.php';

	/**
	 * Initialisation
	 */
	use Lib\Tool;

	$_SESSION['utilisateur']['id'] = 'visiteur';
	$_SESSION['utilisateur']['nom'] = '';
	$_SESSION['utilisateur']['prenom'] = '';

	Tool::setFlash('Vous êtes maintenant déconnecté','succes');

	header('location:'.BASEADMIN);

?>