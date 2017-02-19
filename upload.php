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
        move_uploaded_file($_FILES['pic']['tmp_name'], 'upload/' . $_FILES['pic']['name']);


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
            ':user' => $_SESSION['id']

        ];
        $stmt1->execute($arg1);
        header('location:index.php');
    } else {
        echo 'Extension Error';
    }
}
// Si le fichier existe déjà, il sera renommé en copy
if (file_exists($target_file)) {
    function renameDuplicates($path, $file)
    $fileName = pathinfo($path . $file, PATHINFO_FILENAME);
    $fileExtension = "." . pathinfo($path . $file, PATHINFO_EXTENSION);

    $returnValue = $fileName . $fileExtension;

    $copy = 1;
    while(file_exists($path . $returnValue))
    {
        $returnValue = $fileName . '-copy-'. $copy . $fileExtension;
        $copy++;
    }
    return $returnValue;
}
}
?>

