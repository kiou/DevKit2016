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

    /**
     * Formulaire
     */
    if(isset($_POST['edit'])){

    	/**
    	 * Variables de formulaire
    	 */
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];

        /**
         * Messages d'erreur
         */
        if(empty($nom)) array_push($erreur, 'Le nom');
        if(empty($prenom)) array_push($erreur, 'Le prénom');
        if(!empty($email)){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) array_push($erreur, 'Le format de l\'email n\'est pas bon');
            else{
                $sql = $bdd->query("SELECT * FROM utilisateur
                                    WHERE utilisateurEmail = '$email'
                                    AND utilisateurId != $utilisateurId ");
                if($sql->rowCount() != 0) array_push($erreur, 'L\'utilisateur existe déjà');
            }
        }else
            array_push($erreur, 'L\'email');

        /**
         * Si aucune erreur, traitement
         */
        if(empty($erreur)){

            $sql = $bdd->prepare("UPDATE utilisateur SET 
                                  utilisateurNom = :nom,
                                  utilisateurPrenom = :prenom,
                                  utilisateurEmail = :email
                                  WHERE utilisateurId = $utilisateurId ");
            $sql->execute(array(
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'email' => $_POST['email']
                )
            ); 

            /* Message de succès */
            array_push($succes, 'Informations modifiées avec succès');

        }
    }

    /**
     * 
     */
    $sql = $bdd->query("SELECT * FROM utilisateur
                        WHERE utilisateurId = $utilisateurId ");
    $data = $sql->fetchObject();

    $nom = $data->utilisateurNom;
    $prenom = $data->utilisateurPrenom;
    $email = $data->utilisateurEmail;
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
				<h1>Mes informations</h1>
			</div>

			<div id="content">

				<?php
					if(!empty($erreur)){ Tool::getMessage($erreur, 'erreur'); }
					if(!empty($succes)){ Tool::getMessage($succes, 'succes'); }
				?>

                <form action="#" method="post">

                    <label class="label">Nom *</label>
                    <input type="text" name="nom" value="<?php echo $nom ?>" class="form-elem big">

                    <label class="label">Prénom *</label>
                    <input type="text" name="prenom" value="<?php echo $prenom ?>" class="form-elem big">

                    <label class="label">E-mail *</label>
                    <input type="text" name="email" value="<?php echo $email ?>" class="form-elem big">

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