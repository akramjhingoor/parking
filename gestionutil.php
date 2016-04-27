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
        <title>Parking - Gestion du Parking</title>
    </head>
    
    <body>
        <div id="bloc_page">
        <?php require "inc/header.php"; ?>

        
        <section>
            <article>
                <h3>Liste des utilisateurs : </h3>
                <table border="3">
                    <tr>
                        <th width="10%">Nom</th>
                        <th width="15%">Prénom</th>
                        <th width="25%">E-mail</th>
                        <th width="25%">Date d'inscription</th>
                        <th width="20%">Statut</th>
                        <th width="20%">Supprimer</th>
                        <th width="20%">Valide</th>
                    </tr>
                <?php
                //ON AFFICHE LES UTILISATEURS
                    $users = $bdd->query("SELECT * FROM utilisateurs WHERE admin = 0"); 
                    while ($datas = $users->fetch()) {
                        ?>
                    <tr>
                        <td><?php echo $datas['nomutil'];?></td>
                        <td><?php echo $datas['prenomutil'];?></td>
                        <td><?php echo $datas['email'];?></td>
                        <td><?php date_maker($datas['dateinscription']); ?></td>
                        <td><?php if($datas['admin'] == 1){ echo "Administrateur";}else{ echo "Utilisateur Lambda";}?></td>
                        <td><form action="supputil.php" method="POST"><input type="submit" name="supp" class="btn" value="Supprimer"/><input type="hidden" name="num" value="<?php echo $datas['numutil']; ?>"></form></td>
                        <td>

                           <?php
                            if ($datas['statut'] == 1)
                                echo "Oui";
                            else
                            {
                              ?>  <form action="accutil.php" method="POST"><input type="submit" name="acc" class="btn" value="Accepter"/><input type="hidden" name="num" value="<?php echo $datas['numutil']; ?>"></form></td>
                           <?php }




                            ?>

                        </td>
                    </tr>    
                <?php
                    }$users->closeCursor();
                ?>

            </table>
            </article>
            
        </section>
        <?php  require "inc/footer.php";?>
        </div>
    </body>
</html>
