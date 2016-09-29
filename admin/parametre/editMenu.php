<?php
	include '../lib/init.php';

	/**
	 * Initialisation
	 */
	use Lib\Utilisateur;
    use Lib\Tool;
    use Lib\Action;
    use Lib\BreadCrumb;

    $menuId = Tool::getId($_GET['menu'],BASEADMIN);

    Utilisateur::ifConnect();
    Action::ifIsset($menuId,'menu',BASEADMIN.'parametre/managerMenu.php',$bdd);

    $succes = array();
    $erreur = array();

    /**
     * Récéption du formulaire
     */
    if(isset($_POST['edit'])){

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
            $sql = $bdd->prepare("UPDATE menu SET 
                                  menuChanged = :changed,
                                  menuNom = :nom,
                                  menuLien = :lien,
                                  menuDestination = :destination 
                                  WHERE menuId = :menuId ");

            $sql->execute(array(
                    'changed' => Tool::dateTime('Y-m-d H:i'),
                    'nom' => $_POST['nom'],
                    'lien' => $_POST['lien'],
                    'destination' => $_POST['destination'],
                    'menuId' => $menuId
                )
            );

            array_push($succes, 'Menu enregistré avec succès');

        }

    }

    /**
     * Informations sur le menu
     */
    $sql = $bdd->query("SELECT * FROM menu
                        WHERE menuId = $menuId ");
    $data = $sql->fetchObject();

    $nom = $data->menuNom;
    $lien = $data->menuLien;
    $destination = $data->menuDestination;
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
				<h1>Modifier le menu  : <?php echo $nom ?></h1>
			</div>

            <?php
                BreadCrumb::add(BASEADMIN,array(
                        'Accueil' => 'dashboard/dashboard.php',
                        'Gestion des menus' => 'parametre/managerMenu.php',
                        'Modifier le menu' => ''
                    )
                );
            ?>

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