<?php

    include '../lib/init.php';

    /**
     * Initialisation
     */
    use Lib\Utilisateur;
    use Lib\Tool;
    use Lib\Action;

    $menuId = Tool::getId($_GET['menu'],BASEADMIN);

    Utilisateur::ifConnect();
    Action::ifIsset($menuId,'menu',BASEADMIN.'menu/managerMenu.php');

    $sql = $bdd->prepare("DELETE FROM menu
                          WHERE menuId = :menuId ");
    $sql->execute(array(
            'menuId' => $menuId
        )
    );

    /**
     * Message flash et redirection
     */
    Tool::setFlash('Menu supprimé avec succès');
    header('location:'.BASEADMIN.'parametre/managerMenu.php');


?>