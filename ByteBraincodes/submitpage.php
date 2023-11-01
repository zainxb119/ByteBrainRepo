<?php session_start();
require 'header.php'; 
//$_SESSION['score']=$score;
//$_SESSION['CQID']=$answeredID;
$answeredID = $_SESSION['CQID'];
$quizID = $_SESSION['quizID'];
?>

<div class="container col-12 my-5 mx-auto d-flex flex-column align-items-center justify-content-center ">
    
<div class="jumbotron col-12 my-5 mx-auto d-flex flex-column align-items-center justify-content-center " style="background-color: #ffffff89; color: #062747; backdrop-filter: blur(5px); border-radius: 20px; box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.5);">
    <span style="font-size: 4em;" class="material-symbols-outlined">rocket</span>
    <hr class="my-3">
    <h1 class="display-6 text-center">Quiz Submitted Successfully!</h1>
    <p class="text-center" style="font-size: 1.5em;">Your tech knowledge is skyrocketing!</p>
    <hr class="my-4">
    <div class="row d-flex justify-content-center">
        <button class="btn btn-primary mx-2" onclick="window.location.href = 'rank.php?quizID=<?php echo $quizID;?>'">Go to Rank</button>
        <button class="btn btn-primary mx-2" onclick="window.location.href = 'results.php?qid=<?php echo $quizID;?>&cqid=<?php echo $answeredID;?>'">Go to Result</button> 
    </div>
</div>
</div>

<?php require 'bottom.php'; ?>
<?php require 'footer.php'; ?>

