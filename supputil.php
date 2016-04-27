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
    ////////////////////////////////////////////////////////////////////////////
    if (isset($_POST['supp'])) {
    	$num = htmlentities(intval($_POST['num']));
    //On supprime de la liste d'attente 
        $supplist = $bdd->prepare("DELETE FROM listedattente WHERE codeclient = :num");
        $supplist->execute(array('num' => $num,))or exit(print_r($supplist->errorInfo()));

    //On le supprime des notifications si présent
        $suppnotif = $bdd->prepare("DELETE FROM notifications WHERE numuser = :num");
        $suppnotif->execute(array('num' => $num,))or exit(print_r($suppnotif->errorInfo()));
    
    //On supprime l'utilisateur
    	$supputil = $bdd->prepare("DELETE FROM utilisateurs WHERE numutil = :num ");
    	$supputil->execute(array('num' => $num,))or exit(print_r($supputil->errorInfo()));
    	header('Location:gestionutil.php');
    }else header('Location:accueil.php');
    
 ?>