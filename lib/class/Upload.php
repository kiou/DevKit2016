<?php

	/**
	 * Class Upload
	 */

	namespace Lib;

	class Upload{

		/**
		 * Verifier l'extention d'un fichier
		 * @param string Le nom du fichier
		 * @param string L'index name du tableau $_FILES
		 * @param array la liste des extensions authorisées
		 * @return ext
		 */
		public static function verifExt($nom, $fichier, $extTrue){

			global $erreur;

			$ext = strtolower(pathinfo($fichier, PATHINFO_EXTENSION));
			if(!in_array($ext,$extTrue)){
				array_push($erreur,$nom.' : Le format du fichier n\'est pas bon');	
			}
			
		}	

		/**
		 * Restriction de la taille de l'image à une taille minimum
		 * @param string Le nom du fichier
		 * @param string L'index tmp_name du tableau $_FILES 
		 * @param int La largeur en pixel
		 * @param int La hauteur en pixel
		 */
		public static function tailleMini ($nom, $tmp, $x, $y){
			
			global $erreur;

			$taille = getimagesize($tmp);
			$width = $taille[0];
			$height = $taille[1];
			if( ($height < $y) || ($width < $x) ){
				array_push($erreur,$nom.' : Veuillez sélectionner un fichier avec une largeur de '.$x.' minimum, et une hauteur de '.$y.' minimum.');
			}
				
		}

		/**
		 * Restriction de la taille de l'image à une taille maximum
		 * @param string Le nom du fichier
		 * @param string L'index tmp_name du tableau $_FILES 
		 * @param int La largeur en pixel
		 * @param int La hauteur en pixel
		 */
		public static function tailleMax ($nom, $tmp, $x, $y){
			
			global $erreur;

			$taille = getimagesize($tmp);
			$width = $taille[0];
			$height = $taille[1];
			if( ($height > $y) || ($width > $x) ){
				array_push($erreur,$nom.' : Veuillez sélectionner un fichier avec une largeur de '.$x.' maximum, et une hauteur de '.$y.' maximum.');
			}
				
		}

		/**
		 * Restriction de la taille de l'image à une taille  égale
		 * @param string Le nom du fichier
		 * @param string L'index tmp_name du tableau $_FILES 
		 * @param int La largeur en pixel
		 * @param int La hauteur en pixel
		 */
		public static function tailleEgale ($nom, $tmp, $x, $y){
			
			global $erreur;

			$taille = getimagesize($tmp);
			$width = $taille[0];
			$height = $taille[1];
			if( ($height != $y) || ($width != $x) ){
				array_push($erreur,$nom.' : Veuillez sélectionner un fichier avec une largeur de '.$x.' exactement, et une hauteur de '.$y.' exactement.');
			}
				
		}

		/**
		 * Verification du poid de l'image
		 * @param string Le nom du fichier
		 * @param string L'index tmp_name du tableau $_FILES 
		 * @param int Le poid de l'image en octets
		 */
		public static function maxPoid ($nom, $fichier, $poid){
		
			global $erreur;
			if(filesize($fichier) > $poid){
				$erreurPoid = ($poid / 1000000);
				array_push($erreur,$nom.' : Veuillez sélectionner un fichier de '.$erreurPoid.'Mo maximum');
			}
			
		}

		/**
		 * Upload d'un fichier
		 * @param array Le fichier tableau $_FILES
		 * @param string Le nom
		 * @param int Le poid maximum en octets
		 * @param array Les extensions autorisées
		 * @param array la taille (méthode à utiliser, largeur, hauteur)
		 * @return string le nom du fichier renommé avec le time() + l'extension du fichier 
		 */
		public static function postFichier($fichier, $nom, $poid, $ext, $taille = array()){

			self::maxPoid($nom, $fichier['tmp_name'], $poid);
			self::verifExt($nom, $fichier['name'], $ext);

			if(!empty($taille)){

				switch ($taille[0]) {
					case "eg":
						self::tailleEgale($nom, $fichier['tmp_name'], $taille[1],$taille[2]);
					break;
					case "ma":
						self::tailleMax($nom, $fichier['tmp_name'], $taille[1],$taille[2]);
					break;
					case "mi":
						self::tailleMini($nom, $fichier['tmp_name'], $taille[1],$taille[2]);
					break;
				}

			}

			return uniqid().'.'.strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));

		}

		/**
		 * Verifier les coordonnées pour le crop, si jamais la largeur de l'image est > à x alors elles sont recalculées
		 * @param array le tableau des coordonnées
		 * @param int la largueur maximum de l'image
		 * @param string l'image temporaire
		 * @return array le tableau des coordonnées propre
		 */

		public static function getCoordonnees($post, $max, $tmp){

			$r  = array();
			$x1 = $post['x1'];
			$y1 = $post['y1'];
			$x2 = $post['x2'];
			$y2 = $post['y2'];
			$w  = $post['w'];
			$h  = $post['h'];

			$taille = getimagesize($tmp);
			$width  = $taille[0];

			if($width > $max){			

				$ratio = $max / $width;

				$r['w']  = ($x2 - $x1) / $ratio;
				$r['h']  = ($y2 - $y1) / $ratio;
				$r['x1'] = $x1 / $ratio;
				$r['y1'] = $y1 / $ratio;

			}

			return $r;

		}

		/**
		 * Retourne un tableau propre pour un champ file multiple
		 * @param array la variables $_FILES
		 * @return array
		 */
		public static function arrayMultiple($files){

		    $file_ary = array();
		    $file_count = count($files['name']);
		    $file_keys = array_keys($files);

		    for ($i=0; $i<$file_count; $i++) {
		        foreach ($file_keys as $key) {
		            $file_ary[$i][$key] = $files[$key][$i];
		        }
		    }

		    return $file_ary;

		}
		
	}

?>
