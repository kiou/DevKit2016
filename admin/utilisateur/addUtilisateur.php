<?php
	include '../lib/init.php';

	/**
	 * Initialisation
	 */
	use Lib\Tool;

	Tool::ifConnect(BASEADMIN);

    $nom = '';
    $prenom = '';
    $email = '';
    $role = '';
    $passe = '';
    $confirmation = '';
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
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $passe = $_POST['passe'];
        $confirmation = $_POST['confirmation'];

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
                                    WHERE utilisateurEmail = '$email' ");
                if($sql->rowCount() != 0) array_push($erreur, 'L\'utilisateur existe déjà');
            }
        }
        if(empty($passe)) array_push($erreur, 'Le mot de passe');
        if(empty($confirmation)) array_push($erreur, 'La confirmation du mot de passe');

        if(!empty($passe) && !empty($confirmation)){
            if($passe != $confirmation) array_push($erreur, 'Les mots de passe ne correspondent pas');
        }

        /**
         * Si aucune erreur alors
         */
        if(empty($erreur)){

            /**
             * Ajout de l'utilisateur en base de donnée
             */
            $sql = $bdd->prepare("INSERT INTO utilisateur
                                  (utilisateurCreated, utilisateurNom, utilisateurPrenom, utilisateurEmail, utilisateurRole, utilisateurPasse) 
                                  VALUES 
                                  (:created, :nom, :prenom, :email, :role, :passe) ");
            $sql->execute(array(
                    'created' => Lib\Tool::dateTime('Y-m-d H:i'),
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST['prenom'],
                    'email' => $_POST['email'],
                    'role' => $_POST['role'],
                    'passe' => sha1(sha1($_POST['passe']).KEYSHA1)
                )
            );

            array_push($succes, 'Utilisateur enregistré avec succès');

            /**
             * Reset des variables
             */
            $nom = '';
            $prenom = '';
            $email = '';
            $role = '';
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
				<h1>Ajouter un utilisateur</h1>
			</div>

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

                    <label>Mot de passe *</label>
                    <input type="password" name="passe" value="<?php echo $passe ?>" class="form-elem big">

                    <label>Confirmation *</label>
                    <input type="password" name="confirmation" value="<?php echo $confirmation ?>" class="form-elem big">

                    <br>

                    <button name="add" type="submit" class="form-submit turquoise medium">Enregister</button>

                </form>

			</div>

		</div>

	</main>

	<script type="text/javascript" src="<?= BASEFRONT ?>js/jquery/jquery.js"></script>
	<script type="text/javascript" src="<?= BASEFRONT ?>js/jquery/jquery-ui.js"></script>
	<script type="text/javascript" src="<?= BASEADMIN ?>js/app.js"></script>	
	
</body>
</html>