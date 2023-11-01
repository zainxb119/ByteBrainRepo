<?php session_start();
include('search.php');
include('connection.php'); ?>
<!-- Navbar -->
<html>
    <body>

<nav class="navbar navbar-expand-lg fixed-top">

  <img src="logo.jpg" width="80" height="60" alt="...">



  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php if (!isset($_SESSION['user_id'])): ?>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li><?php endif ?>
      <?php if (isset($_SESSION['user_id'])): ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle colorme" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
          Profile
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item colorme" href="mainpage.php">Edit Profile</a>
          <a class="dropdown-item colorme" href="logout.php">Log out</a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link colorme" href="dashboard.php" role="button">
          Dashboard
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link colorme" href="history.php" role="button">
          History
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link colorme" href="addQuiz.php" role="button">
          Create a Quiz
        </a>
      </li>
      <?php endif ?>
      <li class="nav-item">
        <a class="nav-link colorme" href="levels.php" role="button">
          Levels
        </a>
      </li>

    </ul>
    <!-- Search Bar -->
    <form>
        <input class="form-control" type="text" placeholder="Search" onkeyup="Searchbar(this.value);">
        <div class="form-control" id="Results" style="position:relative; top:2px; background-color:white; border: 0px;"></div>
    </form>
    <script>


              document.getElementById("Results").style.display = "none";
              function Searchbar(input)
              {
                  if (input.length==0)
                  {
                      document.getElementById("Results").style.display = "none";
                      return;
                  }
                  const xhttp=new XMLHttpRequest();
                  xhttp.onload=myAJAXFunction;
                  xhttp.open("GET","mySearch.php?S="+input);
                  xhttp.send();
              }
              function myAJAXFunction(){
                  document.getElementById("Results").style.display = "block"; 
                 document.getElementById("Results").innerHTML=this.responseText; 
                 
              }

            </script>
  </div>
</nav>
