<?php
include_once 'dbconfig.php';
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
 $sql="SELECT * FROM tbl_uploads";
 $result_set=mysql_query($sql);
 while($row=mysql_fetch_array($result_set))
 {
  ?>
        <tr>
        <td><?php echo $row['file'] ?></td>
        <td><?php echo $row['type'] ?></td>
        <td><?php echo $row['size'] ?></td>
        <td><a href="uploads/<?php echo $row['file'] ?>" target="_blank">view file</a></td>
        </tr>
        <?php
 }
 ?>
    
    
<?php
require 'connect.php';
//session_destroy();
$req = $dbh->prepare('SELECT * FROM products');
$req->execute();
$res = $req->fetchAll(); // Contient tous mes produits
if (!empty($_POST)) {
    if(!isset($_SESSION['panier'])){
        $_SESSION['panier'] = [];
    }
    array_push($_SESSION['panier'], $_POST['id']);
}

foreach ($res as $item) {
    echo '<img height="10" src="upload/' . $item['picture'] . '" >';
    echo '<form method="POST">';
  
    echo '<button type="submit"> Ajouter au panier </button>';
    echo '</form>';
}
 ?>
    
    
    
</div>
</body>
</html>