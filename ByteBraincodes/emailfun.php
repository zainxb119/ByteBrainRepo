<?php
$value1 = $_GET['r']; 

try{
    require('connection.php');}
    catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$stmt1 = $db->prepare("SELECT * FROM users WHERE email = ?");
$stmt1->execute([$value1]);
$result1 = $stmt1->fetchAll();

if ($result1) {

    
    echo "The email \"$value1\" is already taken.";
} else {
    echo "The email \"$value1\" is available.";
}

$stmt1 = null;
$db = null;

?>