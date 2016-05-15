<?php
	$utilisateurMenu = array('managerUtilisateur.php','addUtilisateur.php','editUtilisateur.php','editPasse.php');
	$parametreMenu = array('managerMenu.php','addMenu.php','editMenu.php');
?>
<nav id="menu">
	
	<div id="menuEntreprise">
		<p>Colocarts</p>
	</div>

	<div id="menuLogo">
		<img src="<?= BASEADMIN ?>img/menu/logo.png">
	</div>

	<a href="<?= BASEADMIN ?>dashboard/dashboard.php" class="menuNav <?= Lib\Menu::getCurrentMenu(array('dashboard.php')) ?>"><i class="fa fa-home"></i> Accueil</a>

	<a href="#" data-nav="utilisateur-menu" class="menuNav <?= Lib\Menu::getCurrentMenu($utilisateurMenu) ?>"> <i class="fa fa-user"></i> Utilisateur <i class="fa fa-angle-right"></i></a>
	<ul id="utilisateur-menu" class="<?= Lib\Menu::getCurrentMenu($utilisateurMenu) ?>">
		<li class="<?= Lib\Menu::getCurrentMenu(array('addUtilisateur.php')); ?>"><a href="<?= BASEADMIN ?>utilisateur/addUtilisateur.php"><i class="fa fa-circle-o"></i> Ajouter un utilisateur</a></li>
		<li class="<?= Lib\Menu::getCurrentMenu(array('managerUtilisateur.php')); ?>"><a href="<?= BASEADMIN ?>utilisateur/managerUtilisateur.php"><i class="fa fa-circle-o"></i> Gestion des utilisateurs</a></li>
	</ul>

	<a href="#" data-nav="parametre-menu" class="menuNav <?= Lib\Menu::getCurrentMenu($parametreMenu) ?>"> <i class="fa fa-cog"></i> Paramètre <i class="fa fa-angle-right"></i></a>
	<ul id="parametre-menu" class="<?= Lib\Menu::getCurrentMenu($parametreMenu) ?>">
		<li class="<?= Lib\Menu::getCurrentMenu(array('addMenu.php')); ?>"><a href="<?= BASEADMIN ?>parametre/addMenu.php"><i class="fa fa-circle-o"></i> Ajouter un menu</a></li>
		<li class="<?= Lib\Menu::getCurrentMenu(array('managerMenu.php')); ?>"><a href="<?= BASEADMIN ?>parametre/managerMenu.php"><i class="fa fa-circle-o"></i> Gestion des menus</a></li>
	</ul>

</nav>