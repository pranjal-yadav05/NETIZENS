<!DOCTYPE html>
<html>
    <head>
        <link href="style.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Gloock&family=Roboto+Slab&display=swap" rel="stylesheet">
    </head>
    <body>
    <nav id="123" class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <div class="logo">NETIZENS</div>&nbsp &nbsp
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            More
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="settings.php">Settings</a></li>
            <li><button class="dropdown-item" class="abc" href="">Rate us</button></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="index.php">Log out</a></li>
          </ul>
          <li class="nav-item">
          <a class="nav-link" href="rps.php">Games</a>
        </li>
            
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav><br>
<div class="box">
  
<div class="friends">
  <button class="mains"><b>Friends & Freaks</b></button>
  <button class="main">Megh</button>
  <button class="main">Anish</button>
  <button class="main">Vatsal</button>
  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
</svg>
  <i class="bi bi-plus"></i>
</div>
<div class="container">
  <form method="post" autocomplete="off">
  NAME: <input type="text" name="naam" class="feel" class="name">
  <input type="text" placeholder="What's cookin?" name="talk" class="feel"> 
  <button class="add" type="submit" name="sb">add</button>
  
  

</form><?php

$conn=mysqli_connect('localhost','root','','chats');

$sql = "SELECT date, name, exp FROM msgs";
$result = mysqli_query($conn, $sql);
$row=mysqli_num_rows($result);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  echo "<br>";
  while($row = mysqli_fetch_assoc($result)) {
    echo $row["date"]." ".$row["name"]."<br>". $row["exp"]. "<hr><br>";
  }
  
}

if(isset($_POST['sb']))
{
$name=$_POST['naam'];
$comment=$_POST['talk'];
$dt=date("h:i  a,d.m.y");

if($name=="")
{
  echo "<small>Name not entered!</small>";
}
else if($comment==""){
  echo "<small>Comment is blank!</small>";
}
else
{$q="INSERT INTO msgs(date,name,exp) VALUES ('$dt','$name','$comment')";
$run=mysqli_query($conn,$q);
}}?>
</div>
</div>
 
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="loginjs.js"></script>  
    </html>