<?php 
session_start();
$userid = $_SESSION['userid'];

if (isset($_POST['upload'])) {
    $file = $_FILES['file'];
    
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', "jpeg", "png");
    if (in_array($fileActualExt, $allowed)){
        if ($fileError == 0){
            if($fileSize > 100000){
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestionation = "./uploads/" . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestionation);
                $db = mysqli_connect('eu-cdbr-west-02.cleardb.net', 'bc32387609d527', '6870312e', 'heroku_37c37043f7fc84a');
                $update_profile_picture = "UPDATE users SET image='$fileNameNew' WHERE id=$userid";
                $result = mysqli_query($db, $update_profile_picture);
                echo "profile pic upload success";
                write_file($_SESSION['username'] . 'have updated their profile picture');
                header('location: profile.php');
            }else{
                echo "Your file is too big";
                echo $fileSize;
            }
        }else{
            echo "there was an error";
        }
    }else{
        echo "You cannot upload this file type!";
    }
    header('location: profile.php');
}

?>
