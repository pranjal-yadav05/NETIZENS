<!DOCTYPE html>
<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Gloock&family=Roboto+Slab&display=swap" rel="stylesheet">
        <link href="index.css" rel="stylesheet">
    </head>
    <body>
        <div  class="block">
        <h1>NETIZENS</h1><br>
        <h3>LOGIN / SIGN IN</h3>
        <br><br>
        <form autocomplete="off" method="post">
  <div class="mb-3">
    
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp"><br>
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1"  class="form-label">Password</label>
    <input type="password" class="form-control" name="pass" id="exampleInputPassword1">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" name="sb" class="btn">login</button>
  <br><small id="emailHelp" class="form-text">A place where Ideas grow</small><br>
</form>
<?php
$con=mysqli_connect('localhost','root','','pranjal');
if(isset($_POST['sb']))
{
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    $query="select * from log where email='$email' and pass='$pass'";
    $result=mysqli_query($con,$query);
    $count=mysqli_num_rows($result);
    if($count>0)
    {
      echo "<a href='home.php' class='lnk'>click here to proceed</a>";
    }
    else if($email=="" || $pass==""){
        echo "enter data";
    }
    else{
      echo "invalid";
    }
}
?>
    <br>
    New here? <a href="signup.php">Signup</a> 
    </div>
    </body>
    <script src="loginjs.js"></script>
</html>