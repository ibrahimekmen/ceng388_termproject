<?php
    session_start();
    include("./file_write.php");
    $db = mysqli_connect('eu-cdbr-west-02.cleardb.net', 'bc32387609d527', '6870312e', 'heroku_37c37043f7fc84a');
    $cart_games_query = "SELECT * FROM shoppingcart WHERE userid='" . $_SESSION['userid'] . "'";
    $results = mysqli_query($db, $cart_games_query);
    $shoppingcartitems = mysqli_fetch_all($results,MYSQLI_ASSOC);
    $games = array(); 
    foreach($shoppingcartitems as $item):
        $game_query = "SELECT * FROM games WHERE id='" . $item['gameid'] . "'";
        $results = mysqli_query($db, $game_query);
        $game = mysqli_fetch_assoc($results);
        array_push($games, $game);  
    endforeach; 
        
    if (isset($_POST['removeFromCart'])) {
        $gameid = $_POST['gameid'];
        $userid = $_SESSION['userid'];
        $db = mysqli_connect('eu-cdbr-west-02.cleardb.net', 'bc32387609d527', '6870312e', 'heroku_37c37043f7fc84a');
        $remove_from_cart_query = "DELETE FROM shoppingcart WHERE gameid='". $gameid . "' AND userid='". $userid . "' LIMIT 1;";
        mysqli_query($db, $remove_from_cart_query);
        echo "You have removed " . $_POST['name']. " from your cart";
        write_file($_SESSION['username'] . 'have removed ' . $_POST['name'] . ' from their cart');
        $_SESSION['remove_success'] = "You have removed " . $_POST['name']. " from your cart";
        header("location: cart.php");
    }
?>

<html>
    <head>
        <title><?php echo "Shopping Cart"; ?></title>
        <link rel="stylesheet" type="text/css" href="./style.css">
    </head>
    <body style='text-align: center;'>
        <?php if (isset($_SESSION['remove_success'])) : ?>
                    <div class="error success" >
                        <h3>
                        <?php 
                            echo $_SESSION['remove_success']; 
                            unset($_SESSION['remove_success']);
                        ?>
                        </h3>
                    </div>
        <?php endif ?>
        <div class="topnav">
            <a href="./index.php">Home</a>
            <a href="./genres/genres.php">Genres</a>
            <a class="active" href="./cart.php">Cart</a>
            <a href="./profile.php">Profile</a>
            <a href="./index.php?logout='1'">Logout</a>
        </div>
        <?php 
            if(empty($games)):
                echo "Your Shopping Cart is empty <br>";
            else: ?>
        <table style='margin:auto; text-align: center;'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Genre</th>
                    <th>Description</th>
                    <th>Price($)</th>
                    <th>Remove From Cart</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $total_price = 0;
                foreach ($games as $game) :
                    echo "<tr>";
                    echo "<td>" . $game['name'] ."</td>";
                    echo "<td>" . $game['genre'] . "</td>";
                    echo "<td>" . $game['description'] . "</td>";
                    echo "<td>" . $game['price'] . "</td>";
                    echo "<td>
                        <form method='post' action=''>
                            <input type='hidden' name='gameid' value='". $game['id'] ."'/>
                            <input type='hidden' name='name' value='". $game['name'] ."'/>
                            <button type='submit' class='btn' name='removeFromCart'>X</button>
                        </form>
                    </td>";
                    echo "</tr>";
                    $total_price += $game['price'];
                endforeach;
            endif;
            ?>
        </tbody>
        </table>
        <?php 
            if(!empty($games)):
                echo "<p>Total Price: " . $total_price . "</p>";
            endif
        ?>
    </body>
</html>
