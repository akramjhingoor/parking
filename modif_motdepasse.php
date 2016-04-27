<?php

    require ("inc/config.php"); #Connexion a la base (inclusion de la connexion par CLASSE PDO:Statement)
    require 'functions.php';
    session_start();
    if (!isset($_SESSION['numutil']) ){
        header('Location:index.php');
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
                <?php 
                    $erreur = "";
                    if (isset($_POST['changer'])) {
                        //echo "Je suis rentré dans la condition 1"; exit;
                        if (isset($_POST['mdp_now']) && !empty($_POST['mdp_now']) && isset($_POST['mdp_new']) && !empty($_POST['mdp_new']) && isset($_POST['mdp_now']) && !empty($_POST['confirmdp_new'])) {
                            //echo "Je suis rentré dans la condition 2"; exit;
                            $mdp_now = htmlentities(sha1($_POST['mdp_now']));
                            $mdpsession = $_SESSION['motdepasse'];
                            //var_dump($mdp_now); exit;
                            if ($mdp_now == $mdpsession) {
                                //echo "Je suis rentré dans la condition 3"; exit;
                                $mdp_new = htmlentities(sha1($_POST['mdp_new']));
                                $confirmdp_new = htmlentities(sha1($_POST['confirmdp_new']));
                                if ($mdp_new == $confirmdp_new) {
                                    $mdpnum = $_SESSION['numutil'];

                                    //echo $mdp_new;
                                    //echo "Je suis rentré dans la condition 4"; exit;

                                    $sql = $bdd->prepare('UPDATE utilisateurs SET motdepasse = :mdp WHERE numutil= :num');
                                    $sql->execute(array(
                                        'num'=>$mdpnum,
                                        'mdp'=>$mdp_new,
                                        )) or exit(print_r($sql->errorInfo()));
                                    $_SESSION['motdepasse'] = $mdp_new;
                                    $erreur ='<strong>Mot de passe modifié !</strong>';
                                }else $erreur = '<strong>Les mots de passe ne sont pas identiques.</strong>';
                            }else $erreur = '<strong>Erreur sur le mot de passe actuel !</strong>';
                        }else $erreur = '<strong>Erreur de saisie ! Nous n\'avons pas compris votre choix</strong>';
                    }
                ?>
                <form action="modif_motdepasse.php" method="POST">
                    <h3>Modification du Mot de Passe</h3>
                    <?php echo $erreur;?><br/><br/>
                    <label>Mot de passe actuel : </label><input type="password" name="mdp_now" placeholder="*********" /><br/><br/>
                    <label>Nouveau mot de passe : </label><input type="password" name="mdp_new" placeholder="*********" /><br/><br/>
                    <label>Confirmer le nouveau mot de passe : </label><input type="password" name="confirmdp_new" placeholder="*********" /><br/><br/>
                    <input type="submit" name="changer" value="Changer" />
                </form>
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
