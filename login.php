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

        $requser = $dbh->prepare("SELECT * FROM users WHERE email = ? AND password = ? ");
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

         $reqmail = $dbh->prepare("SELECT * FROM users WHERE mail = ? ");
         $reqmail->execute(array($mail));
         $mailexist= $reqmail->rowCount();
         if($mailexist==0)
         {
             if(strlen($pseudo)>=3)
             {

                 $reqmail = $dbh->prepare("SELECT * FROM users WHERE name = ? ");
                 $reqmail->execute(array($pseudo));
                 $pseudoexist= $reqmail->rowCount();
                 if($pseudoexist == 0)
                 {
                     if($mdp==$mdp2)
                     {
                         if(strlen($_GET['mdp'])>=8)
                         {
                         $insertmbr =$dbh->prepare ("INSERT INTO users (name, email, password) VALUES (?, ?, ? ) ");
                         $insertmbr -> execute (array($pseudo, $mail, $mdp));
                         $ok = "Votre compte a été bien crée ! veuillez vous connecter";
                         }
                         else $erreurs = "mot de passe doit être composé de minimum 8 caractère";
                     }
                     else
                     {
                         $erreurs = "vos mot de passe ne sont pas identiques !";
                     }
                 }
                 else $erreurs ="pseudo déja pris";
             }
             else $erreurs ="pseudo doit être composé de minimum 3 caractères";
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

}




?>
    <html>

    <head>
        <title>connexion </title>
        <meta charset="utf-8">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link rel="stylesheet" href="css/navbar_btn.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/tags_btn.css">
        <link rel="stylesheet" href="css/login_style.css"> </head>

    <body>
        <header>
            <div class="navbar">
                <div id="logoandlinks">
                    <a href="index.php" class="logo" style="height:100px;"><img src="img/8gag.png" alt="#header"></a>
                    <?php 

                    if(isset($ok) )
                    {
                        echo '<font color="green">'.$ok.'</font>';
                    }
                    ?> </div>
                <hr class="hhead" /> </div>
            </div>
        </header>
        <div class="corps">
            <div class="box">
                <div class="connexion" style="color:white;font-family:lato;">
                    <form method="" action="" class="mix">
                        <h2 style="color:green;">Login</h2>
                        <br/>
                        <?php
                    if(isset($erreur))
                    {
                        echo '<font color="red">'.$erreur.'</font>';
                    }
                    ?>
                            <br/>
                            <label>Email</label>
                            <input type="email" name="mailconnect" placeholder="Your Eamil" size=30 required/>
                            <br>
                            <label>Password</label>
                            <input type="password" name="mdpconnect" placeholder="Your Password" size=30 required/>
                            <br>
                            <input type="submit" name="formconnexion" value="Login" /> </form>
                    <hr class="hr1" />
                    <form method="" action="">
                        <h2 style="color:green;">Register</h2>
                        <br/>
                        <?php
                    if(isset($erreurs))
                    {
                        echo '<font color="red">'. $erreurs.'</font>';
                    }
                    ?>
                            <br/>
                            <label>Name </label>
                            <input type="text" name="pseudo" id="pseudo" placeholder="Your Name" class="textbox" required>
                            <br>
                            <label>Email </label>
                            <input type="email" name="mail" id="mail" placeholder="Your Email" class="textbox">
                            <br>
                            <label>Password </label>
                            <input type="password" name="mdp" id="mdp" placeholder="Your Password" class="textbox">
                            <br>
                            <label for="mdp2">Confirm Password</label>
                            <input type="password" name="mdp2" id="mdp2" placeholder="Confirm Password" class="textbox">
                            <br/>
                            <input type="submit" value="Register" name="forminscription"> </form>
                </div>
                <hr class="hr2"> </div>
        </div>
    </body>

    </html>