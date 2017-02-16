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

             $reqmail = $dbh->prepare("SELECT * FROM users WHERE name = ? ");
             $reqmail->execute(array($pseudo));
             $pseudoexist= $reqmail->rowCount();
             if($pseudoexist == 0)
             {
                 if($mdp==$mdp2)
                 {
                     $insertmbr =$dbh->prepare ("INSERT INTO users (name, email, password) VALUES (?, ?, ? ) ");
                     $insertmbr -> execute (array($pseudo, $mail, $mdp));
                     $ok = "Votre compte a été bien crée ! veuillez vous connecter";
                 }
                 else
                 {
                     $erreurs = "vos mot de passe ne sont pas identiques !";
                 }
             }
             else $erreurs ="pseudo déja pris";
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




?>

<html>
    <head>
        <title>connexion </title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/navbar_btn.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/tags_btn.css">
        <link rel="stylesheet" href="login_style.css">

    </head>
    <body>
        <header >
            <div class="navbar">
                <div id="logoandlinks">
                     <a href="index.php" class="logo" style="height:100px;"><img src="img/8gag.png" alt="#header"></a>
                    <?php 
                   
                    if(isset($ok))
                    {
                        echo '<font color="green">'. $ok.'</font>';
                    }
                    ?>
                    <div class="profil"> <img src="" alt="">

                        <!--        image de profil -->
                        <nav class="cl-effect-10">
                            <a href="#" data-hover="Upload"><span>Upload</span></a>

                        </nav>
                    </div>
                </div>
                <hr style="margin:0;border-color: #FF0042;width: 100%;"> </div>

            </div>
        </header>
    <script>
        function myFunction() {
            document.getElementById("demo").innerHTML = "<div style='color:black'>PAS INSCRIT</div>";
        }
    </script>
    <div class="connexion"> 

        <form method="" action="" class="mix">
            <h2>Connexion</h2>
            <br/><?php
            if(isset($erreur))
            {
                echo '<font color="red">'.$erreur.'</font>';
            }
            ?><br/>
            <label >Mail</label>
            <input type="email" name="mailconnect" placeholder="Mail" size=30 required/><br>
            <label >Mot de passe</label>
            <input type="password" name="mdpconnect" placeholder=" mot de passe" size=30 required/><br>
            <input type="submit" name="formconnexion" value="Se connecter"/>
        </form>

        <hr/> 

        <form method="" action="" class="form">
            <h2>Inscription</h2>
            <br/> <?php
            if(isset($erreurs))
            {
                echo '<font color="red">'. $erreurs.'</font>';
            }
            ?><br/>


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
            <input type="submit" value="Je m'inscris" name="forminscription" >

        </form>


    </div>
    <hr class="hr2">
    </body>
</html>
