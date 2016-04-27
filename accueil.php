<?php

	require ("inc/config.php"); #Connexion a la base (inclusion de la connexion par CLASSE PDO:Statement)
    require 'functions.php';
    session_start();
    if (!isset($_SESSION['numutil']) ){
        header('Location:index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
		
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Parking - Accueil</title>
    </head>
	
    <body>
        <div id="bloc_page">
        <?php require "inc/header.php"; ?>

    	
		<section>
            
			<article>
				<h3>Application Gestion du Parking, comment ça marche ?</h3>
                <p>Combien de fois il a fallu chercher pendant une heure voire plus un endroit où se garer, risquer de se prendre une amende pour stationnement irrégulier. Ainsi, un parking peut devenir un vrai champ de bataille.<br/> "Hey toi salerpilopette, c'était ma place de parking ?" dit une personne<br/>"T'as pas la priorité tabarnak, cherche une autre place" rétorque l'autre.<br/>L'application a vocation de gérer ce problème et d'organiser le parking. Vous êtes utilisateur et vous voulez une place ? Faites une réservation auprès de l'administrateur et il vous attribuera une place. 
                </p>
			</article>
            
		
		</section>

		<?php  require "inc/footer.php";?>
        </div>
    </body>
</html>
