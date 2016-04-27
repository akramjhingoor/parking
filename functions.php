<?php 

//FONCTION POUR MODIFIER L'AFFICHAGE DE LA DATE
function date_maker($baby){

	$babies = explode("-", $baby);
	//Une date est du style Année-Mois-Jour
	$mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
	'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
	echo $babies[2].' '.$mois[$babies[1]-1].' '.$babies[0];
}

//FONCTION POUR SAVOIR SI UNE PLACE EST DISPO
function check_pdispo($num)
{
	require "inc/config.php";
	$chercher = $bdd->query("SELECT * FROM parking_utilisateurs WHERE numplace = ".$num);
	$chercher->execute();
	
	if (!($cb = $chercher->fetch())) { 
		//Place libre
		return 0;
	}
	else{
		//Place occupé;
		return 1;
	}

}
//FONCTION POUR SAVOIR SI UNE PLACE EST OCCUPE PAR UN CLIENT
function check_pclient($num)
{
	require "inc/config.php";
	$chercher = $bdd->query("SELECT * FROM parking_utilisateurs WHERE numuser = ".$num);
	$chercher->execute();
	
	if (!($cb = $chercher->fetch())) { 
		//Aucun place occupéé
		return 0;
	}
	else{
		//Place occupé;
		return 1;
	}

}
//FONCTION POUR SAVOIR SI UN CLIENT EST EN LISTE D'ATTENTE
function check_attente($code)
{
	require "inc/config.php";
	$listedattente = $bdd->prepare('SELECT * FROM listedattente WHERE codeclient = :code');
    $listedattente->bindValue(':code', $code, PDO::PARAM_INT);
    $listedattente->execute();
	
	if (!($cb = $listedattente->fetch())) { 
		//Pas sur liste d'attente
		return 0;
	}
	else{
		//Sur liste d'attente 
		return 1;
	}
}

//FONCTION POUR EFFACER LES NOTIFS
function erase_notif($code)
{

	require "inc/config.php";
	$suppnotifs = $bdd->prepare('DELETE FROM notifications WHERE numuser = :numuser');
	$suppnotifs->execute(array('numuser'=>$code));	
	
}

function spring_cleaning(){
	require 'inc/config.php';
	$tab = array();
	$i = 0;
	$requeteUno = $bdd->query('SELECT * FROM listedattente');
	while ($unos = $requeteUno->fetch()) {
		$tab[$i] = $unos['numliste'].'/'.$unos['position'].'/'.$unos['duree'].'/'.$unos['codeclient'];
		$i++;	
	}
	
	$DELETE = $bdd->query('DELETE FROM listedattente');
	$cpt = count($tab);
	$cpt++;
	for ($i=0; $i < $cpt; $i++) { 
		
		list($numliste, $position, $duree, $codeclient) = explode("/", $tab[$i]);
		if ($numliste == '1'){
			$insert = $bdd->prepare('INSERT INTO listedattente(numliste, position, duree, codeclient) VALUES (:num, :pos, :duree, :code)');
			$insert->execute(array(
				'num'=>$numliste,
				'pos'=>$position-1,
				'duree'=>$duree, 
				':code'=>$codeclient,
			));
			$insert->closeCursor();	
		}else{
			$insert = $bdd->prepare('INSERT INTO listedattente(numliste, position, duree, codeclient) VALUES (:num, :pos, :duree, :code)');
			$insert->execute(array(
				'num'=>$numliste-1,
				'pos'=>$position-1,
				'duree'=>$duree, 
				':code'=>$codeclient,
			));
			$insert->closeCursor();	
			
		}
		//return $numliste.'!'.$position.'!'. $duree.'!'.$codeclient;
	}

	//return $tab;
}

?>