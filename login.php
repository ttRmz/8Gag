<?php

require 'connect.php';
if (!empty($_GET)) {
    $req = $dbh->prepare('SELECT * FROM user 
                   WHERE email = :email 
                   AND password = :password');
    $req->execute([
        ':email' => $_POST['email'],
        ':password' => $_POST['password']
    ]);
    $users = $req->fetchAll();
    if (count($users) > 0) {
        session_start();
        $_SESSION['connected'] = true;
        $_SESSION['id'] = $users[0]['id'];
        header('Location:add_product.php');
    } else {
        header('location:inscription.php');
    }
}
?>



    <!doctype html>
    <html lang="en">

    <head>
        <link rel="stylesheet" href="popup.css">

    </head>

    <body>

        <div class="box">
            <a class="button" href="#popup1">login</a>
        </div>

        <div id="popup1" class="overlay">
            <div class="popup">
               
                <h2>login</h2>
                <a class="close" href="#">&times;</a>
                <div class="content">
                  
                    <form action="" method="">
                        <input type="text" name="email" id="email" placeholder="email" size="30"><br>
                        <input type="text" name="password" id="password" placeholder="password" size="30"><br>
                        <button type="submit" value="Envoyer" size="30">Connect</button>
                    </form>

                </div>
            </div>
        </div>
    </body>

    </html>