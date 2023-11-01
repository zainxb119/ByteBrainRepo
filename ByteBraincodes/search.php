<?php
include('connection.php');
try 
{
          //if user select a level
            if (isset($_GET['lev'])) 
            {
              $lev = $_GET['lev'];
              $sql = "SELECT q.QZID,q.title,q.qlevel, q.description
                  FROM quizzes q
                  WHERE qlevel = ?
                  GROUP BY q.QZID ORDER BY RAND()";
              $error = 0;
              $query = $db->prepare($sql);
              $query->bindParam(1, $lev);
              $query->execute();
            }

          //view quiz details 
          if (isset($_GET['qid'])) 
          {
            $qid = $_GET['qid'];
            $sl = "SELECT q.QZID,q.title,q.qlevel, q.description, q.timeforquiz, q.noquestions, q.userID, q.subject, u.ID, u.username
                FROM quizzes q, users u
                WHERE q.QZID = ? and q.userID = u.ID";
            $error = 0;
            $quiz = $db->prepare($sl);
            $quiz->bindParam(1, $qid);
            $quiz->execute();
          }

} 
catch (PDOException $e) {
  die($e->getMessage());
  $error = 1;
}
