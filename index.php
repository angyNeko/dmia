<?php

    include('config/db_conn.php');
    include('config/signin.php');
    


?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            D-MIA Super Admin Login
        </title>

        <link rel="stylesheet" type="text/css" href="css/login.css" />

    </head>

    <body>

        <img src="images/logo/dmialogo.jpg">

        <h1>Login</h1>

        <div class="loginblue">
            <form action="index.php" method="POST">
                <label>UID</label> <br>
                <input type="text" name="uid"> <br>

                <label>Password</label> <br>
                <input type="password" name="password"> <br>

                <input type="submit" id="submit" name="submit" 
                value="Login"> </input>

                
            </form>
            
        </div>

    </body>
</html>