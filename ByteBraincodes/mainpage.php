<?php
require 'header.php';

$uid = $_SESSION["user_id"];
if(!isset($_SESSION["user_id"]))
      header("Location: login.php");

require "validate.php";
require "forms.php";
      if (isset($_POST['SaveUpdate'])) {
        $firtsname = $_POST["firtsname"];
        $lastname = $_POST["lastname"] ;
        $mobilenumber = $_POST["mobilenumber"] ;
        $email = $_POST["email"];
        $birthyear = $_POST["birthyear"];
        $country = $_POST["country"];
        $state = $_POST["state"];
        $major = $_POST["major"];
        $experience = $_POST["experience"];
      }
      

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $valid=true;
        $valid= ValidName($firtsname, "firtsname" , $errs[]) && $valid;
        $valid= ValidName($lastname, "lastname" , $errs[]) && $valid;
        $valid= ValidBirthyear($birthyear, $errs[]) && $valid;
        $valid= ValidPhone($mobilenumber , $errs[]) && $valid;
        $valid= ValidEmail($email , $errs[]) && $valid;
        

        if (isset($errs)) {
            $c = count($errs);
            for ($i = 0; $i < $c; $i++)
              if ($errs[$i] === NULL)
                unset($errs[$i]);
          }
          if (!$valid)
          goto output_begin;
          
          try{
                require "connection.php";

                    $sql = <<<SQL
                    UPDATE  `users`
                    SET     firtsname = :firtsname,
                        lastname = :lastname,
                        mobilenumber = :mobilenumber,
                        email = :email,
                        birthyear = :birthyear,
                        country = :country,
                        state = :state,
                        major = :major,
                        experience = :experience
                    WHERE   `ID` = :uid
                    SQL;

                    $sql_args = [
                        'firtsname' => $firtsname,
                        'lastname' => $lastname,
                        'mobilenumber' => $mobilenumber,
                        'email' => $email,
                        'birthyear' => $birthyear,
                        'country' => $country,
                        'state' => $state,
                        'major' => $major,
                        'experience' => $experience,
                    'uid' => $_SESSION['user_id'],
                    ];
                    $query = $db->prepare($sql);
                    $query->execute($sql_args);
                
                    $success = "Profile has been updated successfully";
                    echo"<div class='mt-4' style='text-align: center; text-shadow:1px 1px 1px black; color:white;'><h3>".$success."</h3></div>";
                  } catch (PDOException $e) {
                    echo $sql, "<br>";  
                    $errCode = $query->errorInfo()[1];
                    if ($errCode == 1062)
                      $error = 'Email already exists';
                    else
                      die("Err $errCode: <br>" . $e->getMessage());
                  }
        }
        else {
            try {
              require 'connection.php';
          
              $q = $db->prepare(" SELECT * FROM `users` WHERE `ID` = ?");
              $q->execute([
                $_SESSION['user_id']
              ]);
              $r = $q->fetch(PDO::FETCH_ASSOC);
          
              
              extract($r);
            } catch (PDOException $e) {
              die($e->getMessage());
            }
          }

          output_begin:
    $db = null;

    if (isset($error))
        echo $error;

?>


<div class="container rounded bg-white mt-5 mb-5" style="color: black;">
    <form name= 'update_profile' method="post" >
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px" src="pics/user.jpg">
                    <?php
                        try{
                            require "connection.php";
                            $stmt = $db->prepare("SELECT * FROM users WHERE username LIKE ?"); 
                            $stmt->bindParam(1, $uid); 
                            $stmt->execute();
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            $db = null;
                            }
                        catch (PDOException $ex) {
                            echo "Error Occurred";
                            die($ex->getMessage());
                        }
                    ?>
                    <span class="text-black-50"> @<?php echo $username; ?></span>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                    

                        <h4 class="text-right">Edit Profile</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>First Name</label>
                            <input type="text" class="form-control" id='firtsname-input' name="firtsname" <?= inject_value($firtsname) ?>>
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-6">
                            <label>Last Name</label>
                            <input type="text" class="form-control" id='lastname-input' name="lastname" <?= inject_value($lastname) ?>>
                            <div class="invalid-feedback"> </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label>Mobile Number</label>
                            <input type="text" name="mobilenumber" class="form-control" id='mobilenumber-input' placeholder="973000000" <?= inject_value($mobilenumber) ?>>
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-12">
                            <label>E-mail </label>
                            <input type="text" class="form-control" id='email-input' name="email" onchange="checkUniqueEmail(this)" <?= inject_value($email) ?>>
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="col-md-12">
                            <label>Birth Year</label>
                            <input type="number" class="form-control" name="birthyear" <?= inject_value($birthyear) ?>>
                            <div class="invalid-feedback"> </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>Country</label>
                            <input type="text" class="form-control" name="country" <?= inject_value($country) ?>>
                        </div>
                        <div class="col-md-6">
                            <label>State</label>
                            <input type="text" class="form-control" name="state" <?= inject_value($state) ?>>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-button" type="submit" name="SaveUpdate">Save Profile</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="col1"><h5 class="text-right">Edit Experience</h5></div>
                    </div>   
                    <div class="col-md-12"><label>Major</label><input type="text" name="major" class="form-control" <?= inject_value($major) ?>></div> <br>
                    <div class="col-md-12"><label>Experience</label><input type="textarea" class="form-control" name="experience" rows="4" <?= inject_value($experience) ?> ></div>
                </div>
            </div>
        </div>  
    </form>
</div>
<script>
      function showError(input, message) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        input.nextElementSibling.innerHTML = message;
      }
      function showSuccess(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
      }

    const emailPattern = /^[a-zA-Z0-9]+(?:[\.\-_][a-zA-Z0-9]+)*@[a-zA-Z0-9]+(?:[\.\-_][a-zA-Z0-9]+)*$/,
      onlyCharactersPattern = /^[a-z]+/i,
      emailInvalidFeedback = document.querySelector('#email-input + .invalid-feedback');

      document.forms['update_profile']?.addEventListener('submit', validateForm);
      
      function validateForm(e) {
        let form = e.target;
        let errors = true;
        let input;
      
        input = form['firtsname']
        if (input.value.length < 3)
          showError(input, 'First name cannot be shorter than 3 characters')
        else if (input.value.length > 15)
          showError(input, 'First name cannot be longer than 15 characters')
        else if (!input.value.match(onlyCharactersPattern))
          showError(input, 'First name must only contain English alphbetic characters')
        else
          showSuccess(input)
      
        input = form['lastname']
        if (input.value.length < 3)
          showError(input, 'Last name cannot be shorter than 3 characters')
        else if (input.value.length > 15)
          showError(input, 'Last name cannot be longer than 15 characters')
        else if (!input.value.match(onlyCharactersPattern))
          showError(input, 'Last name must only contain English alphbetic characters')
        else
          showSuccess(input)

        input = form['mobilenumber']
        if (!input.value.match(/^((\+?|00)973\s?)?[36][0-9]{7}$/))
          showError(input, 'Invalid phone number')
        else
          showSuccess(input)


          const yearPattern = /^(199[5-9]|200[0-3])$/;
          input = form['birthyear'];
          if (!input.value.match(yearPattern))
              showError(input, 'Invalid ! Year should be between 1995 - 2003')
          else
            showSuccess(input)

        input = form['email']//.onchange();
        if (!input.value.match(emailPattern))
            showError(input, 'Invalid email')
        else
            showSuccess(input)  
        
            
        if (document.querySelectorAll('input.is-invalid').length !== 0)
          e.preventDefault();
      }

      function checkUniqueEmail(e) {
        if (e.value.length == 0)
          return showError(e, 'Email is required');
      
        if (!e.value.match(emailPattern)) {
          return showError(e, 'Invalid email');
        }
        showSuccess(e);
      
        const r = new XMLHttpRequest();
        r.onload = function () {
          let data = this.responseText;
          if (data == 'y')
            showSuccess(e);
          else
            showError(e, 'Email is already taken');
        };
        r.open('GET', `UniqueEmail.php?q=${e.value}`);
        r.send();
      }
  
</script>

<?php require 'bottom.php' ?>
<?php require 'footer.php' ?>