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

    /**
     * Récéption du formulaire
     */
    if(isset($_POST['edit'])){

        /**
         * Variables de formulaire
         */
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        /**
         * Erreurs
         */
        if(empty($nom)) array_push($erreur, 'Le nom');
        if(empty($prenom)) array_push($erreur, 'Le prenom');
        if(empty($role)) array_push($erreur, 'Le rôle');
        if(empty($email)) array_push($erreur, 'L\'email');
        else{
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) array_push($erreur, 'Le format de l\'email n\'est pas bon');
            else{
                $sql = $bdd->query("SELECT utilisateurEmail FROM utilisateur
                                    WHERE utilisateurEmail = '$email'
                                    AND utilisateurId != $utilisateurId ");
                if($sql->rowCount() != 0) array_push($erreur, 'L\'utilisateur existe déjà');
            }
        }

        /**
         * Si aucune erreur alors
         */
        if(empty($erreur)){

            /**
             * Mise à jour de l'utilisateur en base de donnée
             */
            $sql = $bdd->prepare("UPDATE utilisateur SET 
                                  utilisateurChanged = :changed,
                                  utilisateurNom = :nom,
                                  utilisateurPrenom = :prenom,
                                  utilisateurEmail = :email,
                                  utilisateurRole = :role
                                  WHERE utilisateurId = :utilisateurId ");

            $sql->execute(array(
                    'changed' => Tool::dateTime('Y-m-d H:i'),
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'email' => $_POST['email'],
                    'role' => $_POST['role'],
                    'utilisateurId' => $utilisateurId
                )
            );

            array_push($succes, 'Utilisateur enregistré avec succès');

        }

    }

    /**
     * Informations sur l'utilisateur
     */
     $sql = $bdd->query("SELECT * FROM utilisateur
                         WHERE utilisateurId = $utilisateurId ");
     $data = $sql->fetchObject();

     $nom = $data->utilisateurNom;
     $prenom = $data->utilisateurPrenom;
     $email = $data->utilisateurEmail;
     $role = $data->utilisateurRole;
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
				<h1>Modifier l'utilisateur  : <?php echo $nom.' '.$prenom ?></h1>
			</div>

            <?php
                BreadCrumb::add(BASEADMIN,array(
                        'Accueil' => 'dashboard/dashboard.php',
                        'Gestion des utilisateurs' => 'utilisateur/managerUtilisateur.php',
                        'Modifier l\'utilisateur' => ''
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

                    <label>Prenom *</label>
                    <input type="text" name="prenom" value="<?php echo $prenom ?>" class="form-elem big">

                    <label>E-mail *</label>
                    <input type="text" name="email" value="<?php echo $email ?>" class="form-elem big">

                    <label>Rôle *</label>
                    <select name="role" class="form-elem big">
                        
                        <option value="">Choisir le rôle</option>
                        <?php
                            $sql = $bdd->query("SELECT * FROM utilisateur_role
                                                ORDER BY roleNom ASC ");
                            while($data = $sql->fetchObject()){

                                if($data->roleId == $role)
                                    echo'<option value="'.$data->roleId.'" selected>'.$data->roleNom.'</option>';
                                else
                                    echo'<option value="'.$data->roleId.'">'.$data->roleNom.'</option>';

                            }
                        ?>

                    </select>

                    <br>

                    <button name="edit" type="submit" class="form-submit turquoise medium">Enregister</button>

                </form>

			</div>

		</div>

	</main>

	<script type="text/javascript" src="<?= BASEFRONT ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?= BASEFRONT ?>js/jquery-ui.js"></script>
	<script type="text/javascript" src="<?= BASEADMIN ?>js/app.js"></script>	
	
</body>
</html>