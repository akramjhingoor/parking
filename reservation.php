<?php

	require ("inc/config.php"); #Connexion a la base (inclusion de la connexion par CLASSE PDO:Statement)
    require 'functions.php';
    session_start();
    if (!isset($_SESSION['numutil']) ){
        header('Location:index.php');
    }
    if ($_SESSION['admin'] != 0) {
        header('Location:accueil.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
		
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Parking - Réservation</title>
    </head>
	
    <body>
        <div id="bloc_page">
        <?php require "inc/header.php"; ?>

    	
		<section>
            
			<article>
                <?php 

                    $erreur ="";
                    if (isset($_POST['reserver'])) {
                        $nbjours = htmlentities($_POST['nbjours']);
                        $datejour = date('Y-m-d');
                        $req = $bdd->query('SELECT COUNT(*) AS nbelements FROM notifications');
                        $verif = $req->fetch();
                        $count = $verif['nbelements']; $count++;
                        $num = $_SESSION['numutil'];
                        $query = $bdd->prepare("SELECT * FROM notifications WHERE numuser = :num");
                        $query->execute(array('num'=>$num,));
                        if (!($donnees = $query->fetch())) 
                        {
                            //ON RESERVE UNE PLACE AVEC LA TABLE NOTIFICATION
                            $sql = $bdd->prepare('INSERT INTO notifications(numnotif, datenotif, nbjours, numuser) VALUES (:count, :datenotif, :nbjours, :num)');
                            $sql->execute(array(
                                    'count'=>$count,
                                    'datenotif'=>$datejour,
                                    'nbjours'=>$nbjours,
                                    'num'=>$num,
                                ))or exit(print_r($sql->errorInfo()));
                            $erreur = '<strong>Réservation enregistré ! Nous allons donner suite à votre demande</strong><br/>';
                        }else $erreur = '<strong>Vous avez déjà fait une réservation</strong><br/>';
                    }

                ?>
				<form action="reservation.php" method="POST">
                    <h3>Faire une réservation</h3>
                    <?php echo $erreur; ?><br/>
                    <label>Nombre de jours : </label><input type="number" name="nbjours" min="1" max="15" required />
                    <input type="submit" name="reserver" value="Réserver" />
                </form>
			</article>
            <aside>
                <h3>Une réservation, comment ça marche ?</h3>
                <p>Le principe est simple. En tant qu'utilisateur et membre de la maison des Ligues, vous pouvez réserver une place de parking pour votre véhicule. L'administrateur s'engage à répondre à votre réservation sous un délai de 4 jours maximum. L'attribution et la date de début seront fixés selon le nombre de jours et les places disponibles du parking. Par exemple, vous faites une demande d'une place de parking pour un délai de 5 jours le 10/01/20XX. La place Alpha est libre. L'administrateur accepte votre réservation le 11/01/20XX et fixe pour la place Alpha un délai de 5 jours à compter du 11/01/20XX soit jusqu'au 16/01/20XX.</p>
            </aside>
		
		</section>

		<?php  require "inc/footer.php";?>
    </div>
    </body>
</html>
