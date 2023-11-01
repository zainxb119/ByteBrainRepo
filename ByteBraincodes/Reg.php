<?php
require 'header.php';



$success_message = "";
$uname_pattern = '/^[a-zA-Z0-9_.-]{4,25}$/';
$fname_pattern = '/^[a-zA-Z]{3,25}$/';
$lname_pattern = '/^[a-zA-Z]{3,25}$/';
$email_pattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}/';
$dob_pattern = '/^19[5-9]\d|200[0-5]$/';
$pass_pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9_.-]{8,25}$/';

if (isset($_POST['submit'])) {
    $incorrectinput=0;
    $errors[]="";

    $fname = $_POST['fname'];
    if (!preg_match($fname_pattern, $fname)){
        $errors[]="First name is only letters";
        $incorrectinput++;}
    $lname = $_POST['lname'];
    if (!preg_match($lname_pattern, $lname)){
        $incorrectinput++;
        $errors[]="Last name is only letters";}
    $uname = $_POST['uname'];
    if (!preg_match($uname_pattern, $uname)){
        $incorrectinput++;
        $errors[]="Username is a mixture af alphabets, digits and _-.";}
    $email = $_POST['email'];
    if (!preg_match($email_pattern, $email)){
        $incorrectinput++;
        $errors[]="Invalid email";}
    $dob = $_POST['dob'];
    if (!preg_match($dob_pattern, $dob)){
        $incorrectinput++;
        $errors[]="Choose birth year between 1995 and 2003";}
    $pass = $_POST['password'];
    if (!preg_match($pass_pattern, $pass)){
        $incorrectinput++;
        $errors[]="Password must contain at least one upper case,lower case and digit (8-25 characters)";}
    $cpass = $_POST['cpassword'];
    

    if (trim($fname) == "" || trim($lname) == "" || trim($uname) == "" || trim($email) == "" ||
        trim($dob) == "" || trim($pass) == "" || trim($cpass) == "") {
        $errors[] = "Missing information";}
         else if ($pass != $cpass) {
             $errors[] = "Password and Confirm Password do not match";}
         else if ($incorrectinput==0) {
    try {
            require 'connection.php';
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $db->beginTransaction();

            $data = $db->prepare("INSERT INTO users (firtsname, lastname, username, password, email, birthyear) VALUES (?,?,?,?,?,?)");
            $data->bindParam(1, $fname);
            $data->bindParam(2, $lname);
            $data->bindParam(3, $uname);
            $data->bindParam(4, $pass);
            $data->bindParam(5, $email);
            $data->bindParam(6, $dob);

            $data->execute();
            $userID = $db->lastInsertId();
            $db->commit();
            $success_message = "Signup successful!";
        
    } catch (PDOException $e) {
        $db->rollBack();
        die($e->getMessage());
    }
}
}
?>

<div class="container align-items-center text-center mt-5 pb-5">
    <div class="jumbotron col-sm-9 col-lg-5 my-auto mx-auto p-5" style="background-color: #ffffff89; color:black; backdrop-filter: blur(5px); border-radius: 20px; box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.5); ">
        <h1 class="display-6">Sign up to ByteBrain</h1>
        <hr class="my-4">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-light" role="alert">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ($success_message !== ""): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
                <br>
                <a href="login.php" style="color: #062747;">Login now</a>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label>First Name:</label>
                <input class="form-control" type="text" name="fname"/>
            </div>
            <div class="form-group">
                <label>Last Name:</label>
                <input class="form-control" type="text" name="lname"/>
            </div>           
             <p><span id="uname"></span></p>
            <div class="form-group">
                <label>Username:</label>
                <input class="form-control" type="text" name="uname" onkeyup="showSuggestion(this.value)"/>
            </div>
            <div class="form-group">
            <p><span id="email1"></span></p>
                <label>E-mail:</label>
                <input class="form-control" type="email" name="email" onkeyup="emailexists(this.value)"/>
            </div>
            <div class="form-group">
                <label>Birth Year:</label>
                <input class="form-control" type="number" name="dob" />
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input class="form-control" type="password" name="password"/>
            </div>
            <div class="form-group">
                <label> Confirm Password:</label>
                <input class="form-control" type="password" name="cpassword"/>
            </div>
            <button type="submit" name="submit" id="btn" class="btn btn-primary">Create Account</button>
            <div class="mt-3">Already have an account? <a href="login.php" style="color: #062747;">Login here</a></div>
        </form>
    </div>
</div>
<script src="signup1"></script>
<script>

function showSuggestion(str){
if (str.length==0)
{document.getElementById("uname").innerHTML="";
return;}
const xhttp= new XMLHttpRequest();
xhttp.onload= function(){
document.getElementById("uname").innerHTML=this.responseText;
if (this.responseText.includes("taken"))
document.getElementById("btn").disabled=true;
else
document.getElementById("btn").disabled=false;
}
xhttp.open("GET","Sugfun.php?q="+str);
xhttp.send();
}

function emailexists(str2){
if (str2.length==0)
{document.getElementById("email1").innerHTML="";
return;}
const xhttp1= new XMLHttpRequest();
xhttp1.onload= function(){
document.getElementById("email1").innerHTML=this.responseText;
if (this.responseText.includes("taken"))
document.getElementById("btn").disabled=true;
else
document.getElementById("btn").disabled=false;
}
xhttp1.open("GET","emailfun.php?r="+str2);
xhttp1.send();
}
</script>

<?php require 'bottom.php'; ?>
<?php require 'footer.php'; ?>
