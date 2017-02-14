<?php
require 'connect.php';
if (empty($_SESSION['connected'])) {
    header('Location:login.php');
}

$ret = $dbh->prepare('SELECT * FROM user');
$ret->execute();
$result = $ret->fetchAll();


echo $result[0]['id'] . ' ($result[0][\'id\'])';
echo '<br>';

if (!isset($_GET['action']) && !empty($_GET['if'])) {
    echo $result[0][0] .'($result[0][0])';
    $req = $dbh->prepare('DELETE FROM user WHERE id = :id ');
    $req->execute([
        ':id' => $_SESSION['id']
    ]);
}
?>
<table border="1">
    <tr>
        <th>#</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Action</th>
    </tr>

    <?php
    foreach ($user as $users) {
        echo '
            <tr>
                <td>'.$user['id'].'</td>
                <td>'.$user['name'].'</td>
                <td>'.$user['email'].'</td>
                <td><a href="delete.php?action=del&id='.$user['id'].'">Supprimer</a></td>
            </tr>';
    }
    ?>

</table>
