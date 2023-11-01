<?php
require 'connection.php';

$storedUserId = $_SESSION["user_id"];

$quizCount = $db->query("SELECT COUNT(*) FROM quizzes WHERE userID = $storedUserId")->fetchColumn();
$conductedQuizCount = $db->query("SELECT COUNT(*) FROM conductedquizzes WHERE usersID = $storedUserId")->fetchColumn();
$totalScore = $db->query("SELECT SUM(score) FROM conductedquizzes WHERE usersID = $storedUserId")->fetchColumn();
$totalQuestions = $db->query("SELECT SUM(noquestions) FROM conductedquizzes c, quizzes q WHERE c.usersID = $storedUserId and c.quizID = q.QZID")->fetchColumn();



$_SESSION["quiz_count"] = $quizCount;
$_SESSION["conducted_quiz_count"] = $conductedQuizCount;
$_SESSION["total_score"] = $totalScore;
$_SESSION["totalQuestions"] = $totalQuestions;


$trendingQuizzes = "SELECT title, timeforquiz, noquestions, subject, QZID FROM quizzes ORDER BY datecreated DESC";
$trendquery = $db->prepare($trendingQuizzes);
$trendquery->execute();


?>
