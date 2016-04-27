<?php

	require ("inc/config.php"); #Connexion a la base (inclusion de la connexion par CLASSE PDO:Statement)

?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
		
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Parking - Connexion</title>
    </head>
	
    <body>
        <div id="bloc_page">
        <?php require "inc/header.php"; ?>

    	<?php 
    	$erreur = "";
        //TEST DE CONNEXION
    	if(isset($_POST['Connecter'])){
    		
    		//$mdp = sha1($mdp);
    		if (isset($_POST['email_user']) && isset($_POST['mdp_user']) && !empty($_POST['email_user']) && !empty($_POST['mdp_user'])){
    			
    			$email = htmlentities($_POST['email_user']);
				$mdp = htmlentities($_POST['mdp_user']);
    			$mdp = sha1($mdp);
                $statut = 1;
    			$sql = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = :email AND motdepasse = :mdp AND statut = :statut");
    			$sql->execute(array('email'=>$email, 'mdp'=>$mdp, 'statut'=>$statut));
                $verif = $sql->fetch();
                echo $verif['motdepasse'];echo "<br/>";
                
    			if ($verif)
    			{
    				session_start();
                    $_SESSION['numutil'] = $verif['numutil'];
                    $_SESSION['nomutil'] = $verif['nomutil'];
                    $_SESSION['prenomutil'] = $verif['prenomutil'];
                    $_SESSION['motdepasse'] = $verif['motdepasse'];
                    $_SESSION['dateinscription'] = $verif['dateinscription'];
                    $_SESSION['admin'] = $verif['admin'];
                    header('Location:accueil.php');

    			}else $erreur = "<strong>Vous n'êtes pas présent(e) dans la base de données, ou pas encore validé</strong><br/>";
    		}else $erreur = "<strong>Veuillez saisir les coordonnées de connexion</strong><br/>";
    	} 
    	?>
		<section>
			<article>
				<form action ="index.php" method="POST">
				<h3>Bienvenue sur l'application Parking !</h3>
				<?php  echo $erreur; ?><br/>
    			<label>E-mail : </label> <input type="text" name="email_user" placeholder="Nom d'utilisateur" /><br/><br/>
    			<label>Mot de Passe : </label> <input type="password" name="mdp_user" placeholder="* * * * * *" /><br/><br/>
    			<a href="motdepasserecup.php"></a>
    			<input type="submit" name="Connecter" value ="Se connecter" /><br/><br/>
    			<a href="inscription.php">Pas encore inscrit ?</a>&nbsp &nbsp
    			<a href="mdpoublie.php">Mot de passe oublié ?</a><br/>
                <a href="http://kevingilibert.weebly.com/documentation-utilisateur.html">=== Documentation Utilisateur ===</a>
    			</form>
			</article>
		
		</section>

		<?php  require "inc/footer.php";?>
    </div>
    </body>
</html>
