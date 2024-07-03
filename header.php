<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Ο χρήστης δεν είναι συνδεδεμένος
    echo "Για την προβολή της συγκεκριμένης σελίδας απαιτείτε σύνδεση πρωτα";
    header("Location: login.php");
    die;
}
else {
    if ($_SESSION['user_role'] === "admin") {
        $isAdmin = true;
    } 
    else {
        $isAdmin = false;

    }
}
