<?php include('search.php'); ?>
<?php require 'header.php' ?>

<div class="container align-items-center text-center" style="max-width: var(--breakpoint-md);">
  <div class="jumbotron bg-transparent mb-1" style="color:white; text-shadow:1px 1px 1px black;">

    <h3>Select your quiz level</h3>

  </div>


  <div class="row  row-cols-1 row-cols-md-2 g-4 mx-auto">
    <div class="col">
      <div class="card mb-5 levels">
      <div class="card-body">
        <h4 class="card-title">Level 1</h4>
        <p class="card-text">New to the IT field ? Come and learn new facts and skills !</p>
        <a href="levelquiz.php?lev=level1" class="stretched-link"></a>
      </div>
      </div>
    </div>
    <div class="col">
    <div class="card mb-5 levels">
      <div class="card-body">
        <h4 class="card-title">Level 2</h4>
        <p class="card-text">Halfway through your IT adventure ? Complete it with ByteBrain !</p>
        <a href="levelquiz.php?lev=level2" class="stretched-link"></a>
      </div>
      </div>
    </div>
    <div class="col">
    <div class="card mb-5 levels">
      <div class="card-body">
        <h4 class="card-title">Level 3</h4>
        <p class="card-text">Semi-expert, you say? what about you become a real expert ?</p>
        <a href="levelquiz.php?lev=level3" class="stretched-link"></a>
      </div>
      </div>
    </div>
    <div class="col">
    <div class="card mb-5 levels">
      <div class="card-body">
        <h4 class="card-title">Level 4</h4>
        <p class="card-text">We have a real expert here ! you better keep expanding your knowledge.</p>
        <a href="levelquiz.php?lev=level4" class="stretched-link"></a>
      </div>
      </div>
    </div>
  </div>
</div>

<?php require 'bottom.php' ?>
<?php require 'footer.php' ?>
