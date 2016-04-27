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
   //SI LA VARIABLE POST ACC EXISTE
    if (isset($_POST['acc'])) {
    	$num = htmlentities(intval($_POST['num']));
        $statut = 1;
        //ON PASSE LE STATUT DE L'UTILISATEUR A 1
             $placeparking = $bdd->prepare("UPDATE utilisateurs SET statut = :statut WHERE numutil = :num");
                            $placeparking->bindValue(':statut', $statut, PDO::PARAM_INT);
                            $placeparking->bindValue(':num', $num, PDO::PARAM_INT);
                            $placeparking->execute() or exit(print_r($placeparking->errorInfo()));
    	header('Location:gestionutil.php');
    }else header('Location:accueil.php');
    
 ?>
