<nav id="menu">
	
	<div id="menuEntreprise">
		<p>Colocarts</p>
	</div>

	<div id="menuLogo">
		<img src="<?= BASEADMIN ?>img/menu/logo.png">
	</div>

	<a href="<?= BASEADMIN ?>dashboard/dashboard.php" class="menuNav <?php Lib\Tool::getCurrentMenu(array('dashboard.php')); ?>"><i class="fa fa-home"></i> Accueil</a>

	<a href="<?= BASEADMIN ?>utilisateur/managerUtilisateur.php" class="menuNav <?php Lib\Tool::getCurrentMenu(array('information.php')); ?>"><i class="fa fa-user"></i> Utilisateurs</a>

</nav>