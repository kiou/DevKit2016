<?php

	namespace Lib;

	/**
	 * Class Menu
	 */

	class Menu{

		/**
		 * Page en cours dans une liste ( ajout de la classe current )
		 * @param array la liste de pages à comparer 
		 */
		public static function getCurrentMenu ($pages){

			$current  = Tool::getUrl();

			foreach ($pages as $page) {
				if(!is_numeric($page) && $current  == $page) return 'current';
				else{
					$pageUrl = (isset($_GET['page'])) ? $_GET['page'] : '';
					if($pageUrl == $page) return 'current';
				}
			}

		}

		/**
		 * Afficher le menu en administration
		 * @param int le nombre d'itération
		 * @param int l'identifiant du parent
		 */
		public static function getMenuAdmin($recursive, $parentId = null){

			$recursive --;

			if($recursive >= 0){

				$requete = "SELECT * FROM menu ";
							if(is_null($parentId)) $requete .= " WHERE menuParent = 0  ";
							else  $requete .= " WHERE menuParent = $parentId  ";
							$requete .= " ORDER BY menuPoid ASC ";

				$sql = Database::getInstance()->bdd->query($requete);

				/* Si il y'a bien des éléments de menu */
				if($sql->rowCount() != 0 ){
					if(is_null($parentId)) echo'<ol class="sortable" data-url="'.BASEADMIN.'parametre/updateMenu.php">';
					else echo'<ol>';

						while($data = $sql->fetchObject()){
							echo'<li id="menuItem_'.$data->menuId.'">';
								echo'<div>';
									echo'<p><i class="fa fa-ellipsis-v"></i> '.$data->menuNom.'</p>';

									/* Actions */
									echo'<div class="menuAction">';
										/* Modifier */
										echo'<a href="'.BASEADMIN.'parametre/editMenu.php?menu='.$data->menuId.'" title="Modifier le menu"><i class="fa fa-pencil tableAction"></i></a>';
									
										/* Supprimer */
										echo'<a href="'.BASEADMIN.'parametre/deleteMenu.php?menu='.$data->menuId.'" title="Supprimer le menu" onclick="return confirm(\'êtes vous sur ?\')"><i class="fa fa-trash tableAction"></i></a>';
									echo'</div>';
								echo'</div>';

								self::getMenuAdmin($recursive, $data->menuId);
							echo'</li>'; // <-- Fin LI menu Root
						}

					echo'</ol>'; // <-- Fin OL menu Root
				}
			}

		}

	}

?>