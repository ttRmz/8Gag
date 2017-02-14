<?php
require 'connect.php';

  if (isset($_SESSION['connected'])){
            echo '<a href="logout.php">logout</a>';
        }
        else {
            echo '<a href="login.php">Login/register</a>';
        }
    
?>

