<?php
require 'connect.php';

if (isset($_POST['connect'])){

    $req = $dbh->prepare('SELECT * FROM user 
                   WHERE email = :email 
                   AND password = :password');
    $req->execute([
        ':email' => $_POST['email'],
        ':password' => $_POST['password']
    ]);
    $users = $req->fetchAll();
    if (count($users) > 0) {
        $_SESSION['connected'] = true;
        $_SESSION['id'] = $users[0]['id'];
        header('Location:index.php');
    }
}

if (isset($_POST['inscrit'])){
    $pseudo = htmlspecialchars($_POST['name']);
    $mail = htmlspecialchars($_POST['email']);


    if(!empty($_POST['name']) && !empty($_POST['email']) 
       && !empty($_POST['password']) && !empty($_POST['passwords']))
    {


        if($_POST['password']==$_POST['passwords'])
        {
            $requete = $dbh->prepare('INSERT INTO user VALUES(NULL,
      :name, :password, :email
    )');
            $requete->execute([
                ':name' => $_POST['name'],
                ':password' => $_POST['password'],
                ':email' => $_POST['email']
            ]);
            header('Location:login.php');
        }
        else
        {
            $erreur = "vos mot de passe ne sont pas identiques !";
        }
    }


}


?>
<!doctype html>
<html lang="en">

    <head>


    </head>

    <body>





        <form method="post" action="">
            <input type="text" id="email" name="email" placeholder="email" size=30 required>
            <br>
            <input type="text" type="password" id="password" name="password" placeholder="mot de passe" size=30 required>
            <br>
            <button  name="connect" type="submit" type="button" class="btn btn-primary">CONNECT</button>
            <br>
            <a  href="inscription.php"class="inscrire">s'inscrire </a>
        </form>




        <form method="post" action="">
            <input type="text" id="name" name="name" placeholder="pseudo" size=30 required>
            <br>
            <input type="text" id="email" name="email" placeholder="email" size=30 required>
            <br>
            <input type="password" id="password" name="password" placeholder="mot de passe" size=30 required>
            <br>
            <input type="password" id="passwords" name="passwords" placeholder="confirmer mot de passe" size=30 required>
            <br>
            <button name="inscrit" type="submit">INSCRIT</button>
            <br>
            <?php
            if(isset($erreur))
            {
                echo '<font color="red">'.$erreur.'</font>';
            }
            ?>
        </form>
        </div>

    </div>
</div>
</div>
</body>
</html>