<?php
	include '../lib/init.php';

	/**
	 * Initialisation
	 */
	use Lib\Tool;

	Tool::ifConnect(BASEADMIN);

    $nom = '';
    $lien = '';
    $destination = 1;
    $succes = array();
    $erreur = array();

    /**
     * Formulaire
     */
    if(isset($_POST['add'])){

        /**
         * Variables de formulaire
         */
        $nom = $_POST['nom'];
        $lien = $_POST['lien'];
        $destination = $_POST['destination'];

        /**
         * Erreurs
         */
        if(empty($nom)) array_push($erreur, 'Le nom');
        if(empty($lien)) array_push($erreur, 'Le lien');
        else
            if(!filter_var($lien, FILTER_VALIDATE_URL) && !$destination) array_push($erreur, 'Le format du lien n\'est pas bon');

        /**
         * Si aucune erreur alors
         */
        if(empty($erreur)){

            /**
             * Ajout de l'utilisateur en base de donnée
             */
            $sql = $bdd->prepare("INSERT INTO menu
                                  (menuCreated, menuNom, menuLien, menuDestination)
                                  VALUES 
                                  (:created, :nom, :lien, :destination) ");

            $sql->execute(array(
                    'created' => Tool::dateTime('Y-m-d H:i'),
                    'nom' => $_POST['nom'],
                    'lien' => $_POST['lien'],
                    'destination' => $_POST['destination']
                )
            );

            array_push($succes, 'Menu enregistré avec succès');

            /**
             * Reset des variables
             */
            $nom = '';
            $lien = '';
            $destination = 1;

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
				<h1>Ajouter un menu</h1>
			</div>

			<div id="content">

                <?php
                    if(!empty($erreur)){ Tool::getMessage($erreur, 'erreur'); }
                    if(!empty($succes)){ Tool::getMessage($succes, 'succes'); }
                ?>

                <form action="#" method="post">
                    
                    <label>Nom *</label>
                    <input type="text" name="nom" value="<?php echo $nom ?>" class="form-elem big">

                    <label>Déstination</label>
                    <div class="form-radio">
                        <p>
                            <input type="radio" name="destination" value="1" <?php if($destination) echo'checked'; ?> > Interne 
                            <input type="radio" name="destination" value="0" <?php if(!$destination) echo'checked'; ?>> Externe
                        </p>
                    </div>

                    <label>Lien *</label>
                    <input type="text" name="lien" value="<?php echo $lien ?>" class="form-elem big">
                    <div class="form-legende">
                        Interne : uniquement la fin de l'url ex : actualite/une-actualite<br>
                        Externe : n'oubliez pas le <strong>http://</strong>
                    </div>

                    <br>

                    <button name="add" type="submit" class="form-submit turquoise medium">Enregister</button>

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