<?php
session_start();
if(!isset($_SESSION["user_id"]))
    header("Location: login.php");
try {
    $cAnswers=[];
    $userID=$_SESSION['user_id'];
    $quizID = $_GET['quizID'];
    $_SESSION['quizID'] = $quizID ; // later changed to $_GET['quizID']
    require('connection.php');
    $db->beginTransaction();
    $fetchquiz = "SELECT QZID, title, timeforquiz, noquestions FROM quizzes WHERE QZID=$quizID"; 
    $quiz = $db->query($fetchquiz);
    foreach ($quiz as $selectedQuiz) {
        $quesnumber = $selectedQuiz['noquestions'];
        $timer = $selectedQuiz['timeforquiz'];
        $titled = $selectedQuiz['title'];
    }
    $x=1; //for question index
    $y=1; //for option index
    $fetchQuestion = "SELECT QSID, questiontext FROM questions WHERE quizID = $quizID";
    $question = $db->query($fetchQuestion);
    foreach ($question as $text) {
        $questionID[$x]=$text['QSID'];
        $qtext[$x]= $text['questiontext'];
        $fetchOptions = "SELECT OPID, optiontext,isCorrect FROM options WHERE questionID =$questionID[$x]";
        $fetchCorrectOptions = 'SELECT OPID, optiontext, isCorrect FROM options WHERE questionID ='.$questionID[$x].' AND isCorrect = true';
        $correctAnswers = $db->query($fetchCorrectOptions);
        $options = $db->query($fetchOptions);
        foreach ($correctAnswers as $CA) {
           $cAnswers[$x] = (string) $CA['optiontext'];
        }
        foreach ($options as $op)
        { 
            $opID[$x][$y] = $op['OPID'];
            $optext[$x][$y] =(string) $op['optiontext'];
            // $opCorrect[$x][$y] = (string) $op['isCorrect']; 
            $y++;
        }
        $y=1;
        $x++;
        }
        if (isset($_POST['bt'])) {
            $score=0;
            for ($i=1;$i<=$quesnumber;$i++) {
                $_SESSION['answers'][$quizID][$i] = $_POST[$i.'option'];
                if ($_SESSION['answers'][$quizID][$i] == $cAnswers[$i]) {
                    $score++;
                }
            }
            $InsertConducted= "INSERT INTO conductedquizzes (quizID, usersID, score) VALUES (?,?,?)";
            $answeredQuiz = $db->prepare($InsertConducted);
            $answeredQuiz->execute([$quizID, $userID, $score]);
            $answeredID = $db->lastInsertId();
            $_SESSION['score']=$score;
            $_SESSION['CQID']=$answeredID;
            //echo "<script>";
            //echo "window.location.href='submitpage.php?qid=+document.getElementById(".$quizID.").value'";
            //echo "</script>";
            header('location:submitpage.php?qid='.$quizID.'&cqid='.$answeredID);
    }
    $db->commit(); 
}
catch(PDOException $e) {
    $db->rollBack();
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
    <title>Quiz Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="./custom.css"> -->
    <!-- <link rel="stylesheet" href="./bootstrap.min.css"> -->
    <link rel="stylesheet" href="questionsstyle.css">
    <link rel="stylesheet" href="overrides.css">
    <link rel="stylesheet" href="quizview2style.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>
    
    <header style="height:4.4rem">
    <?php require('nav.php'); ?>
    </header>
    <main class="my-5 main-expand-lg"> 
        <div id="title">
            <h1><?php echo "Quiz : ".$titled; ?></h1>
        </div>
        <div class="">
            <input type="hidden" id="quizID" value=<?php echo $quizID?> >
            <input type="hidden" name="" id="time" value=<?php echo $timer ?>>
            <div id="timer"><?php echo $timer.":00"; ?> </div> </div>
        <div class="pagination">
        <?php
            // the whole pagination thing needs php because it should depend on the number of questions
            for ($i=1;$i<=$quesnumber;$i++) 
            {
                echo "<button value='".$i."' class='navigation' id='no".$i."'href='";?>#<?php
                echo "'onclick='numberValue(this.id)'>$i</button>";
            }
            // if($i==1) echo "style='display:block'"; else echo "style='display:none'"; 
            ?>
        </div>
        <div class="my-4 QuestionContainer ">
        <form name="quiz" method="post">       <!-- <p style="font-size:24px; font-weight:bold">Question Type:</p> --> 
            <p id="Qnumber" style="font-size:32px; font-weight:bold">Question 1</p>
            <div id="log" style="padding:10px;background-color:white; display: none;"><pre id="errorLog" style="font-size:16px; font-weight:bold"></pre></div>
            <input type="hidden" name="questionNumber" id="NOQUESTIONS" value=<?php echo"'".$quesnumber."'"; ?> >
            <div class="" id="question">
                <a role="button" id="la" class="leftarrow" onclick="PrevQuestion(previousID)">&laquo;</a>
                    <?php for ($i=1;$i<=$quesnumber;$i++) { ?>
                    <div <?php if ($i==1) echo "style='display:block'"; else echo "style='display:none'";?>  id=<?php echo "'".$i."'"; ?> class="texts">
                    <textarea name=<?php echo "'te".$i."'" ?> rows="8" cols="150" disabled><?php echo $qtext[$i] ?></textarea>
                    </div>
                    <?php } ?>
                <a role="button" id="ra" class="rightarrow" onclick= "NextQuestion(previousID)">&raquo;</a>
            </div> 

            <div class="my-4" id="options">
                <?php
                for ($i=1;$i<=$quesnumber;$i++) { ?>
                <input type="hidden" id=<?php echo "'".$i."opNo'";?> value=<?php echo count($optext[$i]); ?> >
                <?php for ($j=1;$j<=count($optext[$i]);$j++)  {
                ?>
                <div id=<?php echo "'".$i."op".$j."'";?> <?php if ($i==1) echo "style='display:block'"; else echo "style='display:none'";?>  class='op'>
                    <textarea rows='4' cols='60' class="op" id=<?php echo "'".$i."ans".$j."'";?> disabled><?php echo $optext[$i][$j] ?></textarea> <br>
                    <input type='radio' class=<?php echo "'".$y."option'"; ?> value="none" name=<?php echo "'".$i."option'"; ?>  id=<?php echo "'".$i."option".$j."'"; ?> onclick="correctAns(this.id);">
                </div>
                <?php } 
                }?>
            </div>
            <div id="finish" style="padding:10px" onmousemove="IsChecked()">
                <button id="submitQuiz" name="bt" type="submit" class=".btn" value="" onclick="window.location.href = 'submitpage.php';" disabled> Submit Quiz</button>
            </div> 
        </form>
        </div> 
    <script src="functions2.js"></script>    
    </main>
    <footer>
        <!-- Copyright -->
        <div class="text-center p-3 expand-lg fixed-bottom bottom">
            2023 Copyright
        </div>
        <!-- Copyright -->
    </footer>
    <?php require('footer.php'); ?>

</body>
</html>