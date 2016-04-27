<?php

    require ("inc/config.php"); #Connexion a la base (inclusion de la connexion par CLASSE PDO:Statement)
    require 'functions.php';
    session_start();
    if (!isset($_SESSION['numutil']) ){
        header('Location:index.php');
    }
    if ($_SESSION['admin'] != 1) {
        header('Location:accueil.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Parking - Attribution de place</title>
    </head>
    
    <body>
        <div id="bloc_page">
        <?php require "inc/header.php"; ?>

        <?php 
        erase_notif($_GET['client']); // ON SUPPRIME LA NOTIF AVEC LA FONCTION PERSO
            if (isset($_GET['client']) && is_numeric($_GET['client']) && isset($_GET['nbjours']) && is_numeric($_GET['nbjours'])) {
                
                if($_GET['nbjours'] < 16 || $_GET['nbjours'] > 0){
                    //On recupère la valeur dans l'URL
                    $client = intval($_GET['client']);
                    $nbjours = intval($_GET['nbjours']);

                }else header('Location:gestion.php');
                
            }else header('Location:gestion.php'); 
        ?>
        <section>
            <article>
                <?php 
                    $erreur="";
                    if (isset($_POST['attribuer'])) {
                        if (isset($_POST['datedeb']) && !empty($_POST['datedeb'])) {
                            $nbjours = $_POST['nbjours'];
                            
                            //ON SECURISE LES VARIABLES
                            $choix = htmlentities(intval($_POST['choixplace']));
                            $nbrjours = htmlentities(intval($_POST['nbjours']));
                            $datedeb = htmlentities($_POST['datedeb']);
                            $client = htmlentities($_POST['codeclient']);
                            //On ajoute à la date choisi le nbjours pour l'écheance
                            list($annee, $mois, $jour) = explode("-", $datedeb);
                            $datecheance = date('Y-m-d', mktime(0,0,0, $mois, $jour+$nbrjours, $annee));

                            //ON MET A JOUR LES TABLES
                            $placeparking = $bdd->prepare("UPDATE stationnement SET datedebut = :datedeb, echeance = :echeance WHERE numplace = :num");
                            $placeparking->execute(array(
                                'datedeb'=>$datedeb,
                                'echeance'=>$datecheance,
                                'num'=>$choix,
                                )) or exit(print_r($placeparking->errorInfo()));

                            $parking_utilisateurs = $bdd->prepare('INSERT INTO parking_utilisateurs(numplace, numuser) VALUES (:place, :user)');
                            $parking_utilisateurs->execute(array(
                                'place'=>$choix,
                                'user'=>$client,
                                )) or exit(print_r($parking_utilisateurs->errorInfo()));

                            if (check_attente($client) == 1) {
                                //On le supprime sur la liste d'attente si présent
                                $suppattente = $bdd->prepare("DELETE FROM listedattente WHERE codeclient = :num");
                                $suppattente->execute(array('num' => $client,))or exit(print_r($suppattente->errorInfo()));
                            }

                            $erreur = '<strong>Place attribué avec succès !</strong><br/>';
                            header('Location:gestion.php');
                           }else $erreur = '<strong>Il faut une date de départ</strong><br/>';   
                    }
                ?>
                <form action="attrib_place.php?client=<?php echo $client; ?>&nbjours=<?php echo $nbjours; ?>" method="POST">
                    <h3>Attribution de places : </h3>
                    <?php echo $erreur; ?><br/>
                
                    <label>Choisir la place à attribuer : </label>
                    <?php 
                        $reukette = $bdd->query("SELECT * FROM stationnement WHERE datedebut = '0000-00-00'");
                        echo "<select name ='choixplace'>";
                        while ($donnees = $reukette->fetch()) {
                             echo "<option>".$donnees['numplace'];
                         } 
                        echo "</select><br/><br/>"; 
                    ?>
                    <label>Nombre de jours : </label><input type="number"  name="nbjours" value="<?php echo $nbjours; ?>" /><br/><br/>

                    <input type="hidden" name="nombresjours" value="<?php echo $nbjours; ?>" />



                    <label>Date de début : </label><input type="date" name="datedeb" /><br/><br/>
                    <input type="hidden" name="codeclient" value="<?php echo $client; ?>" />
                    <input type="submit" value="Attribuer" name="attribuer" />
                </form>               
                <hr/>
              
                <h3>Places de Parking : </h3>
                <table border="3">
                    <tr>
                        <th>Numéro de la place</th>
                        <th>Date de Début</th>
                        <th>Date de Fin</th>
                        <th>Statut de la Place</th>
                        <th>Occupée par</th>
                    </tr>
                    <?php 
          
                      $parking = $bdd->query('SELECT * FROM stationnement');
                      //$elementpres = $presta->fetch();
                      
                      
                      while ($places = $parking->fetch()) 
                      {
                      
                    ?>
                    <tr>

                        <td><?php echo $places['numplace']; ?></td>
                        <td>
                            <?php 
                            if($places['datedebut'] == '0000-00-00'){
                                echo "-";
                                }else { date_maker($places['datedebut']); }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if($places['echeance'] == '0000-00-00'){
                                echo "-";
                                }else { echo date_maker($places['echeance']); }
                            ?>
                        </td>
                        
                        <?php 
                            //SAVOIR SI UNE PLACE EST DISPO
                            if(check_pdispo($places['numplace']) == 1){
                                $busy = $bdd->query('SELECT * FROM parking_utilisateurs WHERE numplace = '.$places['numplace']);
                                $busies = $busy->fetch();
                        ?>
                        <td>Occupée</td>
                        <td>
                        <?php 
                                $who = $bdd->query('SELECT nomutil FROM utilisateurs WHERE numutil = '.$busies['numuser']);
                                if($who){
                                $whos = $who->fetch();
                                echo $whos['nomutil'];
                                }
                            
                        ?>                    
                        </td>
                        <?php 
                            }else{
                        ?>
                        <td>Libre</td>
                        <td> - </td>
                        <?php
                            }
                        ?>
                        
                    </tr>
                <?php 
                 } ?>
            </table>
            
            </article>
            
        </section>

        <?php require "inc/footer.php";?>
        </div>
    </body>
</html>
