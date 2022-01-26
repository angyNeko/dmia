<?php 

    include('config/db_conn.php');
    include_once('config/functions.php');

    if(isset($_POST['submit'])){
        
    $uid = $_POST['uid'];
    $password = $_POST['password'];  

        if(empty($uid) || empty($password)) {
            echo "Field cannot be empty";
        } else {
            loginuser($conn, $uid, $password);
        }

    }

?>