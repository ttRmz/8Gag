<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>8 GAG</title>
        <link rel="stylesheet" href="css/style.css">
   
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link rel="stylesheet" href="css/navbar_btn.css">
        <link rel="stylesheet" href="css/tags_btn.css"> </head>

    <body>
        <header >
            <div class="navbar">
                <div id="logoandlinks">
                    <div class="logo" style="height:100px;"><img src="img/8gag.png" alt="#header"></div>
                     <?php 
                         require 'connect.php';
                        if (isset($_SESSION['connected'])){
                            $req = $dbh->prepare('SELECT * FROM users where id = :id');
                            $req->execute([
                                ':id' => $_SESSION['id']]);
                            $res = $req->fetchAll(); 
                            foreach ($res as $item) {
                                echo '<h2 style="color: rgba(255, 85, 85, 0.85)">BIENVENUE   '.$item['name'].'</h2>';}
                        } ?>
                    <div class="profil"> <img src="" alt="">
                       
                        <!--        image de profil -->
                        <nav class="cl-effect-10">
                            <a href="#" data-hover="Upload"><span>Upload</span></a>
                            <?php
                            
                            if (isset($_SESSION['connected'])){
                                echo '<a href="logout.php" data-hover="Logout"><span>Logout</span></a>
                                <a href="account.php" data-hover="Count"><span>Count</span></a>';
                            }
                            else {
                                echo '<a href="login.php" data-hover="Login/Register"><span>Login/Register</span></a>';
                            }
                            ?>
                        </nav>
                    </div>
                </div>
                <hr style="margin:0;border-color: #FF0042;width: 100%;"> </div>
            <div class="tags">
                <?php 

                $req = $dbh->prepare('SELECT * FROM categories');
                $req->execute();
                $res = $req->fetchAll(); // Contient tous mes produits


                foreach ($res as $item) {

                    if(isset($_SESSION['connected'])){

                        echo ' <button class="button button--ujarak button--border-thin button--text-thick" href="acount.php" >'.$item['name'].'</button> ';
                    }
                    else{
                        echo ' <button class="button button--ujarak button--border-thin button--text-thick" onclick="myFunction()" id="demo">'.$item['name'].'</button> 
            ';
                    }

                }
                ?>
            </div>
        </header>
        <script>
            function myFunction() {
                document.getElementById("demo").innerHTML = "<div style='color:black'>PAS INSCRIT</div>";
            }
        </script>
    </body>

</html>