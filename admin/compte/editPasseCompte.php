<?php
	include '../lib/init.php';

	/**
	 * Initialisation
	 */
	use Lib\Utilisateur;
	use Lib\Tool;

	Utilisateur::ifConnect();

	$succes = array();
	$erreur = array();
	$utilisateurId = $_SESSION['utilisateur']['id'];
    $passe = '';
    $confirmation = '';

    /**
     * Formulaire
     */
    if(isset($_POST['edit'])){

        /**
         * Variables de formulaire
         */
        $passe = $_POST['passe'];
        $confirmation = $_POST['confirmation'];

        /**
         * Messages d'errreur
         */
        if(empty($passe)) array_push($erreur, 'Le mot de passe');
        if(empty($confirmation)) array_push($erreur, 'La confirmation du mot de passe');
        if( !empty($passe) && !empty($confirmation) ){
            if($passe != $confirmation) array_push($erreur, 'Les mots de passe ne correspondent pas');
        }       

        /**
         * Si aucune erreur, traitement
         */
        if(empty($erreur)){

            $sql = $bdd->prepare("UPDATE utilisateur SET 
                                  utilisateurPasse = :passe
                                  WHERE utilisateurId = $utilisateurId ");
            $sql->execute(array(
                    'passe'=>sha1(sha1($_POST['passe']).KEYSHA1)
                )
            );  

            /* Message de succès*/
            array_push($succes, 'Mot de passe modifié avec succès');

            /* Reset des variables */
            $passe = '';
            $confirmation = '';

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
    <link href="<?= BASEFRONT ?>js/scroll/scroll.css" rel="stylesheet" type="text/css">
	<link href="<?= BASEADMIN ?>css/app.css" rel="stylesheet" type="text/css">
</head>

<body>

	<main id="main">

		<?php
			include '../include/menu.php';
		?>

		<div id="container">

			<?php
				include '../include/header.php';
			?>

			<div id="contentTitre">
				<h1>Mon mot de passe</h1>
			</div>

			<div id="content">

				<?php
					if(!empty($erreur)){ Tool::getMessage($erreur, 'erreur'); }
					if(!empty($succes)){ Tool::getMessage($succes, 'succes'); }
				?>

                <form action="#" method="post">
                    
                    <label>Nouveau mot de passe *</label>
                    <input type="text" name="passe" value="<?php echo $passe ?>" class="form-elem big">
                    
                    <label>Confirmation *</label>
                    <input type="text" name="confirmation" value="<?php echo $confirmation ?>" class="form-elem big">

                    <br>

                    <button name="edit" type="submit" class="form-submit turquoise medium">Enregister</button>

                </form>

			</div>

		</div>

	</main>

	<script type="text/javascript" src="<?= BASEFRONT ?>js/jquery/jquery.js"></script>
	<script type="text/javascript" src="<?= BASEFRONT ?>js/jquery/jquery-ui.js"></script>
    <script type="text/javascript" src="<?= BASEFRONT ?>js/scroll/scroll.js"></script>
	<script type="text/javascript" src="<?= BASEADMIN ?>js/app.js"></script>	
	
</body>
</html>