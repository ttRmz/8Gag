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
            header("Location: a.php");
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
    AND !empty($_GET['mdp']) && !empty($_GET['mdp']))
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
        <title>MyPressePerso </title>
        <meta charset="utf-8">
        <link href="css/connexion.css" rel="stylesheet">
        <link href="css/inscription.css" rel="stylesheet"
              </head>
        <body>
            <div align="center">

                <form method="" action="" class="mix">
                    <h2>Connexion</h2>
                    <br/><br/>
                    <input type="email" name="mailconnect" placeholder="Mail"/>
                    <input type="password" name="mdpconnect" placeholder="Votre mot de passe"/>
                    <input type="submit" name="formconnexion" value="Se connecter"/>
                </form>
                <?php
                if(isset($erreur))
                {
                    echo '<font color="red">'.$erreur.'</font>';
                }
                ?>
                <div align="center">
                    <form method="" action="" class="form">
                        <h2>Inscription</h2>
                        <br/><br/>
                        <table>
                            <tr>
                                <td align="right">
                                    <label for="pseudo">Pseudo </label>
                                </td>
                                <td>
                                    <input type="text" name="pseudo" id="pseudo" placeholder="votre pseudo" class="textbox" value="<?php if(isset($pseudo)) { echo $pseudo;} ?>">
                                </td>
                            </tr>

                            <tr>
                                <td align="right">
                                    <label for="mail">Mail </label>
                                </td>
                                <td>
                                    <input type="email" name="mail" id="mail" placeholder="votre mail" class="textbox" value="<?php if(isset($mail)) { echo $mail;} ?>">
                                </td>
                            </tr>



                            <tr>
                                <td align="right">
                                    <label for="mdp">Mot de passe </label>
                                </td>
                                <td>
                                    <input type="password" name="mdp" id="mdp" placeholder="votre mot de passe" class="textbox">
                                </td>
                            </tr>

                            <tr>
                                <td align="right">
                                    <label for="mdp2">Confirmer votre mot de passe</label>
                                </td>
                                <td>
                                    <input type="password" name="mdp2" id="mdp2" placeholder="confirmer votre mdp" class="textbox">
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td align="center">
                                    <br/>
                                    <input type="submit" value="Je m'inscris" name="forminscription" class="button">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php
                    if(isset($erreurs))
                    {
                        echo '<font color="red">'. $erreurs.'</font>';
                    }
                    ?>
                </div>

                </body>
            </html>
