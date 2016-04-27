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
        <title>Parking - Profil</title>
    </head>
    
    <body>
        <div id="bloc_page">
        <?php require "inc/header.php"; ?>

        
        <section>
            
            <article>
                <p>Affichage des informations de l'utilisateur</p>
                <?php

                //ON REGARDE SI LUTILSATEUR A UNE PLACE DE PARKING
                $trouve = false;
                $num = $_SESSION['numutil'];
                   
                if (check_pclient($num) == 1){
                    $sql = $bdd->query('SELECT * FROM parking_utilisateurs WHERE numuser = '.$num);
                    $resultat = $sql->fetch();
                    echo 'Votre numéro de place de parking est le n° '.$resultat['numplace'];
                }else{
                
                    echo "Vous n'avez pas de place réservée";
                    echo "<br /><hr /><br />";

                    if (check_attente($num) == 1) {
                        $listedattente = $bdd->query('SELECT * FROM listedattente WHERE codeclient = '.$num);
                        $attente = $listedattente->fetch();
                        echo 'Pour <strong>'.$attente['duree'].' jours</strong>, vous êtes en ';
                        if($attente['position'] == 1)
                            echo $attente['position'].' er';
                        else 
                            echo $attente['position'].' ème';  
                        echo " position";                 
                    }else{
                        echo "Vous n'êtes pas sur liste d'attente";
                    }
                    
                }
            
                ?> <br /><br /><br /> 
            </article>
            <aside>
                <p>
                    <?php echo '<strong>'.$_SESSION['nomutil'].'</strong>'; ?>&nbsp;
                    <?php 
                        echo '<strong>'.$_SESSION['prenomutil'].'</strong><br/>';
                        echo " Inscrit depuis le ";
                        date_maker($_SESSION['dateinscription']);
                        echo '<br/>' ;
                        if ($_SESSION['admin']==1) {
                            echo "Statut : Administrateur";
                        }else echo "Statut : Utilisateur standard";

                    ?>
                    <br/><a href="modif_motdepasse.php">Rectifier son mot de passe</a>
                </p>
            </aside>
        </section>

        <?php  require "inc/footer.php";?>
        </div>
    </body>
</html>
