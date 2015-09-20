<?php

	/**
	 * Class Tool
	 */

	namespace Lib;

	class Tool {

		/**
		 * Verifier si l'utilisateur est connecté
		 * @param string l'url de redirection si la personne n'est pas connecté
		 */
		public static function ifConnect($url){

			if(!isset($_SESSION['utilisateur']['id']) || $_SESSION['utilisateur']['id'] == 'visiteur'){
				header('location:'.$url);
				die();
			}
				
		}

		/**
		 * Affichage du tableau d'erreur
		 * @param array la liste des erreurs
		 */
		public static function getErreur ($erreur = array()) {
	
			if(!empty($erreur)){
				echo'<div class="message" id="erreur">';
					echo'<span class="messageCouleur"></span>';
					echo'<h3>Erreur</h3>';
					echo'<p>';
						foreach($erreur as $element){
							echo $element.'<br>';
						}
					echo'</p>';
				echo'</div>';
			}

		}

		/**
		 * Retourne la page en cours
		 * @return string
		 */
		public static function getUrl() {

			$url = $_SERVER['PHP_SELF'];
			$url = explode('/',$url);
	
			return end($url);

		}

		/**
		 * Coupe une chaine de caractère et ajoute "..."
		 * @param string la chaine de caractère
		 * @param int le nombre de caractéres maximum
		 * @return string 
		 */
		public static function tronquer($description,$max_caracteres){
			
			if (strlen($description)>$max_caracteres){    

				$description = substr($description, 0, $max_caracteres);
				$position_espace = strrpos($description, " "); 
				
				if($position_espace == false)
					$position_espace = strrpos($description, "-");

				$description = substr($description, 0, $position_espace);    
				$description = $description."...";

			}
			
			return $description;

		}

		/**
		 * Récupération d'une argument en GET numéraire
		 * @param int le paramétre GET
		 * @param string la redirection si il y'a un erreur ( falcutatif )
		 * @return int
		 */ 
		public static function getId($get,$redirection = null){

		    if(!isset($get) || empty($get) || !is_numeric($get) ){
		       	if($redirection != null){
		        	header('location:'.$redirection);
		        	die();
		    	}else{
		    		die('Erreur identifiant');
		    	}
		    }else
		        return $get;

		}

		/**
		 * Récupération d'une argument en GET alphanumérique
		 * @param int/string le paramétre GET
		 * @param string la redirection si il y'a un erreur ( falcutatif )
		 * @return string
		 */
		public static function getString($get,$redirection = null){

		    if(!isset($get) || empty($get) ){
		       	if($redirection != null){
		        	header('location:'.$redirection);
		        	die();
		    	}else{
		    		die('Erreur identifiant');
		    	}
		    }else
		        return $get;
		        
		}

		/**
		 * Page en cours dans une liste ( ajout de la classe current )
		 * @param array la liste de pages à comparer 
		 */
		public static function getCurrentMenu ($pages){

			$current  = self::getUrl();

			foreach ($pages as $page) {
				if(!is_numeric($page) && $current  == $page) echo 'current';
				else{
					$pageUrl = (isset($_GET['page'])) ? $_GET['page'] : '';
					if($pageUrl == $page) echo 'current';
				}
			}

		}

		/**
		 * Pagination
		 * @param string la requéte SQL
		 * @param string L'url pour la pagination
		 * @param int le nombre d'éléments par page
		 * @param int la variable de la page en cours
		 * @param bool so il y'a ubne réécriture d'url
		 * @param objet l'accès à la BDD ( PDO )
		 */
		public static function addPaginate($requete,$url,$nombre,$page,$bdd, $reecriture = false){

			$pattern = (!$reecriture) ? '.php?page=' : '/';

			echo'<ul>';

		        $precedente = $page-1;
		        if ($precedente > 0){
		            echo ('<li>');
		                echo ('<a href="'.$url.$pattern.$precedente.'" class="nav left">Prec</a>');
		            echo('</li>');
		        }


		        $sql = $bdd->query($requete);
		        $data = $sql->fetch(); 
		        $count = $data['total'];
		        $count = ceil($count / $nombre); 


		        for ($i=$page-4; $i<= $page+4; $i++){

		            if (($i > 0 )&&($i < $count+1)){
		                            
		                if ($i == $page){
		                    echo('<li class="active">');
		                        echo('<p>'.$i.'</p>');
		                    echo('</li>');		
		                }else{
		                     echo('<li>');
		                         echo('<a href="'.$url.$pattern.$i.'">'.$i.'</a>');
		                     echo('</li>');
		                 }
		            }
		        }


		        $suivante = $page+1;
		        if ($suivante <= $count){
		            echo ('<li>');
		                echo ('<a href="'.$url.$pattern.$suivante.'" class="nav right">Suiv</a>');
		            echo('</li>');
		        }

	        echo'</ul>';

		}

		/**
		 * Retourne une date avec l'objet datetime
		 * @param string le format de la date souhaitée
		 * @param string la date source
		 */
		public static function dateTime($format, $source = null){

			if($source == null){
				$dateTime = new \DateTime('now');
				return $dateTime->format($format);
			}else{
				$dateTime = new \DateTime($source);
				return $dateTime->format($format);
			}

		}

		/**
		 * Convertion d'une date
		 * @param string la date
		 * @param string le format de convertion
		 */
		public static function dateConvert($date, $zone){

			switch ($zone) {
				case 'fr=>en':
					$explode1 = explode('/',$date);
					$explode2 = explode(' ',$explode1[2]);
					$explode3 = explode(':',$explode2[1]);
					
					$jour = $explode1[0];
					$mois = $explode1[1];
					$annee = $explode2[0];
					$heure = $explode3[0];
					$minute = $explode3[1];

					return $annee.'-'.$mois.'-'.$jour.' '.$heure.':'.$minute;
				break;
			}

		}

		/**
		 * Retourne le contenu d'un sujet avec les liens entre valise a
		 * @param string la chaine de caractére
		 * @param array tableau d'option
		 * @return string la chaine avec la balise href sur les liens
		 */
		public static function autoLink($str, $attributes = array()) {
				
			$attrs = '';
			foreach ($attributes as $attribute => $value) {
				$attrs .= " {$attribute}=\"{$value}\"";
			}
		
			$str = ' ' . $str;
			$str = preg_replace(
				'`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i',
				'$1<a href="$2"'.$attrs.'>$2</a>',
				$str
			);
			$str = substr($str, 1);
			
			return $str;
			
		}

		/**
		 * Affiche une class par rapport à un modulo
		 * @param int le numéro de la ligne
		 * @param array la liste des modulos
		 */
		public static function addModulo($count, $modulos){

			$r = array();

			if(!empty($modulos)){

				foreach ($modulos as $nb => $modulo) {
					if(($count % $nb) == 0) array_push($r, $modulo);
				}

			}

			return implode(' ', $r);

		}

		/**
		 * affiche la bonne url pour les éléments ajouté avec le wysiwyg
		 * @param string la chaine de caractéres
		 * @return string
		 */
		public static function getMoxeimage($contenu){

			$contenu = str_replace('../../', BASEFRONT, $contenu);

			return $contenu;
		}

		/**
		 * Retourne les messages flash en session
		 */
		public static function getFlash(){

			$r = '';

			if(isset($_SESSION['flash'])){

				extract($_SESSION['flash']);
				unset($_SESSION['flash']);

				$r .= '<div class="message" id="'.$type.'">';
					switch ($type) {
						case 'succes':
							$r .= '<h3>Succès</h3>';
						break;
						case 'erreur':
							$r .= '<h3>Erreur</h3>';
						break;
					}
					$r .= '<span class="messageCouleur"></span>';
					$r .= '<p>'.$message.'</p>';
				$r .= '</div>';
			}

			return $r;

		}

		/**
		 * Ajouter un message flash en session
		 */
		public static function setFlash($message, $type = "succes"){

			$_SESSION['flash']['message'] = $message;
			$_SESSION['flash']['type'] = $type;

		}

	}

?>