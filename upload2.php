<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require 'connect.php';

// L'utilisateur a envoyé l'image
if (!empty($_FILES)) {
    $radio=$_POST['cat'];
    $text=$_POST['name'];
    $nomimg=$_FILES['pic']['name'];

    $mime_valid = ['image/png', 'image/jpeg','image/gif'];
    $extension_valid = ['png', 'jpeg','jpg','gif'];
    $extension = pathinfo($_FILES['pic']['name'])['extension'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['pic']['tmp_name']);
    // test le mime & l'extension avec pathinfo() -- On ne veut que des fichiers PNG
    if(in_array($extension, $extension_valid) && in_array($mime, $mime_valid)){
        move_uploaded_file($_FILES['pic']['tmp_name'], 'uploads/' . $_FILES['pic']['name']);
        echo 'Done';


        $stmt = $dbh->prepare('SELECT id FROM categories WHERE name=:name');
        $arg=[
            ':name' => $radio
        ];
        $stmt->execute($arg);

        while ($result=$stmt->fetch()){
            global $id_cat;
            $id_cat=$result['id'];
        }
        $stmt1 = $dbh->prepare('INSERT INTO pictures(id, name , picture, categories_id ,user_id) VALUES(NULL, :name, :picture, :cat, :user)');
        $arg1=[
            ':name' => $text,
            ':picture' => $nomimg,
            ':cat' => $id_cat,
            ':user' => 5

        ];
        $stmt1->execute($arg1);
    } else {
        echo 'Erreur de format';
    }
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="pic"><br>
    <input type="text" name="name" value="Picture's Name"><br>
    <select name="cat">
        <option value="Food" > Food </option><br>
        <option value="City"> City</option><br>
        <option value="Mode" > Mode</option><br>
        <option value="Portrait"> Portrait</option><br>
        <option value="Sport" > Sport</option><br>
        <option value="Landscape"> Landscape</option><br>
        <option value="Animals"> Animals </option><br>
        <option value="Music" > Music</option><br>
        <option value="Others" > Others </option><br>
    </select>
    <button type="submit">
        Envoyer
    </button>

</form>
