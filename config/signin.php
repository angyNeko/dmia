<?php 

    include('config/db_conn.php');
    include_once('config/functions.php');

    


    if(isset($_POST['submit'])){

        $uid = $_POST['uid'];
        $password = $_POST["password"];

        if(emptInL($uid, $password) !== false) {
            header("Location: indexphp?error=emptyinput");

        loginuser($conn, $uid, $password);

        } else {
            header("Location: indexphp?error=emptyinput");
        }

    }

?>