<!DOCTYPE html>
<html>
<head>
<meta name="viewport",content="width=device-width,initial-scale=10">
<meta charset="UTF-8">
<style>
.container{
    background-color:LightSteelBlue;
    border-radius:5px;
    height:auto;
    font-size:40px;
    margin:0px 100px;
    border-style: solid;
    text-align:center;
    
}
.backcolor{
    background-color: Lavender;
    
}
.text-center{
    font-family:fantasy;
    background-color:black;
    color:white;
    text-align:center;
    font-size:70px;
    width:100vw;
    justify-content:center;
    position: fixed;
    margin-top:0;
    margin-bottom:5px;
}
.res,.ai-inp,.user-inp{
    text-align:center;
    background-color:gray;
    color:white;
    font-size:20px;
   
    
}
.content{
    margin-top:50px;
    text-align:center;
    font-family:fantasy;
    font-size:20px;
    background-color:beige;
    border:solid black;
}
.in{
    margin:20px 20px;
}
.butt{
    color:LightSlateGray;
    font-size:40px;
    background-color:LightSeaGreen;
}
.end{
    font-family:arial;
    font-size:20px;
    
}
body{
    background-image:url("images.jpg");
}
</style>


</head>
<body class="backcolor" id="b">
<h1 class="text-center">
ROCK PAPER SCISSOR </h1><br>
<hr><br>
<div class="content"><br>This is simple game of rock-paper-scissor.<br>
enter Rock,Paper or Scissor in your entry.<br>
then, press submit.<br><br></div>
<br><hr><br>
<div class="container"><br>

<div class="in">
Your entry:<input type="text" class="user-inp"><br><br>
My response:<input type="text" class="ai-inp"><br><br>
Result:<input type="text" class="res"><br><br>
<button class="butt">submit</button>
</div>

</div>
<br><br><hr><br>
<div class="end">
<h3>Origins of game:</h3><br>
Rock paper scissors (also known by other orderings of the three items, with "rock" sometimes being called "stone," or as Rochambeau, roshambo, or ro-sham-bo)[1][2][3] is a hand game originating in China, usually played between two people, in which each player simultaneously forms one of three shapes with an outstretched hand. These shapes are "rock" (a closed fist), "paper" (a flat hand), and "scissors" (a fist with the index finger and middle finger extended, forming a V).
</div>
</body>
<script>

var ui;

var mi;

var subbutton=document.querySelector('.butt');
subbutton.addEventListener('click',()=>{

var k=Math.random()*3;

if(k<1)
{
    document.querySelector('.ai-inp').value="Rock";
}
else if(k<2)
{
    document.querySelector('.ai-inp').value="Paper";
}
else 
{
    document.querySelector('.ai-inp').value="Scissor";
}
mi=document.querySelector('.ai-inp').value;
ui=document.querySelector('.user-inp').value;
if(ui==mi)
{
    document.querySelector('.res').value="no one won";
}
else if(ui=="Rock" && mi=="Scissor")
{
    document.querySelector('.res').value="you won";
}
else if(ui=="Paper" && mi=="Scissor")
{
    document.querySelector('.res').value="i won";
}
else if(ui=="Rock" && mi=="Paper")
{
    document.querySelector('.res').value="i won";
}
else if(ui=="Scissor" && mi=="Paper")
{
   document.querySelector('.res').value="you won";
}
else if(ui=="Paper" && mi=="Rock")
{
    document.querySelector('.res').value="you won";
}
else if(ui=="Scissor" && mi=="Rock")
{
    document.querySelector('.res').value="i won";
}

}) 
   
</script>
</html>