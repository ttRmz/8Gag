<?php
require 'connect.php';

$req = $dbh->prepare('SELECT picture FROM pictures ORDER BY id DESC limit 0,5');
$req->execute();
$res = $req->fetchAll();

foreach ($res as $item) {
    echo '<img height="20" src="upload/' . $item['picture'] . '" >';
    echo '<form method="POST">';
    echo '<input name="id" type="hidden" value="' . $item['id'] . '">';
    echo '</form>';
}
