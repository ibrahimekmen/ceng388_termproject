<?php 
    session_start(); 

    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_POST['addToCart'])) {
        $gameid = $_POST['id'];
        $userid = $_SESSION['userid'];
        $db = mysqli_connect('localhost', 'root', '', 'finalproject');
        $cart_item_check_query = "SELECT * FROM shoppingcart WHERE userid='$userid' AND gameid='$gameid' LIMIT 1";
        $result = mysqli_query($db, $cart_item_check_query);
        $cart_item = mysqli_fetch_assoc($result);
        if ($cart_item) { // if user exists
            $_SESSION['cart_fail'] = $_POST['name'] . " already in cart";
        }else{
            $add_to_cart_query = "INSERT INTO shoppingcart (userid , gameid) VALUES('$userid', '$gameid') ";
            mysqli_query($db, $add_to_cart_query);
            $_SESSION['cart_success'] = "You have added " . $_POST['name']. " to your cart";
        }
    }

       

?>

<html>
    <head>
        <title><?php echo $genre; ?></title>
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
        <?php if (isset($_SESSION['cart_success'])) : ?>
                    <div class="error success" >
                        <h3>
                        <?php 
                            echo $_SESSION['cart_success']; 
                            unset($_SESSION['cart_success']);
                        ?>
                        </h3>
                    </div>
        <?php endif ?>
        <?php if (isset($_SESSION['cart_fail'])) : ?>
                    <div class="error" >
                        <h3>
                        <?php 
                            echo $_SESSION['cart_fail']; 
                            unset($_SESSION['cart_fail']);
                        ?>
                        </h3>
                    </div>
        <?php endif ?>
        <h1><?php echo $genre; ?></h1>
        <table style='margin:auto; text-align: center;'>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price($)</th>
                <th>Add to Cart</th>
            </tr>
            <?php
                $db = mysqli_connect('localhost', 'root', '', 'finalproject');
                $user_check_query = "SELECT * FROM games WHERE genre='" . $genre . "'";
                $results = mysqli_query($db, $user_check_query);
                $games = mysqli_fetch_all($results,MYSQLI_ASSOC);
                foreach ($games as $game) :
                    echo "<tr>";
                    echo "<td>" . $game['name'] . "</td>";
                    echo "<td>" . $game['description'] . "</td>";
                    echo "<td>" . $game['price'] . "</td>";
                    echo "<td>
                        <form method='post' action=''>
                            <input type='hidden' name='id' value='". $game['id'] ."'/>
                            <input type='hidden' name='name' value='". $game['name'] ."'/>
                            <button type='submit' class='btn' name='addToCart'>X</button>
                        </form>
                    </td>";
                    echo "</tr>";
                endforeach
            ?>
        </table>
    </body>
</html>