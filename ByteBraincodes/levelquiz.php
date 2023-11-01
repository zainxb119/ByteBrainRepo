<?php 
include('search.php');
require 'header.php'; ?>

<div class="container align-items-left text-left mt-5 mb-5" style="max-width: var(--breakpoint-md);">
  <div class="row row-cols-1 row-cols-md-2"> 
  <?php
  if ($error == 0) {
    foreach ($query as $card) 
    { ?>
    <div class="col"> <!--<div class="col-12 col-md-6 col-lg-4"> didnt really work so we set it in the rows-->
      <div class="card mb-3">
        <img src="<?php echo "$card[2]"; ?>.png" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"><?php echo "$card[1]"; ?></h5>
          <p class="card-text"><?php echo "$card[3]"; ?></p>
          <a class="btn btn-outline-light " href="myQuizview1.php?qid=<?php echo "$card[0]"; ?>" role="button">View Details</a>
        </div>
      </div>
    </div>
    <?php
    }
  }
  ?>

  </div>
</div>
<?php require 'bottom.php' ?>
<?php require 'footer.php' ?>