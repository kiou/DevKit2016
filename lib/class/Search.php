<?php

	/**
	 * Class Search
	 */

	namespace Lib;

	class Search {

		/**
		 * Récupération du formulaire
		 * @param string prefix de la session qui correspond à la page de la recherche
		 */
		public static function postRecherche($prefix){

			foreach ($_POST as $key => $value) {
				if($key != "addRecherche")
					$_SESSION[$prefix.'_'.$key] = $value;
			}

		}

		/**
		 * Compléter la session pour garder la recherche en mémoire
		 * @param string prefix de la session qui correspond à la page de la recherche
		 * @param array Liste des champs de recherche
		 * @return array liste des élément de recherche en session
		 */
		public static function getRecherche($prefix, $recherche){

			$return = array();

			foreach ($recherche as $value) {
				if(isset($_SESSION[$prefix.'_'.$value])){
					$$value = $_SESSION[$prefix.'_'.$value];
					$return[$value] = $$value;
				}else{
					$return[$value] = '';
				}
					
			}

			return $return;

		}

	}

?>
