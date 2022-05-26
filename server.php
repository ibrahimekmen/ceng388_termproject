<?php
    session_start();
    include("./file_write.php");

    $username = "";
    $email    = "";
    $errors = array(); 

    $db = mysqli_connect('eu-cdbr-west-02.cleardb.net', 'bc32387609d527', '6870312e', 'heroku_37c37043f7fc84a');

    if (isset($_POST['reg_user'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

        if (empty($username)) { array_push($errors, "Username is required"); }
        if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($password_1)) { array_push($errors, "Password is required"); }
        if ($password_1 != $password_2) {
            array_push($errors, "The two passwords do not match");
        }

        $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
        $result = mysqli_query($db, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        
        if ($user) { 
            if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
            }

            if ($user['email'] === $email) {
            array_push($errors, "email already exists");
            }
        }

        if (count($errors) == 0) {
            $password = md5($password_1);
            $query = "INSERT INTO users (username, email, password) 
                    VALUES('$username', '$email', '$password')";
            mysqli_query($db, $query);
            $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $results = mysqli_query($db, $query);
            $user = mysqli_fetch_assoc($results);
            $_SESSION['userid'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            write_file($username . ' registered to the system with email: ' . $email . ' password: ' . $password);
            header('location: index.php');
        }else{
            echo count($errors);
        }
    }

    if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
    
        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }
    
        if (count($errors) == 0) {
            $password = md5($password);
            $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $results = mysqli_query($db, $query);
            if (mysqli_num_rows($results) == 1) {
                $user = mysqli_fetch_assoc($results);
                $_SESSION['username'] = $username;
                $_SESSION['userid'] = $user['id'];
                $_SESSION['success'] = "You are now logged in";
                write_file($username . ' logged in');
                header('location: index.php');
            }else {
                write_file('Login failed. Wrong username/password combination');
                array_push($errors, "Wrong username/password combination $password");
            }
        }
    }

    if (isset($_POST['changepswd'])) {
        $oldpassword = mysqli_real_escape_string($db, $_POST['oldpswd']);
        $newpassword = mysqli_real_escape_string($db, $_POST['pswd']);
        $newpassword2 = mysqli_real_escape_string($db, $_POST['pswd2']);
        $username = $_SESSION['username'];
        $userid = $_SESSION['userid'];

        if ($newpassword != $newpassword2) {
            array_push($errors, "The two passwords do not match");
            write_file($username . ': password change failed. The two passwords do not match');
            header('location: profile.php');
        }

        $oldpassword = md5($oldpassword);
        $query = "SELECT * FROM users WHERE id='$userid' AND password='$oldpassword'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $newpassword = md5($newpassword);
            $update_password = "UPDATE users SET password='$newpassword' WHERE id=$userid";
            $result = mysqli_query($db, $update_password);
            $_SESSION['success'] = "You have updated your password successfully";
            write_file($username . ' have updated their password from ' . $oldpassword . ' to ' . $newpassword);
            header('location: profile.php');
        }else {
            write_file($username . ': password change failed. The old password entered does not match the current password');
            $_SESSION['fail'] = "The old password you entered does not match your current password";
        }
    }
  
?>
