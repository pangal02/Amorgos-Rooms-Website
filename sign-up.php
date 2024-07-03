<?php
include("database.php");
session_start();
?>

<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/styles/signUp.css">
    <style>
        .error {
            color: red;
        }
    </style>
    <title>ΝΕΟ ΚΑΤΑΛΥΜΑ? ΕΓΓΡΑΦΗ ΤΩΡΑ!</title>
</head>

<body>
    <header>
        <H1>ΕΓΓΡΑΦΗ ΝΕΟΥ ΧΡΗΣΤΗ!</H1>
        <nav>
            <input type="checkbox" id="check">
            <label for="check" class="checkBtn">
                <i class="fa-solid fa-bars"></i>
            </label>
            <ul>
                <li><a href="index.php">ΑΡΧΙΚΗ</a></li>
                <li><a href="find-a-room.php" target="_blank">ΒΡΕΣ ΚΑΤΑΛΥΜΑ</a></li>
                <li><a href="more.html">ΠΕΡΙΣΣΟΤΕΡΑ</a></li>
                <li><a href="sign-up.php">ΕΓΓΡΑΦΗ/ΣΥΝΔΕΣΗ</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form id="signupForm" name="signupForm" method="post" action="sign-up.php">
            <div class="register-link">
                <p>Do you have an account? <a href="login.php"> <strong>Login</strong></a></p>
            </div>
            <label for="name">*Όνομα Υπεύθυνου</label>
            <input type="text" id="name" name="name"> <br><br>

            <label for="lastname">*Επίθετο Υπεύθυνου</label>
            <input type="text" id="lastname" name="lastname"><br><br>

            <label for="nameCompany">*Επωνυμία Επιχείρησης</label>
            <input type="text" id="nameCompany" name="nameCompany"><br><br>

            <label for="phoneCompany">*Τηλέφωνο Επιχείρησης</label>
            <input type="tel" id="phoneCompany" name="phoneCompany"><br><br>

            <label for="email">*Email Επιχείρησης</label>
            <input type="email" id="email" name="email"><br><br>

            <label for="username">*Username</label>
            <input type="text" id="username" name="username"><br><br>

            <label for="password">*Password </label>
            <input type="password" id="password" name="password"><br><br>

            <label for="confirmPassword">*Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword"><br><br>

            <h6>*Υποχρεωτικά πεδία</h6>

            Καταχώρηση στοιχείων <input type="submit" name="sign-up" value="Καταχώρηση Καταλύματος">
        </form>
    </main>
</body>

</html>

<?php
function validateInput($name, $lastname, $company, $phone, $email, $username, $password, $confPassword)
{
    $errors = [];

    // Έλεγχος μη κενών τιμών
    if (empty($name)) {
        $errors[] = "*Το όνομα δεν πρέπει να είναι κενό.";
    }

    if (empty($lastname)) {
        $errors[] = "*Το επώνυμο δεν πρέπει να είναι κενό.";
    }

    if (empty($company)) {
        $errors[] = "*Η εταιρεία δεν πρέπει να είναι κενή.";
    }

    if (empty($phone)) {
        $errors[] = "*Το τηλέφωνο δεν πρέπει να είναι κενό.";
    }

    if (empty($email)) {
        $errors[] = "*Το email δεν πρέπει να είναι κενό.";
    }

    if (empty($username)) {
        $errors[] = "*Το όνομα χρήστη δεν πρέπει να είναι κενό.";
    }

    if (empty($password)) {
        $errors[] = "*Ο κωδικός πρόσβασης δεν πρέπει να είναι κενός.";
    }

    if (empty($confPassword)) {
        $errors[] = "*Η επιβεβαίωση κωδικού δεν πρέπει να είναι κενή.";
    }
    // Έλεγχος μήκους
    if (strlen($name) > 50) {
        $errors[] = "*Το όνομα δεν πρέπει να υπερβαίνει τους 50 χαρακτήρες.";
    }

    if (strlen($lastname) > 50) {
        $errors[] = "*Το επώνυμο δεν πρέπει να υπερβαίνει τους 50 χαρακτήρες.";
    }

    if (strlen($company) > 50) {
        $errors[] = "*Η εταιρεία δεν πρέπει να υπερβαίνει τους 100 χαρακτήρες.";
    }

    if (strlen($phone) != 10) {
        $errors[] = "*Το τηλέφωνο δεν πρέπει να υπερβαίνει τους 10 χαρακτήρες.";
    }

    if (strlen($username) > 50) {
        $errors[] = "*Το όνομα χρήστη δεν πρέπει να υπερβαίνει τους 30 χαρακτήρες.";
    }

    if (strlen($password) < 8) {
        $errors[] = "*Ο κωδικός πρόσβασης πρέπει να είναι τουλάχιστον 8 χαρακτήρες.";
    }


    // Έλεγχος έγκυρης μορφής email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "*Το email δεν είναι έγκυρο.";
    }

    // Έλεγχος έγκυρης μορφής τηλεφώνου
    if (!preg_match('/^\d+$/', $phone)) {
        $errors[] = "*Το τηλέφωνο πρέπει να περιέχει μόνο αριθμούς.";
    }

    if ($password !== $confPassword) {
        $errors[] = "*Ο κωδικός πρόσβασης και η επιβεβαίωση κωδικού δεν ταιριάζουν.";
    }

    return $errors;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, "nameManager", FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, "lastnameManager", FILTER_SANITIZE_SPECIAL_CHARS);
    $company = filter_input(INPUT_POST, "nameCompany", FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, "phoneCompany", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "emailCompany", FILTER_VALIDATE_EMAIL);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $username = trim($username);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $confPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = trim($password);
    $confPassword = trim($confPassword);
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $errors = validateInput($name, $lastname, $company, $phone, $email, $username, $password, $confPassword);


    if (empty($errors)) {
        try {
            $sqlUser = "INSERT INTO registered_user (nameManager, lastnameManager, nameCompany, phoneCompany, emailCompany, username, password)
                            VALUES ('$name', '$lastname', '$company', '$phone', '$email', '$username', '$password')";
            mysqli_query($conn, $sqlUser);
            $_SESSION["user_role"] = "reg_user";
            echo "*Η εγγραφή χρήστη ολοκληρώθηκε!." . PHP_EOL;
            header("Location: login.php");
        } catch (mysqli_sql_exception $e) {
            echo "*Μία από τις εγγραφές που δώσατε χρησιμοποιείται ήδη." . $e . PHP_EOL;
        }
    } else {
        echo "Σφάλμα:" . PHP_EOL;
        foreach ($errors as $error) {
            echo "<div class=\"error\">" . $error . "</div>" . PHP_EOL;
        }
    }
}
mysqli_close($conn);
?>