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
        <link rel="stylesheet" href="css/account.css">
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
            <h1 >YOUR UPLOAD</h1>
           <?php if (!empty($_FILES)) {
    $radio=$_POST['cat'];
    $text=$_POST['name'];
    $nomimg=$_FILES['pic']['name'];

    $mime_valid = ['image/png', 'image/jpeg','image/gif'];
    $extension_valid = ['png', 'jpeg','jpg','gif'];
    $extension = pathinfo($_FILES['pic']['name'])['extension'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['pic']['tmp_name']);
    // test le mime & l'extension avec pathinfo() -- On ne veut que des fichiers PNG
  


    if(in_array($extension, $extension_valid) && in_array($mime, $mime_valid)){
        move_uploaded_file($_FILES['pic']['tmp_name'], 'uploads/' . $_FILES['pic']['name']);
        echo 'Done';


        $stmt = $dbh->prepare('SELECT id FROM categories WHERE name=:name');
        $arg=[
            ':name' => $radio ];
        $stmt->execute($arg);

        while ($result=$stmt->fetch()){
            global $id_cat;
            $id_cat=$result['id'];
        }
        $stmt1 = $dbh->prepare('INSERT INTO pictures(id, name , picture, categories_id ,user_id) VALUES(NULL, :name, :picture, :cat, :user)');
        $arg1=[
            ':name' => $text,
            ':picture' => $nomimg,
            ':cat' => $id_cat,
            ':user' => $_SESSION['id']

        ];
        $stmt1->execute($arg1);
    } else {
        $erreur = 'Extension Error';
    }
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="pic">
    <input type="text" name="name" value="Picture's Name">
    <label>Thèmes :</label>
    <select name="cat">
        <option value="Others" >Others  </option><br>
        <option value="City"> City</option><br>
        <option value="Mode" > Mode</option><br>
        <option value="Portrait"> Portrait</option><br>
        <option value="Sport" > Sport</option><br>
        <option value="Landscape"> Landscape</option><br>
        <option value="Animals"> Animals </option><br>
        <option value="Music" > Music</option><br>
        <option value="Food" >  Food</option><br>
    </select>
    <button type="submit">
        Envoyer
    </button>

</form>
      <div class="affichage">
       <?php 
            $req = $dbh->prepare('SELECT * FROM pictures where user_id = :id ORDER BY id DESC limit 0,5');
                        $req->execute([
                        ':id' => $_SESSION['id']]
                        );
                        $res = $req->fetchAll(); 
                        foreach($res as $item){
                           echo '<div class="photospic"><img height="200" width="200" src="uploads/' . $item['picture'] . '" ><br>'.$item['name'].'</div>';}
            ?>
            </div>
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