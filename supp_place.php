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
             
    if (isset($_POST['supprimer'])) {
        //ON SUPPRIME UNE PLACE
        $num = intval($_POST['placepark']);
        $sql = $bdd->prepare('DELETE FROM parking_utilisateurs WHERE numplace = :num');
        $sql->execute(array(
                'num'=>$num,
            ))or exit(print_r($sql->errorInfo()));
        
        $reukette = $bdd->prepare('DELETE FROM stationnement WHERE numplace = :num');
        $reukette->execute(array(
                'num'=>$num,
            ))or exit(print_r($reukette->errorInfo()));
         
        $sql->closeCursor();
        $reukette->closeCursor();
        header('Location:parking.php');


    }else header('Location:accueil.php');
?>