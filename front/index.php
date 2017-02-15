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
        <header id="header">
            <div class="navbar">
                <div style="
                            display: -webkit-box;
                            display: -ms-flexbox;
                            display: flex;
                            -webkit-box-pack: justify;
                            -ms-flex-pack: justify;
                            justify-content: space-between;
                            width: 90%;
                            /* height: 40%; */
                            margin: auto;
                            margin: 0 auto;
                            -webkit-box-align: center;
                            -ms-flex-align: center;
                            align-items: center;
                            ">
                    <div class="logo" style="height:100px;"><img src="img/8gag.png" alt="#header"></div>
                    <div class="profil"> <img src="" alt="">
                        <!--        image de profil -->
                        <nav class="cl-effect-10">
                            <a href="#" data-hover="Upload"><span>Upload</span></a>
                            <?php
                            require 'connect.php';
                            if (isset($_SESSION['connected'])){
                                echo '<a href="logout.php" data-hover="Logout"><span>Logout</span></a>';
                            }
                            else {
                                echo '<a href="login.php" data-hover="Login/Register"><span>Login/Register</span></a>';
                            }
                            ?>
                        </nav>
                </div>
                <hr style="margin:0;border-color: #FF0042;width: 100%;"> </div><?php
            if(isset($_SESSION['connected'])){

                echo ' <div class="tags"><button class="button button--ujarak button--border-thin button--text-thick" >Landscape</button> </div>';
            }
            else{
                echo ' <div class="tags"><button class="button button--ujarak button--border-thin button--text-thick" onclick="myFunction()">Landscape<p id="demo"></p></button> </div>
            ';
            }
            ?>
        </header>
        <script>
            function myFunction() {
                document.getElementById("demo").innerHTML = "<div style='color:black'>PAS INSCRIT</div>";
            }
        </script>
    </body>

</html>