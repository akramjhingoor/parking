<?php 
session_start();
session_unset();
session_destroy(); //on efface toutes les variables sessions.
header('Location:../index.php');

?>