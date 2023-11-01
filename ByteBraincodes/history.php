<?php 
include('gethistory.php');
require 'header.php'; ?>

<!-- 
  $sql1 = "SELECT q.title,c.date,c.score 
    FROM conductedquizzes c, quizzes q 
    WHERE q.QZID = c.quizid AND c.usersID = $uid";-->    

<div class="container-fluid" style="text-align: center; color:white;" >

<div class="row">
    <div class="col mt-4" style="text-shadow:1px 1px 1px black;">
        <h2>Conducted Quizzes</h3>
    </div>
</div>

<div class="card-deck row">

            <?php
                foreach ($condcQuery as $card) { ?>
                <div class="col-6 col-md-4 col-lg-3 mt-4" style="text-align: center;">
            <div class="card" style="width: 12rem;">
                
                <div class="card-body">
                <h5 class="card-title"><?php echo $card[0]; ?></h5>
                <p class="card-text"><?php echo "Score = ".$card[2]."/".$card[4]; ?></p>
                <a href="myQuizview1.php?qid=<?php echo "$card[3]"; ?>" class="stretched-link"></a>
                </div>
                <div class="card-footer">
                <p class="font-weight-lighter">Submitted on <?php echo $card[1]; ?></p>
                </div>

            </div>  </div>
           
            <?php
                    }
            ?>

</div> 


<div class="row">
    <div class="col mt-5" style="text-shadow:1px 1px 1px black;">
        <h2>Created Quizzes</h3>
    </div>
</div>


<div class="card-deck row">


  <?php
    foreach ($crtdQuery as $c) { ?>
      <div class="col-6 col-md-4 col-lg-3 mt-4" style="text-align: center;">
      <div class="card" style="width: 12rem;">

    <div class="card-body">
      <h5 class="card-title"><?php echo $c[1]; ?></h5>
      <a href="myQuizview1.php?qid=<?php echo "$c[0]"; ?>" class="stretched-link"></a>
    </div>
    <div class="card-footer">
      <p class="font-weight-lighter">Created on <?php echo $c[2]; ?></p>
    </div>

  </div>  </div>

  <?php
        }
?>

</div>


<?php require 'bottom.php' ?>
<?php require 'footer.php' ?>