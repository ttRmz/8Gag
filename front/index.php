<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>8 GAG</title>
        <link rel="stylesheet" href="css/style.css">


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
                        foreach($res as $item){
                        echo '<h2 style="color: rgba(255, 85, 85, 0.85)">BIENVENUE   '.$item['name'].'</h2>';}
                    } 
                    ?>
                   <p id="demo"></p>
                
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
                                echo '<a href="login.php" data-hover="Login/Register" ><span>Login/Register</span></a>';
                            }
                            ?>
                        </nav>
                    </div>
                </div>
                <hr style="margin:0;border-color: #FF0042;width: 100%;"> </div>
                </header>
                <div class="corps">
            <div class="tags">
                <?php if (isset($_SESSION['connected'])){
                                echo '<button class="button button--ujarak button--border-thin button--text-thick">Landscape</button>
                <button class="button button--ujarak button--border-thin button--text-thick">Portrait</button>
                <button class="button button--ujarak button--border-thin button--text-thick">Animals</button>
                <button class="button button--ujarak button--border-thin button--text-thick">Games</button>
                <button class="button button--ujarak button--border-thin button--text-thick">Sport</button>
                <button class="button button--ujarak button--border-thin button--text-thick">Mode</button>
                <button class="button button--ujarak button--border-thin button--text-thick">Music</button>
                <button class="button button--ujarak button--border-thin button--text-thick">Food</button>
                <button class="button button--ujarak button--border-thin button--text-thick">City</button>
                <button class="button button--ujarak button--border-thin button--text-thick" onclick="myFunction">Others</button>';
                            }
                            else {
                                echo '<button class="button button--ujarak button--border-thin button--text-thick" onclick="myFunction()">Landscape</button>
                <button class="button button--ujarak button--border-thin button--text-thick" onclick="myFunction()">Portrait</button>
                <button class="button button--ujarak button--border-thin button--text-thick" onclick="myFunction()">Animals</button>
                <button class="button button--ujarak button--border-thin button--text-thick" onclick="myFunction()">Games</button>
                <button class="button button--ujarak button--border-thin button--text-thick" onclick="myFunction()">Sport</button>
                <button class="button button--ujarak button--border-thin button--text-thick" onclick="myFunction()">Mode</button>
                <button class="button button--ujarak button--border-thin button--text-thick" onclick="myFunction()">Music</button>
                <button class="button button--ujarak button--border-thin button--text-thick" onclick="myFunction()">Food</button>
                <button class="button button--ujarak button--border-thin button--text-thick" onclick="myFunction()">City</button>
                <button class="button button--ujarak button--border-thin button--text-thick" onclick="myFunction()" >Others</button>';
                            }
                            ?>
               
            </div>
        
      

        </div>
        <div class="corps"></div>
        <script>
            function myFunction() {
                document.getElementById("demo").innerHTML = "<div style='color:red'>NEED CONNEXION</div>";
            }
        </script>
    </body>

</html>