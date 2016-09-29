<?php
	include 'lib/init.php';

	/**
	 * Initialisation 
	 */
	use Lib\Tool;
	use Lib\Mail;

	$erreur = array();
	$succes = array();

	/**
	 * Formulaire
	 */
	if(isset($_POST['add'])){

		/* Variables de formulaire */
		$email = $_POST['email'];

		/* Messages d'erreur */
		if(empty($email)) array_push($erreur, 'L\'email');
		else{
			$sql = $bdd->prepare("SELECT * FROM utilisateur 
								  WHERE utilisateurEmail = :email ");
			$sql->execute(array(
					'email' => $_POST['email']
				)
			);
			if($sql->rowCount() == 0) array_push($erreur, 'Cet utilisateur n\'existe pas');
			else{
				$data = $sql->fetchObject();
				$utilisateurId = $data->utilisateurId;
			}
		}

		/* Si aucune erreur */
		if(empty($erreur)){

			/* Générer un token */
			$token = uniqid(rand(), true);

			$sql = $bdd->prepare("INSERT INTO utilisateur_oublier
								  (oublierCreated, oublierUtilisateur, oublierToken)
								  VALUES 
								  (:created, :utilisateur, :token) ");
			$sql->execute(array(
					'created' => Tool::dateTime('Y-m-d H:i'),
					'utilisateur' => $utilisateurId,
					'token' => $token

				)
			);

			/* Notification email */
			$contenu = '<p>Vous avez demandé une réinitialisation de mot de passe.</p>';
			$contenu .=  '<p>
							Pour terminer la démarche merci de cliquer sur le lien suivant<br>
							<a href="'.BASEADMIN.'reinitialise.php?utilisateur='.$utilisateurId.'&token='.$token.'">réinitialiser mon mot de passe</a>
						 </p>';

			/* Envoyer la notification */
			Mail::sendSimpletHtml(
				'Réinitialisation de mot de passe',
				array('contact@noreply.com'),
				array($email),
				'Réinitialisation de mot de passe',
				$contenu
			);

			array_push($succes, 'Demande de réinitialisation envoyée avec succès à l\'adresse suivante<br><strong>'.$email.'</strong>');

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

			<h1>Demande de réinitialisation de mot de passe</h1>

			<?php
                if(!empty($erreur)){ Tool::getMessage($erreur, 'erreur'); }
                if(!empty($succes)){ Tool::getMessage($succes, 'succes'); }
			?>

			<form action="#" method="POST">
				
				<input type="text" name="email" placeholder="Email" class="form-elem">
				
				<button name="add" type="submit" class="form-submit turquoise">Demande de réinitialisation</button>
		
			</form>

			<div id="connexionMention">
				<p>© <?= CLIENTNOM ?> - <?= date("Y") ?> | Tous droits réservés.</p>
				<p><a href="<?= BASEADMIN ?>">Se connecter</a></p>
			</div>

		</div>
		
	</main>

	<script type="text/javascript" src="<?= BASEFRONT ?>js/jquery/jquery.js"></script>
	<script type="text/javascript" src="<?= BASEADMIN ?>js/app.js"></script>	
	
</body>
</html>