<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
?>

<html>
    <head>
        <title>Genres</title>
        <link rel="stylesheet" type="text/css" href="../style.css">  
    </head>
    <body style='text-align: center;'>
        <div class="topnav">
            <a href="../index.php">Home</a>
            <a class="active" href="./genres.php">Genres</a>
            <a href="../cart.php">Cart</a>
            <a href="../profile.php">Profile</a>
            <a href="../index.php?logout='1'">Logout</a>
        </div>
        <h1>Genres</h1>
        <table style='margin:auto; text-align: center;'>
            <tr>
                <td>Action</td>
            </tr>
            <tr>
                <td><a href="./action.php"><img src=./genre_images/action.jpg style='max-width:30%'></a></td>
            </tr>
            <tr>
                <td>Fighter</td>
            </tr>
            <tr>
                <td><a href="./fighter.php"><img src=./genre_images/fighter.jpg style='max-width:30%'></a></td>
            </tr>
            <tr>
                <td>FPS</td>
            </tr>
            <tr>
                <td><a href="./fps.php"><img src=./genre_images/fps.jpg style='max-width:30%'></a></td>
            </tr>
            <tr>
                <td>MOBA</td>
            </tr>
            <tr>
                <td><a href="./moba.php"><img src=./genre_images/moba.jpg style='max-width:30%'></a></td>
            </tr>
            <tr>
                <td>Platformer</td>
            </tr>
            <tr>
                <td><a href="./platformer.php"><img src=./genre_images/platformer.jpg style='max-width:30%'></a></td>
            </tr>
            <tr>
                <td>Puzzle</td>
            </tr>
            <tr>
                <td><a href="./puzzle.php"><img src=./genre_images/puzzle.jpg style='max-width:30%'></a></td>
            </tr>
            <tr>
                <td>RTS</td>
            </tr>
            <tr>
                <td><a href="./rts.php"><img src=./genre_images/rts.jpg style='max-width:30%'></a></td>
            </tr>
            <tr>
                <td>Simulation</td>
            </tr>
            <tr>
                <td><a href="./simulation.php"><img src=./genre_images/simulation.jpg style='max-width:30%'></a></td>
            </tr>
        </table>
    </body>
</html>