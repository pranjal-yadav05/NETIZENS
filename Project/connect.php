<?php
$con=mysqli_connect('localhost','root','','pranjal');
if(isset($_POST['sb']))
{
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    $query="INSERT INTO login-data(email,pass) VALUES ('$email','$pass')";
    $run=mysqli_query($con,$query);
}
?>