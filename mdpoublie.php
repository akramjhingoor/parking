<?php

	require ("inc/config.php"); #Connexion a la base (inclusion de la connexion par CLASSE PDO:Statement)
    require 'functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
		
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Parking - Mot de passe oublié</title>
    </head>
	
    <body>
        <div id="bloc_page">
        <?php require "inc/header.php"; ?>

    	
		<section>
            
			<article>
                <form action ="mdpoublie.php" method="POST">
                <h3>Mot de passe oublié !</h3>
                <p>Veuillez saisir votre adresse e-mail</p>
                <label>E-mail : </label> <input type="text" name="email" placeholder="test@m2l.fr" /><br/><br/>
                <a href="motdepasserecup.php"></a>
                <input type="submit" name="Envoyer" value ="Envoyer" /><br/><br/>
                 <br />
          <br / >
          <p><a href="index.php">Retournez à la page d'accueil ?</a></p>
                </form>
			</article>
            <?php
            if (isset($_POST['Envoyer']))
            {
                $trouve = false;
                $email = htmlentities($_POST['email']);
                        //ON REGARDE SI LEMAIL EST DANS LA BASE DE DONNEES
                                $req = $bdd->query('SELECT * FROM utilisateurs');
                                while($donnees = $req->fetch())
                                {
                                    if($donnees['email'] == $email)
                                    {
                                        $trouve = true;
                                    }
                                }
                if ($trouve == true)
                    echo "Un e-mail vous a été envoyé";
                else
                    echo "Vous n'êtes pas inscrit sur notre application";
            }
		  ?>

          
		</section>

		<?php  require "inc/footer.php";?>
        </div>
    </body>
</html>
