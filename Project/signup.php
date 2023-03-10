<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Gloock&family=Roboto+Slab&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="sign.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <h1>NETIZENS</h1>
    <h3><small>get your Netizenship now</small></h3>
    <form autocomplete="off" method="post">
    Fullname <input class="name" name="naam"><br>
    Date of Birth <input class="dob" name="db"><br>
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
    
  <button type="submit" name="sb" class="btn btn-primary">Submit</button>
  <br>
</form >
    <?php
$con=mysqli_connect('localhost','root','','pranjal');
if(isset($_POST['sb']))
{
    $name=$_POST['naam'];
    $dob=$_POST['db'];
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    if($name=="" || $dob=="" || $email=="" || $pass=="")
    {
      echo "no data entered";
      
    }
    else{
    $query="INSERT INTO log(fname,dob,email,pass) VALUES ('$name','$dob','$email','$pass')";
    $run=mysqli_query($con,$query);
    }
}
?>
<br>
<a href="index.php">Login here</a>
<br><hr>
<div class="info">
    We hereby assure that credentials here entered by you will be held private
and will not be available anywhere over the world wide web.</div>
</body>
</html>