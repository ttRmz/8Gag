<?php

require 'connect.php';

if(isset($_GET['formconnexion']))
{
    $mailconnect = $_GET['mailconnect'];
    $mdpconnect = $_GET['mdpconnect'];
    if(!empty($mailconnect) && !empty($mdpconnect) )
    {
        $mailconnect = htmlspecialchars($_GET['mailconnect']);
        $mdpconnect = sha1($_GET['mdpconnect']);

        $requser = $dbh->prepare("SELECT * FROM user WHERE email = ? AND password = ? ");
        $requser->execute(array($mailconnect, $mdpconnect));


        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            $userinfo = $requser->fetchALL();
            $_SESSION['id'] = $userinfo[0]['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            $_SESSION['connected'] = true;
            header("Location: index.php");
        }
        else
        {
            $erreur = "Mauvais mail ou mot de passe incorrect !";
        }
    }
    else
    {
        $erreur = "Tous les champs doivent être complétés !";
    }
}

if (isset($_GET['forminscription']))
{ $pseudo = htmlspecialchars($_GET['pseudo']);
 $mail = htmlspecialchars($_GET['mail']);
 $mdp = sha1($_GET['mdp']);
 $mdp2 = sha1($_GET['mdp2']);

 if(!empty($_GET['pseudo']) && !empty($_GET['mail']) 
    AND !empty($_GET['mdp']) && !empty($_GET['mdp2']))
 {

     if(filter_var($mail, FILTER_VALIDATE_EMAIL ))
     {

         $reqmail = $dbh->prepare("SELECT * FROM user WHERE mail = ? ");
         $reqmail->execute(array($mail));
         $mailexist= $reqmail->rowCount();
         if($mailexist==0)
         {


             if($mdp==$mdp2)
             {
                 $insertmbr =$dbh->prepare ("INSERT INTO user (name, email, password) VALUES (?, ?, ? ) ");
                 $insertmbr -> execute (array($pseudo, $mail, $mdp));
                 $erreurs = "Votre compte a été bien crée ! veuillez vous connecter";
             }
             else
             {
                 $erreurs = "vos mot de passe ne sont pas identiques !";
             }
         }
         else {
             $erreurs = "Adresse mail déjà utilisée !";
         }
     }
     else
     {
         $erreurs = "Votre adresse mail n'est pas valide !";
     }
 }

 else
 {
     $erreurs = "tous les champs doivent être complétés !";
 }
}

?>

<html>
    <head>
        <title>connexion </title>
        <meta charset="utf-8">

                <link rel="stylesheet" href="login_style.css">

    </head>
    <body>
          <div class="connexion"> 

            <form method="" action="" class="mix">
                <h2>Connexion</h2>
                <br/><br/>
                <label >Mail</label>
                <input type="email" name="mailconnect" placeholder="Mail" size=30 required/><br>
                <label >Mot de passe</label>
                <input type="password" name="mdpconnect" placeholder=" mot de passe" size=30 required/><br>
                <input type="submit" name="formconnexion" value="Se connecter"/>
              </form>
            <?php
            if(isset($erreur))
            {
                echo '<font color="red">'.$erreur.'</font>';
            }
            ?>
            <hr/> 
            
                <form method="" action="" class="form">
                    <h2>Inscription</h2>
                    <br/><br/>


                    <label >Pseudo </label>
                    <input type="text" name="pseudo" id="pseudo" placeholder=" pseudo" class="textbox" required>
                    <br>
                    <label >Mail </label>

                    <input type="email" name="mail" id="mail" placeholder="mail" class="textbox" >
                    <br>
                    <label >Mot de passe </label>
                    <input type="password" name="mdp" id="mdp" placeholder=" mot de passe" class="textbox">
                    <br>
                    <label for="mdp2">Confirmer mot de passe</label>

                    <input type="password" name="mdp2" id="mdp2" placeholder="confirmer mot de passe" class="textbox">

                    <br/>
                    <input type="submit" value="Je m'inscris" name="forminscription" class="button">

                </form>
                <?php
                if(isset($erreurs))
                {
                    echo '<font color="red">'. $erreurs.'</font>';
                }
                ?>
            
        </div>
            <hr class="hr2">
            </body>
        </html>
