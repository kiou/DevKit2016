<?php
    include '../lib/init.php';

    /**
     * Initialisation
     */
    use Lib\Utilisateur;
    use Lib\Tool;
    use Lib\Action;

    $utilisateurId = Tool::getId($_GET['utilisateur']);

    Utilisateur::ifConnect();
    Action::ifIsset($utilisateurId,'utilisateur',BASEADMIN.'utilisateur/managerUtilisateur.php');

    /* L'etat du contenu en cours */
    $sql = $bdd->prepare("SELECT utilisateurEtat FROM utilisateur
                          WHERE utilisateurId = :utilisateurId ");

    $sql->execute(array('utilisateurId' => $utilisateurId));

    $data = $sql->fetchObject();

    /* Changement de l'etat par rapport à celui en base de donnée */
	$etat = $data->utilisateurEtat;
	$etat = !$etat;	

    /* Mise à jour de l'etat */
	$sql = $bdd->prepare("UPDATE utilisateur SET 
                          utilisateurEtat = :etat
		                  WHERE utilisateurId = :utilisateurId ");
    
    $sql->execute(array(
            'etat' => $etat,
            'utilisateurId' => $utilisateurId
        )
    );

    /* Retour du résultat */
    echo $etat;
?>