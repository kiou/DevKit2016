<?php

	/**
	 * Class Breadcrumb
	 */

	namespace Lib;

	class BreadCrumb{


		/**
		 * Ajouter un breadcrumb à une page
		 * @param array liste des élément du breadcrumb ( index = nom de la page, value = url de la page ) si url est vide alors c'est la page en cours 
		 */
		public static function add ($base, $breadcrumb){

			if(!empty($breadcrumb)){

				echo'<ul id="breadcrumb">';
					foreach ($breadcrumb as $nom => $lien) {
						if(empty($lien)){
							echo'<li class="active">'.$nom.'</li> ';
						}else{
							echo'<li><a href="'.$base.$lien.'">'.$nom.'</a> <span class="divider">/</span></li>';
						}
					}
				echo'</ul>';

			}

		}

	}

?>