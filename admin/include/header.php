<header id="header">

	<div id="headerMobile">
		<span></span>
	</div>

	<a href="<?= BASEFRONT ?>"  title="Accéder au site" target="_blank" id="headerAcces">
		<i class="fa fa-desktop"></i> <?= BASEFRONT ?>
	</a>

	<a href="<?= BASEADMIN.'deco.php' ?>" title="Déconnexion" id="headerDeco">
		<i class="fa fa-power-off"></i>
	</a>

	<div id="headerCompte" class="dropDown">
		<p><?= substr(Lib\Utilisateur::getCurrentUtilisateur()->utilisateurNom,0,1).'.'.Lib\Utilisateur::getCurrentUtilisateur()->utilisateurPrenom ?> <i class="fa fa-angle-right"></i></p>

		<div id="headerCompteMenu" class="dropDownMenu shadow">
			<ul>
				<li><a href="<?= BASEADMIN ?>compte/editCompte.php">Mes informations <i class="fa fa-user"></i></a></li>
				<li><a href="<?= BASEADMIN ?>compte/editPasseCompte.php">Mon mot de passe <i class="fa fa-unlock-alt"></i></a></li>
				<li><a href="<?= BASEADMIN.'deco.php' ?>">Déconnexion <i class="fa fa-power-off"></i></a></li>
			</ul>
		</div>
	</div>

	<div class="clear"></div>
	
</header>