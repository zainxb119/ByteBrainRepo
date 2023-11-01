<?php require 'header.php'; ?>
<?php
session_start();

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  try {

    require 'connection.php';

      $sql = "SELECT ID, username, password FROM users WHERE username = '$username'";
      $row = $db->query($sql)->fetch();
      

      if ($row) {
        $storedUserId = $row["ID"];
        $storedUsername = $row["username"];
        

        // Verify the password 
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $storedUserId;
            $_SESSION["username"] = $storedUsername;
            
            header("Location: dashboard.php");
        } else {
               $errors[] = 'Incorrect password.';
          }
      } else {
         $errors[] = 'User does not exist. Please <a href="signup3.php">Sign up</a>.';
      }
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
}
?>


<div class="container align-items-center text-center mt-5">
    <div class="jumbotron col-sm-9 col-lg-5 my-5 mx-auto p-5 " style="background-color: #ffffff89; color:black; backdrop-filter: blur(5px); border-radius: 20px; box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.5); ">
    <?php if (!empty($errors)): ?>
            <div class="alert alert-light" role="alert">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
      <h1 class="display-6">Log in</h1>
        <hr class="my-4">
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
            <div class="mt-3">Don't have an account? <a href="Reg.php" style="color: #062747;">Sign up here</a></div>
        </form>
    </div>
</div>
<?php require 'bottom.php'; ?>
<?php require 'footer.php'; ?>

