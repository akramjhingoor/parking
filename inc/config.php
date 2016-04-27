<?php
try //On essaie une connexion
{
	$bdd = new PDO ('mysql:host=localhost;dbname=parking;charset=utf8', 'root', ''); //Classe PDO on fournit des param pour la connexion

} 
catch(Exception $e) #Si connexion ne marche pas on attrape l'erreur dans une exception et on affiche le msg d'erreur
{
	die('Erreur : '.$e->getMessage());
}
?>