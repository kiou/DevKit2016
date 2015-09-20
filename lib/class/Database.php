<?php

	/**
	 * Class Database
	 */

	namespace Lib;

	class Database{

		/**
		 * @var object instance de PDO
		 */
		private $bdd ;

		/**
		 * Création de l'objet PDO
		 */
		public function __construct(){

			try{
				$bdd = new \PDO('mysql:host='.HOST.';dbname='.DBNAME,USER,PASS);
				$bdd->exec("SET CHARACTER SET utf8");
				$this->bdd = $bdd;
			}
			catch(Exception $e){
				die(' Impossible de se connecter &agrave; la base de donn&eacute;e');
			}

		}

		/**
		 * Retourne l'objet PDO
		 * @return object
		 */
		public function getBdd(){
			return $this->bdd;
		}

	}

?>