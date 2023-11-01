<?php
require 'connection.php';
include('search.php');
// Retrieve the quiz ID from the conducted quizzes table
$quizIDQuery = "SELECT quizID FROM conductedquizzes LIMIT 1";
$quizIDResult = $db->query($quizIDQuery);
$quizID = $quizIDResult->fetchColumn();

if ($quizID) {
  // Use the retrieved quiz ID in the rankings query
  $rankingsQuery = "
    SELECT c.score, u.username
    FROM conductedquizzes c
    JOIN users u ON c.usersID = u.ID
    WHERE c.quizID = :quizID
  ";

  $stmt = $db->prepare($rankingsQuery);
  $stmt->bindParam(':quizID', $quizID, PDO::PARAM_INT);
  $stmt->execute();

  $rankings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  // Handle the case when no quiz ID is found
  $rankings = array();
}

?>
