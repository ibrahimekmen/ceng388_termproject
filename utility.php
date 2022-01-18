<?php 
//https://stackoverflow.com/questions/4315271/how-to-pass-arguments-to-an-included-file
function getGamesByGenre($genre) {
    include("./genre_template.php");
}
?>