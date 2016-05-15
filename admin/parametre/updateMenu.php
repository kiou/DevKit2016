<?php
    include '../lib/init.php';

    /**
     * Initialisation
     */
    use Lib\Tool;

    Tool::ifConnect(BASEADMIN);
    
    /* Mise à jour du menu */
    if(isset($_POST['data'])){
    
        /* Parcourir le tableau */
        $count = 1;
        foreach ($_POST['data'] as $menu) {
    
            /* Mise à jour du mennu en base de donnée */
            $sql = $bdd->prepare("UPDATE menu SET
                                  menuParent = :parent ,
                                  menuPoid = :poid
                                  WHERE menuId = :menuId ");
            $sql->execute(array(
                    'parent' => $menu['parent_id'],
                    'poid' => $count,
                    'menuId' => $menu['id']
                )
            );

            $count ++;

        }

    }
?>