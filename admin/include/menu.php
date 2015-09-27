<?php
	$utilisateurMenu = array('managerUtilisateur.php','addUtilisateur.php','editUtilisateur.php');
?>
<nav id="menu">
	
	<div id="menuEntreprise">
		<p>Colocarts</p>
	</div>

	<div id="menuLogo">
		<img src="<?= BASEADMIN ?>img/menu/logo.png">
	</div>

	<a href="<?= BASEADMIN ?>dashboard/dashboard.php" class="menuNav <?= Lib\Tool::getCurrentMenu(array('dashboard.php')) ?>"><i class="fa fa-home"></i> Accueil</a>

	<a href="#" data-nav="utilisateur-menu" class="menuNav <?= Lib\Tool::getCurrentMenu($utilisateurMenu) ?>"> <i class="fa fa-user"></i> Utilisateurs <i class="fa fa-angle-right"></i></a>
	<ul id="utilisateur-menu" class="<?= Lib\Tool::getCurrentMenu($utilisateurMenu) ?>">
		<li class="<?= Lib\Tool::getCurrentMenu(array('addUtilisateur.php')); ?>"><a href="<?= BASEADMIN ?>utilisateur/addUtilisateur.php"><i class="fa fa-circle-o"></i> Ajouter un utilisateur</a></li>
		<li class="<?= Lib\Tool::getCurrentMenu(array('managerUtilisateur.php')); ?>"><a href="<?= BASEADMIN ?>utilisateur/managerUtilisateur.php"><i class="fa fa-circle-o"></i> Gestion des utilisateurs</a></li>
	</ul>

</nav>