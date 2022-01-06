<?php

    //header('Location: '.$uri.'/dmia/');
	//exit;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            D-MIA Super Admin Login
        </title>

        <link rel="stylesheet" type="text/css" href="css/login.css" />

        <script>
            function redi() {
                location.href = "saHome.php";
            }
        </script>
    </head>

    <body>

        <img src="images/dmialogo.jpg">

        <h1>Login</h1>

        <div class="loginblue">
            <form>
                <label>UID</label> <br>
                <input type="text"> <br>
                <label>Password</label> <br>
                <input type="password"> <br>
                <button id="submit" onclick="redi()">
                <a href="saHome.php">Login</a>
                </button>

                
            </form>
            
        </div>

    </body>
</html>