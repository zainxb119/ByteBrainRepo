<?php
require 'header.php'; 
include('search.php');


?>
<!-- "SELECT q.QZID,q.title,q.qlevel, q.description, q.timeforquiz, q.noquestions, q.userID, q.subject, u.ID, u.username
      FROM quizzes q
      WHERE q.QZID = ?" -->
      <div class="container align-items-left text-left mt-5" style="max-width: var(--breakpoint-md);">
      <?php
  if ($error == 0) 
    foreach ($quiz as $info) 
    { ?>
<div class="jumbotron myquiz mt-3" style="background-color: #ffffff89; color:black; backdrop-filter: blur(5px); border-radius: 20px; box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.5); ">
    <h1 class="display-4"><?php echo "$info[1]"; ?></h1>
  <p class="lead">
    Subject: <?php echo "$info[7]"; ?><br>
    Description: <?php echo "$info[3]"; ?><br>
    Time: <?php echo "$info[4]"; ?><br>
    Number of Questions: <?php echo "$info[5]"; ?><br>
    Total Points: <?php echo "$info[5]"; ?><br>
    Created By: <?php echo "$info[9]"; ?></p>
  <hr class="my-4">
    <p>Multiple attempts are allowed, you are allowed to walkbetween the questions. Good Luck! </p>
    <a class="btn btn-primary btn-lg" href="QuizView2.php?quizID=<?php echo "$info[0]"; ?>" role="button">Start Quiz</a>
    </div>
    <?php }
  ?> 
</div>

<?php require 'bottom.php' ?>
<?php require 'footer.php' ?>