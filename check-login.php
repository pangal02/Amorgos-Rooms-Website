<?php
session_start();
function checkAdmin($username){
    $loewrcase = strtolower($username);
    if(strpos($loewrcase, 'admin') !== false){
        return true;
    }
    else{
        return false;
    }
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    if(checkAdmin($username)){
        header("Location: admin-profile.php");
    }
    else{
        header("Location: user-profile.php");
    }
    
    exit();
}
 else {
    header("Location: login.php");
    exit();
}
?>
