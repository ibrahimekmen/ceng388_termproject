<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
?>

<html>
    <head>
        <title>Profile</title>
        <link rel="stylesheet" type="text/css" href="./style.css">  
    </head>
    <body style='text-align: center;'>
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success" >
                <h3>
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                ?>
                </h3>
            </div>
        <?php endif ?>
        <?php if (isset($_SESSION['fail'])) : ?>
            <div class="error" >
                <h3>
                <?php 
                    echo $_SESSION['fail']; 
                    unset($_SESSION['fail']);
                ?>
                </h3>
            </div>
        <?php endif ?>
        <div class="topnav">
            <a href="./index.php">Home</a>
            <a href="./genres/genres.php">Genres</a>
            <a href="./cart.php">Cart</a>
            <a class="active" href="./profile.php">Profile</a>
            <a href="./index.php?logout='1'">Logout</a>
        </div>
        <h1>Profile</h1>
        <?php
            $db = mysqli_connect('localhost', 'root', '', 'finalproject');
            $image_check_query = "SELECT * FROM USERS WHERE id=" . $_SESSION['userid'] . ";";
            $result = mysqli_query($db, $image_check_query);
            $user =  mysqli_fetch_assoc($result);
            if(!$user['image']){
                echo "<img src='./uploads/placeholder.png' alt='profile picture placeholder'>";
            }else{
                $fileName = $user['image'];
                echo "<img src='./uploads/" . $fileName . "' alt='profile picture' style='max-width:25%; max-height:50%'>";
            }
        ?>
        <form action="./upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" required="">
            <button type="submit" name="upload">Upload/Change Profile Picture</button>
        </form>
        <h2>Name: <?php echo $_SESSION['username']?></h2>
        <h2>Email: <?php echo $user['email']?></h2>
        <form action="./server.php" method="post">
            <label for="oldpswd">Old Password:</label><br>
            <input type="text" id="oldpswd" name="oldpswd" required=''><br>
            <label for="newpswd">New Password:</label><br>
            <input type="password" id="pswd" name="pswd" required=''><br>
            <label for="newpswd2">New Password 2:</label><br>
            <input type="password" id="pswd2" name="pswd2" required=''><br>
            <button type="submit" name="changepswd">Change Password</button>
        </form>
    </body>
</html>