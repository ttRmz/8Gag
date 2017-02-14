<?php
require 'connect.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<link rel="stylesheet" href="upload_view.css" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
</head>
<body>
<div id="header">
<label>YOUR UPLOADS</label>
</div>
<div id="body">
   <label><a href="index.php">UPLOAD NEW IMAGE</a></label>  
<?php
//session_destroy();
$req = $dbh->prepare('SELECT * FROM products');
$req->execute();
$res = $req->fetchAll(); // Contient tous mes produits


foreach ($res as $item) {
    echo '<img height="50" src="upload/' . $item['picture'] . '" >';
    echo '<form method="POST">';
  
    
    echo '</form>';
}
 ?>
    
    
    
</div>
</body>
</html>