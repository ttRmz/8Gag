<?php
require 'connect.php';


if (!empty($_POST)) {
    $image = '';
    if (!empty($_FILES)) {
        
        // 1.2.3  => [1, 2, 3]
        $explode = explode('.', $_FILES['image']['name']);
        $extension = $explode[count($explode) - 1];
        // On demande au système de vérifier le type MIME après l'ouverture du fichier
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        // On regarde les informations sur le fichier temporaire
        $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
        // On ferme la connexion au fichier
        finfo_close($finfo);
       
        // On accepte seulement du PNG
        if ($extension == 'png' && $mime == 'image/png') {
            move_uploaded_file($_FILES['image']['tmp_name'],
                'upload/' . $_FILES['image']['name']);
            $image = $_FILES['image']['name'];
        }
    }
    $req = $dbh->prepare('INSERT INTO pictures VALUES (NULL, :name, 
:picture)');
    $req->execute([
        ':name' => $_POST['name'],
        ':picture' => $image
    ]);
}
?>

<form action="" enctype="multipart/form-data" method="post">
    <input type="text" name="name" id="" placeholder="name"> <br>
    <input type="file" name="image" id="" placeholder="image"><br>
    <button type="submit">Enregistrer</button>
</form>


