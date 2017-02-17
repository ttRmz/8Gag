<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require 'connect.php';


if (!empty($_FILES)) {
    $erreur= 'error';
    $mime_valid = ['image/png', 'image/jpeg','image/gif'];
    $extension_valid = ['png', 'jpeg','jpg','gif'];
    $extension = pathinfo($_FILES['uploadDeFichier']['name'])['extension'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['uploadDeFichier']['tmp_name']);
    // test le mime & l'extension avec pathinfo() -- On ne veut que des fichiers PNG
    if(in_array($extension, $extension_valid) && in_array($mime, $mime_valid)){
        move_uploaded_file($_FILES['uploadDeFichier']['tmp_name'], 'uploads/' . $_FILES['uploadDeFichier']['name']);
        echo 'Done';
    } else {
        echo $erreur;
    }
}

if (!$erreur) {
    $radio=$_POST['cat'];
    $text=$_POST['name'];

    $stmt = $dbh->prepare('SELECT id FROM categories WHERE name=:name');
    $arg=[
        ':name' => $radio
    ];
    $stmt->execute($arg);

    while ($result=$stmt->fetch()){
        global $id_cat;
        $id_cat=$result['id'];
    }

    $stmt = $dbh->prepare('
                INSERT INTO pictures(id, name , picture, categories_id,user_id) 
                VALUES (null, :name, :picture ,:cat, :user);');
    $arg=[
        ':name' => $text,
        ':picture' => $_FILES['pic']['name'],
        ':cat' => $id_cat,
        ':user' => $_SESSION['id']

    ];
    $stmt->execute($arg);

}
?>

<form method="POST" enctype="multipart/form-data">
    <!-- Limite du fichier à 100Ko -->
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
    <input type="file" name="pic">
    <input type="text" name="name" value="Picture's Name">
    <br>
    <input type="radio" name="cat" value="Food"> Food
    <br>
    <input type="radio" name="cat" value="City"> City
    <br>
    <input type="radio" name="cat" value="Mode"> Mode
    <br>
    <input type="radio" name="cat" value="Portrait"> Portrait
    <br>
    <input type="radio" name="cat" value="Sport"> Sport
    <br>
    <input type="radio" name="cat" value="Landscape"> Landscape
    <br>
    <input type="radio" name="cat" value="Animals"> Animals
    <br>
    <input type="radio" name="cat" value="Music"> Music
    <br>
    <input type="radio" name="cat" value="Others" checked> Others
    <br>
    <input type="submit" name="Submit" value="Submit">

</form>