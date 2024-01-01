<?php
session_start(); 
if(!isset($_SESSION["user_id"]))
    header("Location: login.php");
if (isset($_POST['button'])) 
{
    if(trim($_POST['title'])=="" || trim($_POST['time'])=="" || trim($_POST['subject'])=="" || trim($_POST['ques'])=="" || trim($_POST['level'])=="") {
        $errors[]="enter missing information";
    }
    if (!preg_match('/^[a-zA-Z0-9\s]{3,100}$/', $_POST['title'])) {
        $errors[]="Title can contain letters or numbers only";
    }
    if (!preg_match('/^[a-zA-Z0-9\s]{3,100}$/', $_POST['subject'])) {
        $errors[]="Subject can contain letters or numbers only";
    }
    if (!preg_match('/^\d{1,2}$/', $_POST['time'])) {
        $errors[]="Max Time is 99 minutes and Min is 1 minute";
    }
    if (!preg_match('/^([1-9]|[1-4][0-9]|50)$/', $_POST['ques'])) {
        $errors[]="Max number of questions is 50";
    }
    else if (empty($errors)) {
        try 
        {
            require('connection.php');
            $userID = $_SESSION['user_id'];
            $_SESSION['title']=$_POST['title'];
            $_SESSION['Noquestions']=$_POST['ques'];
            $_SESSION['description']=$_POST['descrip'];
            $_SESSION['time']=$_POST['time'];
            $_SESSION['subject']=$_POST['subject'];
            $_SESSION['level']=$_POST['level'];
            header ('location:Questions.php');
            }
        catch (PDOException $e) 
        {
            die("Error: ".$e->getMessage());
        } 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <title>Add Quiz</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="./custom.css"> -->
  <!-- <link rel="stylesheet" href="./bootstrap.min.css"> -->
    <link rel="stylesheet" href="addquizstyle.css">
    <link rel="stylesheet" href="overrides.css">
  <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body>
    <header style="height:4.4rem">
    <?php require('nav.php'); ?>
    </header>
    <main class="my-5 main-expand-lg">
        <h1>New Quiz</h1>
        <br>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-light" role="alert">
                <?php foreach ($errors as $error): ?>
                    <p style="font-weight:bold;text-align:center;"><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form class="quiz" action="" method="post">
            <div class="det">
            <label for="title">Quiz Title</label>
            <input type="text" name="title" id="Qtitle"> 
            </div>
            <br><br>
            <div class="det">
            <label for="time">Time for Quiz</label>
            <input type="number" name="time" id="Qtime">
            </div>
             <br><br>
            <div class="det">
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="Qsubject"> 
            </div>
            <br><br>
            <div class="det">
            <label for="descrip">Description</label>
            <textarea name="descrip" rows="4" cols="22" id="descrip"> 
             </textarea>
            </div> 
            <br><br>
            <div class="det">
            <label for="ques">No. Question</label>
            <input type="number" name="ques" id="Qquestions" >
            </div>
             <br><br>
            <div class="det"> 
            <label for="" id>Level:</label><select name="level" id="level" >
                <option value="1">Level 1</option>
                <option value="2">Level 2</option>
                <option value="3">Level 3</option>
                <option value="4">Level 4</option>
            </select>
            </div>  <br><br><br>
            <button name="button" type="submit" class=".btn" value="" onclick=""> Create Quiz</button><br><br>
                
        </form>
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

