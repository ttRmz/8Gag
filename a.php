<?php
require 'connect.php';


  if (isset($_SESSION['connected'])){
            echo '<a href="logout.php">logout</a>';
        }
        else {
            echo '<a href="login.php">Login/register</a>';
        }

  if(isset($_SESSION['connected'])){
      echo '<br> <a href="logout.php">log</a>';
  }
else{
    echo '<br> <a onclick="myFunction()" >log<p id="demo"></p></a>
            ';
}
?>

<script>
function myFunction() {
    document.getElementById("demo").innerHTML = "<div style='color:red'>PAS INSCRIT</div>";
}
</script>