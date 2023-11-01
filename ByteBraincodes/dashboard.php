<?php
session_start();
require 'header.php';
if(!isset($_SESSION["user_id"]))
    header("Location: login.php");
include 'dashquery.php';
?>

<div class="container-fulid align-items-center text-center mt-5">
<div class="container-fluid">
  <div class="row-10 py-1 mb-3" style="background-color: #ffffff89;  color:  #062747; backdrop-filter: blur(5px); border-radius: 20px; box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.5); ">
     <h1 class="display-6">Hello, <?php echo $_SESSION["username"] ?? "";  ?>!</h1>
     <p class="lead">Quench your thirst for tech knowledge!</p>
  </div>
</div>

<div class="row ">
    <div class="col-md-4">
      <div class="col g-5 my-2 p-1">
                    <div class="row-md-5 mb-4 p-1">
                        <div class="p-3" style="background-color: #ffffff89; color:black; backdrop-filter: blur(5px); border-radius: 20px; box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.5); " >
                            <div>
                            <span class="material-symbols-outlined"> auto_fix </span>
                                <h6 style="color: #062747;">Number of Created Quizzes</h6>
                                <p ><?php echo $_SESSION["quiz_count"] ?? "";  ?></p>
                            </div>
                            
                        </div>
                    </div>

                    <div class="row-md-4 mb-4 p-1">
                        <div class="p-3 " style="background-color: #ffffff89; color:black; backdrop-filter: blur(5px); border-radius: 20px; box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.5); ">
                            <div>
                            <span class="material-symbols-outlined"> quiz </span>
                                <h6 style="color: #062747;">Number of Conducted Quizzes</h6>
                                <p ><?php echo $_SESSION["conducted_quiz_count"] ?? "";  ?></p>
                            </div>
                          
                        </div>
                    </div>

                    <div class="row-md-4 mb-4 p-1">
                        <div class="p-3 " style="background-color: #ffffff89; color:black; backdrop-filter: blur(5px); border-radius: 20px; box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.5); ">
                            <div>
                            <span class="material-symbols-outlined">military_tech</span>
                            <h6 style="color: #062747;">Total Score</h6>
                            <p><?php echo isset($_SESSION["total_score"]) && $_SESSION["total_score"] != 0 ? $_SESSION["total_score"] : "0"; ?></p>
                            </div>
                            
                        </div>
                    </div>
                </div>
    </div>
    <div class="col-md-8">
    <div class="jumbotron col-12 my-2" style="background-color: #ffffff89; color: #062747; backdrop-filter: blur(5px); border-radius: 20px; box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.5);">
        <h1 class="display-6">Recently Added</h1>
        <hr class="my-4">
        <div class="row d-flex justify-content-between align-items-center flex-wrap">
            <?php
            $count = 0;
            foreach ($trendquery as $card) {
                if ($count >= 2) {
                    break;
                } /*$trendingQuizzes = "SELECT title, timeforquiz, noquestions, subject, QZID FROM quizzes ORDER BY datecreated DESC";*/
            ?>
                <div class="card col-12 col-lg-5 mx-auto" style="margin-bottom: 40px;">
                    <div class="card-body ml-20">
                        <h5 class="card-title">Quiz <?php echo $card[0]; ?></h5>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap bg-transparent">
                        <div class="d-flex w-100 align-items-center">
                            <p class="font-weight-lighter m-0 mr-3 flex-grow-1">Time: <?php echo $card[1] ?></p>
                            <p class="font-weight-lighter m-0 mr-3 flex-grow-1">#Questions: <?php echo $card[2]; ?></p>
                            <p class="font-weight-lighter m-0 flex-grow-1">Subject: <?php echo $card[3]; ?></p>
                        </div>
                        <a href="myQuizview1.php?qid=<?php echo "$card[4]";?>" class="btn btn-primary mt-3">Start</a>
                    </div>
                </div>
            <?php
                $count++;
            } // Closing brace for foreach loop
            ?>
        </div>
    </div>
</div>

<!-- Card deck -->
  
<?php require 'bottom.php' ?>
<?php require 'footer.php' ?>