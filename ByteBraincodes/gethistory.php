<?php include('connection.php'); 
try {
    session_start();
    if(!isset($_SESSION["user_id"]))
        header("Location: login.php");

    $uid = $_SESSION["user_id"];
    $condc = "SELECT q.title,c.date,c.score, q.QZID, q.noquestions
    FROM conductedquizzes c, quizzes q 
    WHERE q.QZID = c.quizid AND c.usersID = $uid";

    $condcQuery = $db->prepare($condc);
    $condcQuery->execute();


    $crtd = "SELECT q.QZID, q.title, q.datecreated
    FROM quizzes q
    WHERE q.userID = $uid";

    $crtdQuery = $db->prepare($crtd);
    $crtdQuery->execute();


    
} 
catch (PDOException $e) {
    die($e->getMessage());
}
?>
