<?php

require 'connect.php';
if (!$_SESSION['connected']) {
    // l'utilisateur n'est pas connecté
    header('Location:login.php');
}
if (!empty($_POST)) {
    $requete = $dbh->prepare('UPDATE user SET name = :name, email = :email, password = :password WHERE id = :id');
    $requete->execute([
        ':name' => $_POST['name'],
        ':email' => $_POST['email'],
        ':password' => $_POST['password'],
        ':id' => $_SESSION['id']
    ]);
}
$requete = $dbh->prepare('SELECT * FROM user WHERE id = :id');
$requete->execute([':id' => $_SESSION['id']]);
$result = $requete->fetchAll();
?>





<form action="" method="post">
    <label>
        nom : <input type="text" name="name" id="" placeholder="nom" value="<?= $result[0]['name'] ?>">
    </label>
    <br>

    <label>
        email :
        <input type="text" name="email" id="" placeholder="email" value="<?= $result[0]['email'] ?>">
    </label>
    <br>

    <label>
        mot de passe :
        <input type="text" name="password" id="" placeholder="password" value="<?= $result[0]['password'] ?>">
    </label>
    <br>

    <button type="submit">Enregister</button>
</form>
<a href=""


