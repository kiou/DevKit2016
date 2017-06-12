<?php
	include '../lib/init.php';

	/**
	 * Initialisation
	 */
	use Lib\Utilisateur;
	use Lib\Tool;
	use Lib\Search;

	Utilisateur::ifConnect();

    /**
     * Variables de recherche
     */
    if(isset($_POST['addRecherche'])){
        Search::postRecherche('utilisateur');
    }
    extract(Search::getRecherche('utilisateur',array('recherche')));

    /**
     * Variables de pagination
     */
    extract(Tool::initPaginate(50));
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
				<h1>Gestion des utilisateurs</h1>
			</div>

			<div id="content">

                <!-- Recherche -->
                <div id="recherche">

                    <form action="#" method="post">
                        <input type="text" name="recherche" class="form-elem medium" placeholder="Recherche" value="<?php echo $recherche ?>">
                        <button name="addRecherche" type="submit"><i class="fa fa-search"></i></button>
                    </form>

                </div>

                <?= Tool::getFlash() ?>

                <!-- Tableau de gestion -->
                <table class="table">
                    
                    <tr>
                        <th width="70%" class="left">Utilisateur</th>
                        <th width="15%">Rôle</th>
                        <th width="15%" colspan="3">Actions</th>
                    </tr>

                    <?php

                        $requete = "SELECT * FROM utilisateur 
                                    INNER JOIN utilisateur_role ON roleId = utilisateurRole ";
                                    if(!empty($recherche))
                                        $requete .= " WHERE CONCAT(utilisateurNom,utilisateurPrenom) LIKE '%$recherche%' ";
                                    $requete .= " ORDER BY utilisateurId DESC
                                    LIMIT $debut, $nbPage ";

                        $sql = $bdd->query($requete);

                        /**
                         * Si aucun utilisateur
                         */
                        if($sql->rowCount() == 0){
                            echo'<tr><td colspan="5">Aucun utilisateur</td></tr>';
                        }

                        while($data = $sql->fetchObject()){

                            echo'<tr>';

                                /**
                                 * Informations
                                 */
                                echo '<td class="left">';
                                    echo '<p class="tableDate"> Ajout : '.Tool::dateTime('d/m/Y à H:i',$data->utilisateurCreated).'</p>';
                                    if(!is_null($data->utilisateurChanged))
                                        echo'<p class="tableDate">Modification : '.Tool::dateTime('d/m/Y à H:i',$data->utilisateurChanged).'</p>';
                                    echo '<p><strong>'.$data->utilisateurPrenom.' '.$data->utilisateurNom.'</strong></p>';
                                    echo '<p><a href="mailto:'.$data->utilisateurEmail.'">'.$data->utilisateurEmail.'</a></p>';
                                echo'</td>';

                                /* Rôle */
                                echo '<td>';
                                    echo '<p>'.$data->roleNom.'</p>';
                                echo '</td>';

                                /**
                                 * Actions
                                 */
                                if(!$data->utilisateurEtat)
                                    echo'<td data-url="'.BASEADMIN.'utilisateur/publication.php?utilisateur='.$data->utilisateurId.'" class="tablePublucation">
                                            <a href="#" title="Publication"><i class="tableAction rouge fa fa-check"></i></a>
                                        </td>';
                                else
                                    echo'<td data-url="'.BASEADMIN.'utilisateur/publication.php?utilisateur='.$data->utilisateurId.'" class="tablePublucation">
                                            <a href="#" title="Publication"><i class="tableAction turquoise fa fa-check"></i></a>
                                         </td>'; 
                                
                                echo'<td>
                                        <a href="'.BASEADMIN.'utilisateur/editPasse.php?utilisateur='.$data->utilisateurId.'" title="Modifier le mot de passe"><i class="tableAction fa fa-unlock-alt"></i></a>
                                     </td>';

                                echo'<td>
                                        <a href="'.BASEADMIN.'utilisateur/editUtilisateur.php?utilisateur='.$data->utilisateurId.'" title="Modifier l\'utilisauter"><i class=" tableAction fa fa-pencil"></i></a>
                                     </td>';
                           
                            echo'</tr>';

                        }

                    ?>

                </table>

                <!-- Pagination -->
                <div id="pagination">
                        
                    <?php
                        $requete = "SELECT COUNT(utilisateurId) AS total FROM utilisateur ";
                                    if(!empty($recherche))
                                        $requete .= " WHERE CONCAT(utilisateurNom,utilisateurPrenom) LIKE '%$recherche%' ";
                                    
                        Tool::addPaginate($requete,BASEADMIN.'utilisateur/managerUtilisateur',$nbPage,$page);
                    ?>

                </div>

			</div>

		</div>

	</main>

	<script type="text/javascript" src="<?= BASEFRONT ?>js/jquery/jquery.js"></script>
	<script type="text/javascript" src="<?= BASEFRONT ?>js/jquery/jquery-ui.js"></script>
    <script type="text/javascript" src="<?= BASEFRONT ?>js/scroll/scroll.js"></script>
	<script type="text/javascript" src="<?= BASEADMIN ?>js/app.js"></script>	
	
</body>
</html>