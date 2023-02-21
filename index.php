<?php 
#include 'config.php';
$conn = mysqli_connect("localhost","root","", "ismt") or die("<script>alert('Connection failed')</script>");
session_start();

error_reporting(0);

if (isset($_SESSION['username'])) {
    header("Location: welcome.php");
}

if (isset($_POST['submit'])) 
{
	
	$email = $_POST['email'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM login WHERE email='$email' AND password='$password'";
	$result = mysqli_query($conn, $sql);
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['username'] = $row['username'];
		header("Location: welcome.php");
	} else {
		echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
	}
}
$msg = "";
if(!empty($_SESSION["id"])){
  header("Location: index.php");
}
if(isset($_POST["submit1"]))
{
  $name = $_POST["name"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = md5($_POST["password"]);
  $confirmpassword = md5($_POST["confirmpassword"]);
  $duplicate = mysqli_query($conn, "SELECT * FROM login WHERE username = '$username' OR email = '$email'");
  if(mysqli_num_rows($duplicate) > 0){
    echo
    "<script> alert('Username or Email Has Already Taken'); </script>";
  }
  else if($password !== $confirmpassword){
      echo
      "<script> alert('Password Does Not Match'); </script>";

    }
    else if ($_POST["captcha"] != $_SESSION["captcha_code"] OR $_SESSION["captcha_code"]=='')  {
    echo "<script>alert('Incorrect verification code');</script>" ;


  } 
    
  else{
  
      $query = "INSERT INTO login VALUES('$name','$username','$email','$password')";
      mysqli_query($conn, $query);
      echo
      "<script> alert('Registration Successful'); </script>";       
}
  }
    



?>


<html>
    <head>
        <title>Login And Registration Form </title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="hero">
        <div class="form-box">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="login()">Log In</button>
                <button type="button" class="toggle-btn" onclick="register()">Register</button>

            </div>
            <form id="login"   class="input-group">
                <input type="text" class="input-field" placeholder="User Id" required>
                <input type="text" class="input-field" placeholder="Enter Password" required>
                <input type="checkbox" class="check-box"><span>Remember Password</span>
                <button name="submit" class="submit-btn">Log in</button>


            </form>
            <form id="register"   class="input-group">
                <input type="text" class="input-field" placeholder="User Name" required>
                <input type="email" class="input-field" placeholder="Email Id" required>

                <input type="text" class="input-field" placeholder="Enter Password" required>
                <input type="text" class="input-field" placeholder="Confirm Password" required>
                <input type="text" placeholder="Enter Captcha" name="captcha" id="captcha" required class="input-field">
                <img src="captcha.php"/>
                <div>
                <input type="checkbox" class="check-box"><span>I agree to the terms & conditions</span></div>
                <button name="submit1" class="submit-btn">Register</button>


            </form>
        </div>
        
        </div>
        <script>
            var x = document.getElementById("login");
            var y = document.getElementById("register");
            var z = document.getElementById("btn");

            function register(){
                x.style.left = "-400px";
                y.style.left = "50px";
                z.style.left = "110px";

            }
            function login(){
                x.style.left = "50px";
                y.style.left = "450px";
                z.style.left = "0px";

            }


        </script>
    </body>
</html>