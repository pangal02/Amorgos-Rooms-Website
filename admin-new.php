<?php
session_start();
include("database.php");
include("header.php");
?>

<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ΛΟΓΑΡΙΑΣΜΟΣ - Amorgos Rooms</title>
    <link rel="stylesheet" type="text/css" href="styles/styleIndex.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <header>
        <h1>Amorgos Rooms</h1>
        <H2>Λογαριασμός ADMINISTRATOR</H1>
            <nav>
                <input type="checkbox" id="check">
                <label for="check" class="checkBtn">
                    <i class="fa-solid fa-bars"></i>
                </label>
                <ul>
                    <li><a href="index.php">ΑΡΧΙΚΗ</a></li>
                    <li><a href="find-a-room.php">ΒΡΕΣ ΚΑΤΑΛΥΜΑ</a></li>
                    <li><a href="more.html">ΠΕΡΙΣΣΟΤΕΡΑ</a></li>
                    <li><a href="create-page.php">ΔΗΜΙΟΥΡΓΙΑ ΣΕΛΙΔΑΣ</a></li>
                    <?php if (isset($_SESSION['username'])) : ?>
                        <?php if ($isAdmin) : ?>
                            <li><a href="admin-profile.php">ΠΡΟΦΙΛ</a></li>
                            <p><a href="logout.php">Logout</a></p>
                        <?php else : ?>
                            <li><a href="user-profile.php">ΠΡΟΦΙΛ</a></li>
                            <p><a href="logout.php">Logout</a></p>
                        <?php endif; ?>
                    <?php else : ?>
                        <li><a href="check-login.php">ΕΓΓΡΑΦΗ/ΣΥΝΔΕΣΗ</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
    </header>

    <main>
        <h2>Προσθήκη διαχειρηστή</h2>

        <form method="post" action="admin-new.php">
            <label for="name">*Όνομα Διαχειρηστή</label>
            <input type="text" id="name" name="nameAdmin"> <br><br>

            <label for="lastname">*Επίθετο Διαχειρηστή</label>
            <input type="text" id="lastname" name="lastnameAdmin"><br><br>

            <label for="email">*Email Διαχειρηστή</label>
            <input type="email" id="email" name="emailAdmin"><br><br>

            <label for="username">*Username</label>
            <input type="text" id="username" name="usernameAdmin"><br><br>

            <label for="password">*Password </label>
            <input type="password" id="password" name="passwordAdmin"><br><br>

            <label for="confirmPassword">*Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPasswordAdmin"><br><br>

            <h6>*Υποχρεωτικά πεδία</h6>

            Καταχώρηση στοιχείων <input type="submit" name="sign-up" value="Καταχώρηση Διαχειρηστή">
        </form>
    </main>
    <aside class="left-aside">
        <ul>
            <li><a href="admin-profile.php">Λογαριασμός</a></li>
            <li><a href="admin-data-profile.php">Στοιχεία λογαριασμού</a></li>
            <li><a href="admin-list-of-users.php">Πίνακας εγγεγραμένων χρηστών</a></li>
            <li><a href="admin-new.php">Προσθήκη διαχειρηστή</a></li>
        </ul>
    </aside>
</body>

</html>

<?php
function hello()
{
    echo "<p>Γειά σου {$_SESSION['name']}!</p>";
}

function validateInput($name, $lastname, $email, $username, $password, $confPassword)
{
    $errors = [];

    if (empty($name)) {
        $errors[] = "*Το όνομα δεν πρέπει να είναι κενό.";
    }

    if (empty($lastname)) {
        $errors[] = "*Το επώνυμο δεν πρέπει να είναι κενό.";
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

    if ($password !== $confPassword) {
        $errors[] = "*Ο κωδικός πρόσβασης και η επιβεβαίωση κωδικού δεν ταιριάζουν.";
    }

    return $errors;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, "nameAdmin", FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, "lastnameAdmin", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "emailAdmin", FILTER_VALIDATE_EMAIL);
    $username = filter_input(INPUT_POST, "usernameAdmin", FILTER_SANITIZE_SPECIAL_CHARS);
    $username = trim($username);
    $password = filter_input(INPUT_POST, "passwordAdmin", FILTER_SANITIZE_SPECIAL_CHARS);
    $confPassword = filter_input(INPUT_POST, "confirmPasswordAdmin", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = trim($password);
    $confPassword = trim($confPassword);

    $errors = validateInput($name, $lastname, $email, $username, $password, $confPassword);


    if (empty($errors)) {
        try {
            $sqlAdmin = "INSERT INTO administrator (nameAdmin, lastnameAdmin, usernameAdmin, passwordAdmin, emailAdmin)
                        VALUES ('$name', '$lastname', '$username', '$password', '$email')";
            mysqli_query($conn, $sqlAdmin);
            $_SESSION["user_role"] = "admin";
            echo "*Η εγγραφή διαχειριστή ολοκληρώθηκε!." . PHP_EOL;
        } catch (mysqli_sql_exception $e) {
            echo "*Μία από τις εγγραφές που δώσατε χρησιμοποιείται ήδη." . $e . PHP_EOL;
        }
    }
    else{
        echo "Σφάλμα:" . PHP_EOL;
        foreach ($errors as $error) {
            echo "<div class=\"error\">" . $error . "</div>" . PHP_EOL;
        }
    }
    
}
mysqli_close($conn);
?>