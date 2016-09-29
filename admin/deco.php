<?php

	include 'lib/init.php';

	/**
	 * Initialisation
	 */
	use Lib\Tool;

	session_destroy();

	Tool::setFlash('Vous êtes maintenant déconnecté','succes');

	header('location:'.BASEADMIN);

?>