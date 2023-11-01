<?php
if (!isset($_GET['q']))
    die();
require 'connection.php';
$q = $db->prepare("SELECT * FROM `users` WHERE email = ?");
$q->execute([
    $_GET['q']
]);
echo $q->rowCount() === 0 ? 'y' : 'n';