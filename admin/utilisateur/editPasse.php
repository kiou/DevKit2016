<?php
	include '../lib/init.php';

	/**
	 * Initialisation
	 */
    use Lib\Tool;
    use Lib\Action;
    use Lib\BreadCrumb;

    $utilisateurId = Tool::getId($_GET['utilisateur'],BASEADMIN);

    Tool::ifConnect(BASEADMIN);
    Action::ifUtilisateurAdmin($utilisateurId,$bdd);

    $succes = array();
    $erreur = array();
    $passe = '';
    $confirmation = '';

    /**
     * Récéption du formulaire
     */
    if(isset($_POST['edit'])){

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

        /**
         * Si aucune erreur alors
         */
        if(empty($erreur)){

            $sql = $bdd->prepare("UPDATE utilisateur SET 
                                  utilisateurPasse = :passe
                                  WHERE utilisateurId = :utilisateurId ");
            $sql->execute(array(
                    "passe" => sha1(sha1($_POST['passe']).KEYSHA1),
                    "utilisateurId" => $utilisateurId
                )
            );

            array_push($succes, 'Mot de passe modifé avec succès');

            /**
             * Reset des variables
             */
            $passe = '';
            $confirmation = '';

        }

    }

    /**
     * Informations sur l'utilisateur
     */
     $sql = $bdd->query("SELECT utilisateurNom, utilisateurPrenom FROM utilisateur
                         WHERE utilisateurId = $utilisateurId ");
     $data = $sql->fetchObject();

     $nom = $data->utilisateurNom;
     $prenom = $data->utilisateurPrenom;
?>
<!doctype html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width; initial-scale=1;">
	<title><?= TITLEBACK ?></title>
	<link rel="icon" type="image/png" href="<?= BASEADMIN ?>img/layout/favicon.png">
	<link href="<?= BASEADMIN ?>css/app.css" rel="stylesheet" type="text/css">
	<!--[if lt IE 9]>
		<script src="<?= BASEFRONT ?>js/html5.js"></script>
	<![endif]-->
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
				<h1>Modifier le mot de passe de : <?php echo $prenom.' '.$nom ?></h1>
			</div>

            <?php
                BreadCrumb::add(BASEADMIN,array(
                        'Accueil' => 'dashboard/dashboard.php',
                        'Gestion des utilisateurs' => 'utilisateur/managerUtilisateur.php',
                        'Modifier le mot de passe' => ''
                    )
                );
            ?>

			<div id="content">

                <?php
                    if(!empty($erreur)){ Tool::getMessage($erreur, 'erreur'); }
                    if(!empty($succes)){ Tool::getMessage($succes, 'succes'); }
                ?>

                <form action="#" method="post">
                    
                    <label>Mot de passe *</label>
                    <input type="password" name="passe" value="<?php echo $passe ?>" class="form-elem big">

                    <label>Confirmation *</label>
                    <input type="password" name="confirmation" value="<?php echo $confirmation ?>" class="form-elem big">

                    <br>

                    <button name="edit" type="submit" class="form-submit turquoise medium">Enregister</button>

                </form>

			</div>

		</div>

	</main>

	<script type="text/javascript" src="<?= BASEFRONT ?>js/jquery/jquery.js"></script>
	<script type="text/javascript" src="<?= BASEFRONT ?>js/jquery/jquery-ui.js"></script>
	<script type="text/javascript" src="<?= BASEADMIN ?>js/app.js"></script>	
	
</body>
</html>