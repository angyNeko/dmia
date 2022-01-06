<?php


function uidExs($conn, $uid) {

    $uidE = "SELECT * FROM superads WHERE uid = ?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $uidE)) {
        header("Location: index.php?error=invaliduid");
    }

    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);

    $resDat = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resDat)) {
        return $row;
    } else {
        $result = false;
    }

    mysqli_stmt_close($stmt);

}

function emptInL($uid, $password){
    if (empty($uid) || empty($password)){
        $result = true;
    }   else {
        $result = false;
    }
}

function loginuser($conn, $uid, $password){
    $uidExists = uidExs($conn, $uid);

    if ($uidExists === false) {
        header("location: indexphp?error=inputdoesnotmatch");

        $dbps = $uidExists["passwrd"];
        $chkp = password_verify($password, $dbps);

        if ($chkp === false) {
            header("location: indexphp?error=inputdoesnotmatch");
        } else if ($chkp === true) {
            session_start();
            $_SESSION["userid"] = $uidExists("fname", "lname");
            header("location: saHome.php");
            exit();
        }
    }
}