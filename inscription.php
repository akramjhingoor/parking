<?php
//PAGE D'INSCRIPTION

	require ("inc/config.php");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css">
        <title>Parking - Inscription</title>
    </head>
	
    <body>
    	<div id="bloc_page">
   		<?php require 'inc/header.php';?>
		<section>
			<?php 
	    	$erreur = "";
	    	$verite = false;
	    				
	    	if(isset($_POST['Inscrire'])){
	    		
	    		//$mdp = sha1($mdp);
	    		if (isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prenom']) && !empty($_POST['prenom']) && isset($_POST['mdp']) && !empty($_POST['mdp']) && isset($_POST['confirm_mdp']) && !empty($_POST['confirm_mdp']) && isset($_POST['email']) && !empty($_POST['email']) ){
	    			
	    			$nom = htmlentities(mb_strtoupper($_POST['nom']));
					$prenom = htmlentities($_POST['prenom']);
					$mdp = htmlentities($_POST['mdp']);
					$confirm_mdp = htmlentities($_POST['confirm_mdp']);
					$email = htmlentities($_POST['email']);
										    		
					//TEST SI LE MDP FAIT PLUS DE 5 CACARACTERES 
	    			if (strlen($mdp) >= 5 || strlen($confirm_mdp) >= 5 ){
	    				if($mdp==$confirm_mdp){
	    					$mdp = sha1($mdp);
	    					//var_dump($mdp); exit;
	    					$compter = $bdd->query("SELECT COUNT(*) AS nbutils FROM utilisateurs");
	    					$occurence = $compter->fetch();
	    					$count = $occurence['nbutils'];
	    					$count++;
	    					$date = date("Y-m-d");
	    					$email = $email.'@m2l.fr';
	    					


	    					//SI MEMBRE 
							
						    	$sql = $bdd->prepare("INSERT INTO utilisateurs(numutil, nomutil, prenomutil, email, motdepasse, dateinscription, admin, statut) 
						    	VALUES(:num, :nom, :prenom, :email, :mdp, :dateinscription, :admin, :statut)");
						    	$sql->execute(array(
						    	'num'=>$count,
						    	'nom'=>$nom,
						    	'prenom'=>$prenom,
						    	'email'=>$email,
						    	'mdp'=>$mdp,
						    	'dateinscription'=>$date,
						    	'admin'=> 0,
						    	'statut'=>0,
						    	))or exit(print_r($sql->errorInfo()));
						    	$erreur = '<strong>Nouveau Membre enregistré ! Bienvenue '.$prenom. ' '.$nom.'</strong><br/>';
						    	
						    	}else $erreur = "<strong>Les mots de passe ne sont pas identiques</strong><br/>"; 
						    	}else $erreur = "<strong>Pour des questions de sécurité, saississez un mot de passe plus long</strong><br/>";
						    	}else $erreur = "<strong>Tous les champs doivent être remplis</strong><br/>";
						    }

	    	?>
			<article>
				<form action="inscription.php" method="POST">
					
					<h3>Inscription à l'application Parking</h3><br/>
					<?php  echo $erreur; ?><br/>
					<label> Nom </label> : <input type="text" name="nom" placeholder="Skshh" maxlength="20"/><br/><br/>
					<label> Prénom </label> : <input type="text" name="prenom" placeholder="Jean-Luc" maxlength="20"/><br/><br/>
					<label> Email </label> : <input type="text" name="email" placeholder="jeanluc" maxlength="20"/>&nbsp;&nbsp;&nbsp;<input type="text" value="@m2l.fr" disabled /><br/><br/>
					<label> Mot de Passe </label> : <input type="password" name="mdp" placeholder="*****" maxlength="30"/><br/><br/>
					<label> Confirmer son mot de passe </label> : <input type="password" name="confirm_mdp" placeholder="*****"  maxlength="30"/><br/><br/>
					
					<input type="reset" name="bouton_reset" />
					<input type="submit" name="Inscrire" value="S'inscrire" /><br/><br/>
				
				</form>
				<a href="index.php">Retournez à l'accueil</a>	
			</article>
		</section>

		<?php  require "inc/footer.php";?>
		</div>
    </body>
</html>
