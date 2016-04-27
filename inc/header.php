<header>
	<div id="titre_principal">
		<h2><strong>Application Parking</strong></h2>
	</div>
	<?php 
	if (isset($_SESSION['numutil']) ){
    ?>
	<nav>
    <ul>
		<li><a href="accueil.php">Accueil</a></li>
		
		<?php 
		//ON COMPTE LE NOMBRE DE NOTIFS
		if ($_SESSION['admin']==1) { 
			
			$reukette = $bdd->query("SELECT COUNT(*) AS nbnotifss FROM notifications");
			$raisultat = $reukette->fetch();
			$raisultat = $raisultat['nbnotifss'];
			if($raisultat > 0)
			{
				$nbnotif = $raisultat;
			}
			else { $nbnotif = 0; }
		?>
		<li><a href="gestion.php">Panneau principal (<?php echo $nbnotif; ?>)</a></li>
		<li><a href="parking.php">Parking</a></li>
		<li><a href="gestionutil.php">Utilisateurs</a></li>

	    <?php }else{ ?>
	    <li><a href="profil.php">Profil</a></li>
		<li><a href="reservation.php">Réservation</a></li>
		<?php } ?>
		<li><a href="inc/deconnexion.php">Se déconnecter</a></li>
	</ul>

    <?php    
    }
	?>
	</nav>
</header>
<hr />