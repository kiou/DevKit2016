<?php
	include 'lib/init.php';

	/**
	 * Initialisation 
	 */
	use Lib\Tool;

	$erreur = array();
	$email = '';

	/**
	 * Formulaire
	 */
	if(isset($_POST['add'])){

		/* Variables de formulaire */
		$email = $_POST['email'];
		$passe = $_POST['passe'];

		/* Messages d'erreur */
		if(empty($email)) array_push($erreur, 'L\'email');
		if(empty($passe)) array_push($erreur, 'Le mot de passe');

		/* Si aucune erreur */
		if(empty($erreur)){

			$sql = $bdd->prepare("SELECT * FROM utilisateur
								  WHERE utilisateurEmail = :email
								  AND utilisateurPasse = :pass ");
			$sql->execute(array(
					'email' => $_POST['email'],
					'pass' => sha1(sha1($_POST['passe']).KEYSHA1)
				));
			$data = $sql->fetchObject();

			/* Si le compte utilisateur n'existe pas */
			if($sql->rowCount() == 0) array_push($erreur,'Votre e-mail ou votre mot de passe est incorrect');
			else{

				/* Si l'utilisateur est bien un administrateur*/
				if(!in_array($data->utilisateurRole, array(1))) array_push($erreur, 'Vous n\'avez pas accès à l\'administration');
				else{

					/* Si le compte utilisateur est actif*/
					if($data->utilisateurEtat == 0) array_push($erreur, 'Votre compte à été désactivé');
					else{

						$_SESSION['utilisateur']['id'] = $data->utilisateurId;
						$_SESSION['role']['id'] = $data->utilisateurRole;

						header('location:'.BASEADMIN.'dashboard/dashboard.php');

						die();

					}

				}

			}

		}

	}

?>
<!doctype html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width; initial-scale=1;">
	<title><?= TITLEBACK ?></title>
	<link rel="icon" type="image/png" href="<?= BASEADMIN ?>img/layout/favicon.png">
	<link href="<?= BASEADMIN ?>css/app.css" rel="stylesheet" type="text/css">
</head>

<body id="connexion">

	<main id="main">

		<div id="connexionContent">

			<a href="<?= BASEADMIN ?>"><img src="<?= BASEADMIN ?>img/layout/logo.png" id="connexionLogo"></a>

			<h1>Connectez-vous pour accéder à l'admin</h1>

			<?php
				if(!empty($erreur)){ Tool::getMessage($erreur, 'erreur'); }
				
				echo Tool::getFlash();
			?>

			<form action="#" method="POST">
				
				<input type="text" name="email" placeholder="Email" value="<?= $email ?>" class="form-elem">
				
				<input type="password" name="passe" placeholder="Mot de passe" class="form-elem">

				<button name="add" type="submit" class="form-submit turquoise">Se connecter</button>
		
			</form>

			<div id="connexionMention">
				<p>© <?= CLIENTNOM ?> - <?= date("Y") ?> | Tous droits réservés.</p>
				<p><a href="<?= BASEADMIN ?>oublie.php">J'ai oublié mon mot de passe</a></p>
			</div>

		</div>
		
	</main>

	<script type="text/javascript" src="<?= BASEFRONT ?>js/jquery/jquery.js"></script>
	<script type="text/javascript" src="<?= BASEADMIN ?>js/app.js"></script>	
	
</body>
</html>