<?php

require 'connect.php';

if (!$_SESSION['connected']) {
    // l'utilisateur n'est pas connecté
    header('Location:login.php');
}
$requete = $dbh->prepare('SELECT * FROM users WHERE id = :id');
$requete->execute([':id' => $_SESSION['id']]);
$result = $requete->fetchAll();


if (isset($_GET['send']) ) {

    if(empty($_GET['password']) && empty($_GET['passwords']) && !empty($_GET['name'])&& !empty($_GET['email'])){
        $pseudo = $_GET['name'];
        if(strlen($pseudo)>=3){
        $requete = $dbh->prepare('UPDATE users SET name = :name, email = :email WHERE id = :id');
        $requete->execute([
            ':name' => $_GET['name'],
            ':email' => $_GET['email'],
            ':id' => $_SESSION['id']

        ]);
        echo 'modification faite';
        header("location:account.php");
        }
        else $erreurs = "pseudo doit être composé de minimum 3 caractères";

    }
    elseif(!empty($_GET['password']) && !empty($_GET['passwords']))
    {
        $mdp = sha1($_GET['password']);
        $mdp2 = sha1($_GET['passwords']);
        $requser = $dbh->prepare("SELECT * FROM users WHERE password = ? ");
        $requser->execute(array($mdp));
        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            if(strlen($_GET['passwords'])>=8){
            $requete = $dbh->prepare('UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id');
            $requete->execute([
                ':name' => $_GET['name'],
                ':email' => $_GET['email'],
                ':password'=> $mdp2,
                ':id' => $_SESSION['id']

            ]);
            echo 'modification faite';
            header("location:account.php");
            }
            else $erreurs = "password doit être composé de minimum 8 caractères";

        }
        else
        {
            $erreurs = "mot de passe incorrect !";
        }

    }
    else{
        $erreurs ="element manquant";
    }

}

if(isset($_GET['formsuppr']))
{
    $mailconnect = $_GET['mailsuppr'];
    $mdpconnect = $_GET['mdpsuppr'];
    if(!empty($mailconnect) && !empty($mdpconnect) )
    {
        $mailconnect = htmlspecialchars($_GET['mailsuppr']);
        $mdpconnect = sha1($_GET['mdpsuppr']);

        $requser = $dbh->prepare("SELECT * FROM users WHERE email = ? AND password = ? ");
        $requser->execute(array($mailconnect, $mdpconnect));


        $userexist = $requser->rowCount();
        if($userexist == 1)
        {



            $req = $dbh->prepare('DELETE FROM users WHERE id = :id ');
            $req->execute([
                ':id' => $_SESSION['id']]);
            session_destroy();
            header("location:index.php");




        }
        else
        {
            $erreur = "Mauvais mail ou mot de passe incorrect !";
        }
    }
}

?>


<!DOCTYPE html>
<html>

    <head>
        <title></title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/navbar_btn.css">
        <link rel="stylesheet" href="css/tags_btn.css">
        <link rel="stylesheet" href="account.css">
    </head>

    <body>
        <header >
            <div class="navbar">
                <div id="logoandlinks">
                    <a href="index.php" class="logo" style="height:100px;"><img src="img/8gag.png" alt="#header"></a> <?php 

                            $req = $dbh->prepare('SELECT * FROM users where id = :id');
                            $req->execute([
                ':id' => $_SESSION['id']]);
                            $res = $req->fetchAll(); 
                            foreach ($res as $item) {
                            echo '<h2>BIENVENUE  SUR  VOTRE  PROFIL '.$item['name'].'</h2>';} ?>
                            <?php if(isset($erreurs)){echo '<center><font color="red">'. $erreurs.'</font></center>';}?>
                    <div class="profil"> <img src="" alt="">
                        <!--        image de profil -->
                        <nav class="cl-effect-10">
                           
                            <a href="#" data-hover="Upload"><span>Upload</span></a>
                            <a href="logout.php" data-hover="Logout"><span>Logout</span></a>


                        </nav>
                    </div>
                </div>
                <hr style="margin:0;border-color: #FF0042;width: 100%;"> </div>
        </header>

<div class="corps">
        <div class="modif">
            <form>
              
                <p>MODIFIER : </p> 
                <label>nom : </label>
                <input type="text" name="name" id="" placeholder="nom" value="<?= $result[0]['name'] ?>">
               
                <label>email :</label>
                <input type="text" name="email" id="" placeholder="email" value="<?= $result[0]['email'] ?>">
              
                <label>mot de passe :</label>
                <input type="password" name="password" id="" placeholder="password">
               
                <label> nouveau mot de passe :</label>
                <input type="password" name="passwords" id="" placeholder="password">
                
                <input type="submit" name="send" value="enregistrer" />
            </form>
           

        </div>
        <div class="upload">
            <h1>YOUR UPLOAD</h1>
        </div>
        <footer>
            <form>
               <?php if(isset($erreur)){echo '<font color="red">'. $erreur.'</font>';}?>
                <h2>supprimer compte  </h2> 
                <label>email :</label>
                <input type='email' name='mailsuppr' placeholder='Mail' />
            
                <label>mot de passe :</label>
                <input type='password' name='mdpsuppr' placeholder='Votre mot de passe' />
                
                <label>confirmer mot de passe :</label>
                <input type='password' name='mdpsuppr' placeholder='confirmer mot de passe' />
                
                <input type='submit' name='formsuppr' value='Supprimer' />
            </form>
            <?php if(isset($erreur)){echo '<font color="red">'. $erreur.'</font>';}?>
        </footer>
</div>
    </body>

</html>