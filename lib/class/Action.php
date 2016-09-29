<?php

	namespace Lib;

	/**
	 * Class Action
	 */
	class Action{

		/**
		 * Verification de l'existance d'un élément en BDD
		 * @param int l'identifiant de lélément
		 * @param string le nom de la table
		 * @param string l'url de
		 */
		public static function ifIsset($id, $name, $url){

			$nameId = $name.'Id';

			$sql = Database::getInstance()->bdd->prepare("SELECT $nameId FROM $name
								                          WHERE $nameId = :$nameId ");

			$sql->execute(array(
					$nameId => $id
				)
			);

			if($sql->rowCount() == 0){

				Tool::setFlash('Erreur identifiant','erreur');
				header('location:'.$url);
				die();

			}

		}

	}

?>