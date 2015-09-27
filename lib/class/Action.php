<?php

	namespace Lib;

	/**
	 * Class Action
	 */
	class Action{

		/**
		 * Verification de l'utilisateur
		 * @param int l'identifiant de l'utilisateur
		 * @param object PDO
		 */
		public static function ifUtilisateurAdmin($utilisateur, $bdd){

			$sql = $bdd->prepare("SELECT COUNT(utilisateurId) AS count FROM utilisateur
								  WHERE utilisateurId = :utilisateurId ");

			$sql->execute(array(
					'utilisateurId' => $utilisateur
				)
			);

			if($sql->rowCount() == 0){

				Tool::setFlash('Erreur identifiant','erreur');
				header('location:'.BASEADMIN.'utilisateur/manageurUtilisateur.php');
				die();

			}

		}

	}

?>