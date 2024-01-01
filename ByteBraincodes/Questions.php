<?php
session_start();
if(!isset($_SESSION["user_id"]))
    header("Location: login.php");
if(isset($_POST['bt']))
{
    try
    {
        require('connection.php');
        $db->beginTransaction();
        // Inserting quiz information in its table
        $InsertQuiz = "INSERT INTO quizzes (userID, title, timeforquiz, subject, description, noquestions, qlevel) 
        VALUES(?,?,?,?,?,?,?)";
        $userID = $_SESSION['user_id'];
        $title = $_SESSION['title'];
        $Noquestions = $_SESSION['Noquestions'];
        $description = $_SESSION['description'];
        $time = $_SESSION['time'];
        $subject = $_SESSION['subject'];
        $level= $_SESSION['level'];
        $true= "true";
        $false= "false";
        $record = $db->prepare($InsertQuiz);
        $record->bindParam(1,$userID);
        $record->bindParam(2,$title);
        $record->bindParam(3,$time);
        $record->bindParam(4,$subject);
        $record->bindParam(5,$description);
        $record->bindParam(6,$Noquestions);
        $record->bindParam(7,$level);
        $record->execute();
        
        // inserting question text into its table
        $quizID=$db->lastInsertId();
        $InsertQuestion="INSERT INTO questions (quizID,questiontext) VALUES(?,?)";
        $InsertOption="INSERT INTO options (questionID, optiontext, isCorrect) VALUES(?,?,?)";
        $qs = $db->prepare($InsertQuestion);
        $option = $db->prepare($InsertOption);
        $qs->bindParam(1, $quizID);
        for ($h=1;$h<=$_SESSION['Noquestions'];$h++) 
        {
            $qs->bindParam(2, $_POST['te'.$h]);
            $qs->execute();
            $questionID=$db->lastInsertId();
            $option->bindParam(1, $questionID);
            // inserting options in their table (needs nested loop for mcq)
            // check question type (t/f or mcq ??)
        
            if ($_POST[$h.'check'] == "mcq") 
            {
                for ($t=1;$t<=4;$t++) 
                { if (trim($_POST[$h.'op'.$t]) != '') {
                    if ($_POST[$h.'mcq'] == ($h.'op'.$t)) {
                        
                        $option->bindParam(2, $_POST[$h.'op'.$t]);
                        $option->bindParam(3, $true);
                        $option->execute(); }
                   
                    else {
                        $option->bindParam(2, $_POST[$h.'op'.$t]);
                        $option->bindParam(3, $false);
                        $option->execute();
                    } }
                }
            }
            else 
            { 
                if ($_POST[$h.'tf'] == ($h.'t')) 
                {
                $option->bindParam(2, $true);
                $option->bindParam(3, $true);
                $option->execute();
                $option->bindParam(2, $false);
                $option->bindParam(3, $false);
                $option->execute();  
                }
                
                else if ($_POST[$h.'tf'] == ($h.'f'))
                {
                $option->bindParam(2, $true);  
                $option->bindParam(3, $false);
                $option->execute();

                $option->bindParam(2, $false);
                $option->bindParam(3, $true);
                $option->execute();
                }
            }

        }
        $db->commit();
        
    }
    catch (PDOException $e) 
    {
        $db->rollBack();
        die("Error: ".$e->getMessage());
    }
    header("Location: dashboard.php");
}
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <title>Quiz Questions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="./custom.css"> -->
    <!-- <link rel="stylesheet" href="./bootstrap.min.css"> -->
    <link rel="stylesheet" href="questionsstyle.css">
    <link rel="stylesheet" href="overrides.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>
    
    <header style="height:4.4rem">
    <?php require('nav.php'); ?>
    </header>
    <main class="my-5 main-expand-lg"> 
        <div id="title">
            <h1><?php echo "Quiz : ".$_SESSION['title']; ?></h1>
        </div>
        <div class="pagination">
        <?php
            // the whole pagination thing needs php because it should depend on the number of questions
            for ($i=1;$i<=$_SESSION['Noquestions'];$i++) 
            {
                echo "<button value='".$i."' class='navigation' id='no".$i."'href='";?>#<?php
                echo "'onclick='numberValue(this.id)'>$i</button>";
            }
            // if($i==1) echo "style='display:block'"; else echo "style='display:none'"; 
            ?>
        </div>
        <div class="my-4 QuestionContainer">
        <form name="quiz" method="post">  
            <input type="hidden" name="Qnumber" id="questionnumber" value=<?php echo  "'".$_SESSION['Noquestions']."'"?>>
               <!-- <p style="font-size:24px; font-weight:bold">Question Type:</p> --> 
                <?php
                   for ($i=1;$i<=$_SESSION['Noquestions'];$i++) 
                { ?>   
                <div class="my-4 sw" id=<?php echo "'".$i."checkDiv'"; ?> <?php if ($i==1) echo "style='display:inline-block'"; else echo "style='display:none'";?>>
                <label class="switch" id=<?php echo "'".$i."check3'"; ?> <?php if ($i==1) echo "style='display:block'"; else echo "style='display:none'";?>>
                <input name=<?php echo "'".$i."check'"; ?> value="mcq" class="checkb" id=<?php echo "'".$i."check'"; ?> type="checkbox" onclick="questionType(this.id)" <?php if ($i==1) echo "style='display:inline'"; else echo "style='display:none'";?> checked >
                <span id=<?php echo "'".$i."check2'"; ?> <?php if ($i==1) echo "style='display:block'"; else echo "style='display:none'";?> class="slider round"></span>
                </label>
                </div>
                <p  <?php if ($i==1) echo "style='display:block;font-size:24px;font-weight:bold'"; else echo "style='display:none;font-size:24px;font-weight:bold'";?> id=<?php echo "'".$i."checkmcq'"; ?> >Multiple Choice Question</p>
                <p  id=<?php echo "'".$i."checktf'"; ?> style="display:none; font-size:24px; font-weight:bold">True/False Question</p>
                
                <?php  
                }?>
            
            <p id="Qnumber" style="font-size:32px; font-weight:bold">Question 1</p>
            <div id="log" style="padding:10px;background-color:white; display: none;"><pre id="errorLog" style="font-size:16px; font-weight:bold"></pre></div>
            <div class="my-4" id="question">
                <a role="button" id="la" class="leftarrow" onclick="PrevQuestion(previousID)">&laquo;</a>
                <form name="quiz" method="post">
                    <?php for ($i=1;$i<=$_SESSION['Noquestions'];$i++) { ?>
                    <div <?php if ($i==1) echo "style='display:block'"; else echo "style='display:none'";?>  id=<?php echo "'".$i."'"; ?> class="texts">
                    <textarea  id=<?php echo "'te".$i."'" ?> name=<?php echo "'te".$i."'" ?> rows="8" cols="150" placeholder="Question text" onkeyup=""></textarea>
                    </div>
                    <?php } ?>
                <a role="button" id="ra" class="rightarrow" onclick= "NextQuestion(previousID)">&raquo;</a>
            </div> 
            
                <div class="my-4" id="options">
                    <?php
                    for ($y=1;$y<=$_SESSION['Noquestions'];$y++) 
                    {
                    for ($j=1;$j<=4;$j++) 
                    {?> 
                    <div <?php if ($y==1) echo "style='display:block'"; else echo "style='display:none'";?> id=<?php echo "'".$y."op".$j."'";?>  class='op'>
                    <textarea class=<?php echo "'textareas".$y."'" ?> name=<?php echo "'".$y."op".$j."'"; ?>  id=<?php echo "'".$y."t".$j."'"; ?>  rows='4' cols='60' placeholder='Option.....' onkeyup=""></textarea >
                    <input type='radio' class=<?php echo "'".$y."mcq'"; ?> value="none" name=<?php echo "'".$y."mcq'"; ?>  id=<?php echo "'".$y."c".$j."'"; ?> onclick="clearOthers(this.id);">
                    </div>
                    <?php } ?>
                    <div id=<?php echo "'".$y."true'"; ?> class="op tfs" style="display:none">
                        <p rows="8" cols="75">True</p> 
                        <input type="radio" value="" class=<?php echo "'".$y."tf'"; ?> name=<?php echo "'".$y."tf'"; ?> id=<?php echo "'".$y."tr'"; ?> onclick="clearOthers(this.id);" disabled>
                    </div>
                    <div id=<?php echo "'".$y."false'"; ?>  class="op tfs" style="display:none">
                        <p rows="6" cols="75">False</p> 
                        <input type="radio" value="" class=<?php echo "'".$y."tf'"; ?> name=<?php echo "'".$y."tf'"; ?> id=<?php echo "'".$y."fl'"; ?> onclick="clearOthers(this.id);" disabled>
                    </div>
                <?php }?>
            </div>
        </div>
        <div id="finish" style="padding:10px" onmousemove="ValidateAll();IsChecked()">
            <button name="bt" id="createQuiz" type="submit" class=".btn" value="" disabled> Create Quiz</button>
         </form>
        </div>
        <script src="functions.js"></script>
    </main>
    <footer>
        <!-- Copyright -->
        <div class="text-center p-3 expand-lg fixed-bottom bottom">
            2023 Copyright
        </div>
        <!-- Copyright -->
    </footer>

</body>
</html>
