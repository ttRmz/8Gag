<?php

require 'connect.php';

if (!$_SESSION['connected']) {
    // l'utilisateur n'est pas connecté
    header('Location:login.php');
}
$requete = $dbh->prepare('SELECT * FROM user WHERE id = :id');
$requete->execute([':id' => $_SESSION['id']]);
$result = $requete->fetchAll();


if (isset($_GET['send']) ) {


    if(empty($_GET['password']) && empty($_GET['passwords']) && !empty($_GET['name'])&& !empty($_GET['email'])){
        $requete = $dbh->prepare('UPDATE user SET name = :name, email = :email WHERE id = :id');
        $requete->execute([
            ':name' => $_GET['name'],
            ':email' => $_GET['email'],
            ':id' => $_SESSION['id']

        ]);
        echo 'modification faite';
        header("location:account.php");

    }
    elseif(!empty($_GET['password']) && !empty($_GET['passwords']))
    {
        $mdp = sha1($_GET['password']);
        $mdp2 = sha1($_GET['passwords']);
        $requser = $dbh->prepare("SELECT * FROM user WHERE password = ? ");
        $requser->execute(array($mdp));
        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            $requete = $dbh->prepare('UPDATE user SET name = :name, email = :email, password = :password WHERE id = :id');
            $requete->execute([
                ':name' => $_GET['name'],
                ':email' => $_GET['email'],
                ':password'=> $mdp2,
                ':id' => $_SESSION['id']

            ]);
            echo 'modification faite';
            header("location:account.php");

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

        $requser = $dbh->prepare("SELECT * FROM user WHERE email = ? AND password = ? ");
        $requser->execute(array($mailconnect, $mdpconnect));


        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
           

            
                $req = $dbh->prepare('DELETE FROM user WHERE id = :id ');
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
        <link rel="stylesheet" href="upload_view.css" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    </head>

    <body>



        <form>
            <h2>modifier</h2>
            <label>
                nom : </label>
            <input type="text" name="name" id="" placeholder="nom" value="<?= $result[0]['name'] ?>">

            <br>

            <label>
                email :</label>
            <input type="text" name="email" id="" placeholder="email" value="<?= $result[0]['email'] ?>">

            <br>

            <label>
                mot de passe :</label>
            <input type="password" name="password" id="" placeholder="password">

            <br>
            <label>
                nouveau mot de passe :</label>
            <input type="password" name="passwords" id="" placeholder="password">

            <br>

            <input type="submit" name="send" value="enregistrer" />

        </form>
        <?php if(isset($erreurs)){echo '<font color="red">'. $erreurs.'</font>';}?>

            <br>
            <br>
            <h2>supprimer compte</h2>

            <form>
                <input type='email' name='mailsuppr' placeholder='Mail' />
                <br>
                <input type='password' name='mdpsuppr' placeholder='Votre mot de passe' />
                <br>
                <input type='password' name='mdpsuppr' placeholder='confirmer mot de passe' />
                <br>
                <input type='submit' name='formsuppr' value='Supprimer' />
            </form>
             <?php if(isset($erreur)){echo '<font color="red">'. $erreur.'</font>';}?>




    </body>

    </html>