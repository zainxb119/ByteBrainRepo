<?php
$value = $_GET['q']; 

try{
 require('connection.php');
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$value]);
$result = $stmt->fetchAll();

if ($result) {

    $new_username = generate_username($value);
    
    echo "The username \"$value\" is already taken. How about \"$new_username\"?";
} else {
    echo "The username \"$value\" is available.";
}

$stmt = null;
$db = null;

function generate_username($value) {

    $nrRand = rand(0, 100);    
    $username = trim($value).trim($nrRand);
    return $username;
    }
?>