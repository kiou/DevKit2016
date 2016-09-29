<?php
	include 'lib/init.php';

	/**
	 * Initialisation 
	 */
	use Lib\Tool;

	$utilisateurId = Tool::getId($_GET['utilisateur'], BASEADMIN);
	$token = Tool::getString($_GET['token'], BASEADMIN);

	/* Vérifier si il y'a bien une demande en cours */
	$sql = $bdd->prepare("SELECT * FROM utilisateur_oublier
						  WHERE oublierToken = :token
						  AND oublierUtilisateur = :utilisateur ");
	$sql->execute(array(
			'token' => $_GET['token'],
			'utilisateur' => $_GET['utilisateur']
		)
	);

	if($sql->rowCount() == 0){
		Tool::setFlash('Il y\'a aucune demande de réinitialisation de mot de passe pour cet utilistaur','erreur');
		header('location:'.BASEADMIN);
		die();
	}

	$erreur = array();
    $passe = '';
    $confirmation = '';

	/**
	 * Formulaire
	 */
	if(isset($_POST['add'])){

        /**
         * Variables de formulaire
         */
        $passe = $_POST['passe'];
        $confirmation = $_POST['confirmation'];

        /**
         * Erreurs
         */
        if(empty($passe)) array_push($erreur, 'Le mot de passe');
        if(empty($confirmation)) array_push($erreur, 'La confirmation du mot de passe');

        if(!empty($passe) && !empty($confirmation)){
            if($passe != $confirmation) array_push($erreur, 'Les mots de passe ne correspondent pas');
        }

		/* Si aucune erreur */
		if(empty($erreur)){

			/* Mise à jour de l'utilisateur */
            $sql = $bdd->prepare("UPDATE utilisateur SET 
                                  utilisateurPasse = :passe
                                  WHERE utilisateurId = :utilisateurId ");
            $sql->execute(array(
                    "passe" => sha1(sha1($_POST['passe']).KEYSHA1),
                    "utilisateurId" => $utilisateurId
                )
            );

            /* Mise à jour de la réinitialisation */
            $sql = $bdd->prepare("DELETE FROM utilisateur_oublier
            			          WHERE oublierUtilisateur = :utilisateurId ");
            $sql->execute(array(
                    "utilisateurId" => $utilisateurId
                )
            );

            /* Message flash + redirection */
			Tool::setFlash('Mot de passe réinitialisé avec succès<br>Vous pouvez maintenant vous connecter','succes');
			header('location:'.BASEADMIN);

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

			<h1>Réinitialisation de mot de passe</h1>

			<?php
                if(!empty($erreur)){ Tool::getMessage($erreur, 'erreur'); }
			?>

			<form action="#" method="POST">
				
                <input type="password" name="passe" value="<?php echo $passe ?>" placeholder="Mot de passe" class="form-elem big">

                <input type="password" name="confirmation" value="<?php echo $confirmation ?>" placeholder="Confirmation" class="form-elem big">
				
				<button name="add" type="submit" class="form-submit turquoise">Réinitialiser</button>
		
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