<?php

	namespace Lib;

	/**
	 * Class Utilisateur
	 */
	class Utilisateur{

		/**
		 * Verifier si l'utilisateur est connecté
		 * @param array liste des rôles
		 */
		public static function ifConnect($rolesAuth = array(), $url = null){

			/* Vérifier si l'utilisateur est connecté */
			if(!isset($_SESSION['utilisateur']['id']) || empty($_SESSION['utilisateur']['id']) ) {

				/* Afficher une erreur 403 navigateur */
				if(is_null($url)) header('HTTP/1.0 403 Forbidden');
				else{
					/* Rediréction + message d'erreur */
					header('location:'.$url);
					Tool::setFlash('Vous devez être connecté pour utiliser cette page','erreur');
				}

				/* Fin du script */
				die();
			}else{
				/* si l'utilisateur est connecté, verifier le rôle */
				if(!empty($rolesAuth)){
					if(!in_array($_SESSION['role']['id'], $rolesAuth)){
						/* Afficher une erreur 403 navigateur */
						header('HTTP/1.0 403 Forbidden');
						die();
					}	
				}
			}

		}

		/**
		 * Donne des informations sur l'utilisateur connecté
		 * @param  object PDO
		 */
		public static function getCurrentUtilisateur(){

			if(!isset($_SESSION['utilisateur']['id']) || $_SESSION['utilisateur']['id'] == 'visiteur') return false;
			else{
				$sql = Database::getInstance()->bdd->prepare("SELECT * FROM utilisateur
									  						  WHERE utilisateurId = :utilisateurId ");
				$sql->execute(array(
						'utilisateurId' => $_SESSION['utilisateur']['id']
					)
				);

				return $sql->fetch(\PDO::FETCH_OBJ);
			}

		}
		
	}

?>