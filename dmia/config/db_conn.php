<?php

    // db connection

    $conn = mysqli_connect('localhost', 'dmiaC', 'passw', 'dmia');

    if(!$conn){
        echo 'Connection Error';
    }


?>