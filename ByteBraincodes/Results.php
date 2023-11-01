<?php
session_start();
if(!isset($_SESSION["user_id"]))
    header("Location: login.php");
try {
    $score = $_SESSION['score'];
    $quizID = $_GET['qid'];
    require('connection.php');
    $x=1; //for question index
    $y=1;    
    $cAnswers=[]; //for option index
    $fetchquiz = "SELECT QZID, title, timeforquiz, noquestions FROM quizzes WHERE QZID=$quizID"; 
    $quiz = $db->query($fetchquiz);
    foreach ($quiz as $selectedQuiz) {
        $quesnumber = $selectedQuiz['noquestions'];
        $titled = $selectedQuiz['title'];
    }
    $fetchQuestion = "SELECT QSID, questiontext FROM questions WHERE quizID = $quizID";
    $question = $db->query($fetchQuestion);
    foreach ($question as $text) {
        $questionID[$x] = $text['QSID'];
        $fetchOptions = "SELECT OPID, optiontext FROM options WHERE questionID =".$text['QSID']."";
        $options = $db->query($fetchOptions);
        $qtext[$x]= $text['questiontext'];
        foreach ($options as $op)
        {
            $opID[$x][$y] = $op['OPID'];
            $optext[$x][$y] =(string) $op['optiontext'];
            $y++;
        } 
        $fetchCorrectOptions = 'SELECT OPID, optiontext, isCorrect FROM options WHERE questionID ='.$questionID[$x].' AND isCorrect = true';
        $correctAnswers = $db->query($fetchCorrectOptions);
        foreach ($correctAnswers as $CA) {
           $cAnswers[$x] = (string) $CA['optiontext'];
        }
        $y=1;
        $x++;
    }
    
    for ($n=1;$n<=count($_SESSION['answers'][$quizID]);$n++) {
        $ans[$questionID[$n]] = $_SESSION['answers'][$quizID][$n];
    } 
    echo $x;
}

catch(PDOException $e) {
    die("Error: ".$e->getMessage());
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <title>Results</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="./custom.css"> -->
  <!-- <link rel="stylesheet" href="./bootstrap.min.css"> -->
    <link rel="stylesheet" href="resultstyle.css">
    <link rel="stylesheet" href="overrides.css">
  <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>
    <header style="height:4.4rem">
    <?php require('nav.php'); ?>
    </header>
<main>
    
        <header><h1 id="title"><?php echo "Quiz : ".$titled;?></h1></header>
    <div class="info">    
        <div class="in"><h3>Score : <?php echo $score;?></h3></div> 
    </div>
    <?php ?>
    <div id="questions">
    <?php

    for ($i=1; $i<=$quesnumber;$i++) {
     //str_replace('<', '&lt;', $input_string);
   ?>
        <article>
            <div class="Qtext">
                <?php if (str_contains($qtext[$i],'<')) {echo str_replace('<', '&lt;',$qtext[$i]);}
                else if (str_contains($qtext[$i],'>')) {echo str_replace('>', '&rt;', $qtext[$i]);}
                else echo "$qtext[$i]";?></div>
            <section class="answers">
                <?php for($j=1;$j<=count($optext[$i]);$j++) { ?>
                <div class="op" <?php if ($ans[$questionID[$i]] == $optext[$i][$j] && $cAnswers[$i] == $ans[$questionID[$i]] ) {echo "style='outline: 2.5px solid seagreen'";} 
                else if ($ans[$questionID[$i]] == $optext[$i][$j] && $cAnswers[$i] != $ans[$questionID[$i]]) {echo "style='outline: 2.5px solid red'"; } 
                else {echo "style='opacity: 0.3'";}?>>
                <?php if (str_contains($optext[$i][$j],'<')) {echo str_replace('<', '&lt;', $optext[$i][$j])."<br>";} 
                if (str_contains($optext[$i][$j],'>')) {echo str_replace('>', '&rt;', $optext[$i][$j])."<br>";} 
                else echo $optext[$i][$j]."<br>"; 
                if ($ans[$questionID[$i]] == $optext[$i][$j] && $cAnswers[$i] == $ans[$questionID[$i]] ) {echo "<span class='material-symbols-outlined'>check_box</span>";} else if ($ans[$questionID[$i]] == $optext[$i][$j] && $cAnswers[$i] != $ans[$questionID[$i]]) { echo "<span class="."'material-symbols-outlined'"." >cancel</span>";}?>
            </div>
                <?php }?>
            </section>
        </article>
        <?php }?>
    </div>
    <div id="finish" style="margin:  0 auto; padding: 20px;">
        <button class="btn btn-primary mx-2" onclick="window.location.href = 'rank.php?quizID=<?php echo $quizID;?>'">Go to Rank</button>
    </div>
</main>
<footer> 
        <!-- Copyright -->
        <div class="text-center p-3 expand-lg fixed-bottom bottom">
            2023 Copyright
        </div>
        <!-- Copyright -->
    </footer>
    <?php require('footer.php'); ?>
    <script>
        
    </script>
</body>
</html>