<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require 'connect.php';

$dossier = 'upload/';
$fichier = basename($_FILES['pic']['name']);
$taille_maxi = 100000;
$taille = filesize($_FILES['pic']['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg');
$extension = strrchr($_FILES['pic']['name'], '.');
// Vérifications de sécurité
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
    $erreur = 'Extension Error';
}
if($taille>$taille_maxi)
{
    $erreur = 'Size error';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
    //On formate le nom du fichier
    $fichier = strtr($fichier,
        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
    if(move_uploaded_file($_FILES['pic']['tmp_name'], $dossier . $fichier)) // TRUE
    {
        echo 'Success !';
    }
    else // FALSE
    {
        echo 'Error';
    }
}
else
{
    echo $erreur;
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
     <input type="text" name="name" value="Picture's Name"><br>
     <input type="radio" name="cat" value="Food" > Food<br>
     <input type="radio" name="cat" value="City"> City<br>
     <input type="radio" name="cat" value="Mode" > Mode<br>
     <input type="radio" name="cat" value="Portrait"> Portrait<br>
     <input type="radio" name="cat" value="Sport" > Sport<br>
     <input type="radio" name="cat" value="Landscape"> Landscape<br>
     <input type="radio" name="cat" value="Animals"> Animals <br>
     <input type="radio" name="cat" value="Music" > Music<br>
     <input type="radio" name="cat" value="Others" checked > Others <br>
    <input type="submit" name="Submit" value="Submit">

</form>