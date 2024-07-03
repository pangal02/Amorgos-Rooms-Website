<?php
session_start();
include("header.php");
include("database.php");

$nameAdmin = $_SESSION["nameAdmin"];
$lastnameAdmin = $_SESSION["lastnameAdmin"];
$email = $_SESSION["email"];
$username = $_SESSION["username"];
$password = $_SESSION["password"];

if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: index.html");
}

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
        <h2>Στοιχεία Λογαριασμού Διαχειρηστή</h2>
        <form action="admin-data-profile.php" method="post">
            <input type="checkbox" id="updateData" name="updateData">
            <label for="updateData">Ενημέρωση στοιχείων</label><br>
            <div>
                <label for="nameAdmin"><u>Όνομα Υπεύθυνου</u>: </label>
                <?php echo $nameAdmin . " ->" ?>
                <input type="text" id="nameAdmin" name="nameAdmin"> <br><br>

                <label for="lastnameAdmin"><u>Επίθετο Υπεύθυνου</u>: </label>
                <?php echo $lastnameAdmin . " ->" ?>
                <input type="text" id="lastnameAdmin" name="lastnameAdmin"><br><br>

                <label for="emailAmdin"><u>Email Διαχειρηστή</u>: </label>
                <?php echo $email . " ->" ?>
                <input type="email" id="emailAmdin" name="emailAmdin"><br><br>

                <label for="newPassword"><u>Password</u>: </label>
                <?php echo $password . " -> " ?>
                <input type="password" id="newPassword" name="newPassword">

                <label for="confirmNewPassword">~> Confirm New Password: </label>
                <input type="password" id="confirmNewPassword" name="confirmNewPassword"><br><br>

                <label for="confirmOldPassword">*Τωρινό Password</label>
                <input type="password" id="confirmOldPassword" name="confirmOldPassword"><br><br>
                <input type="submit" name="submit" value="Ενημέρωση στοιχείων">
                <p>* Υποδηλώνει υποχρεωτικο στοιχείο για την αλλαγή δεδομένων.</p>
            </div>
        </form>
    </main>


    <aside class="left-aside">
        <ul>
            <li><a href="admin-profile.php">Λογαριασμός</a></li>
            <li><a href="admin-data-profile.php">Στοιχεία λογαριασμού</a></li>
            <li><a href="admin-list-of-users.php">Πίνακας εγγεγραμένων χρηστών</a></li>
            <li><a href="admin-new.php">Προσθήκη διαχειρηστή</a></li>
    </aside>
</body>

</html>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    if (!isset($_POST["updateData"])) {
        $errors[] = "Για να κανετε αλλαγές πρέπει να έχετε επιλέξει το κουμπί \"Ενημέρωση στοιχείων\"";
    } else {
        if (!empty($_POST["nameAdmin"])) {
            $nameAdmin = filter_input(INPUT_POST, "nameAdmin", FILTER_SANITIZE_SPECIAL_CHARS);
            if (strlen($nameAdmin) > 50) {
                $errors[] = "*Το όνομα δεν πρέπει να υπερβαίνει τους 50 χαρακτήρες.";
            }
        }
        if (!empty($_POST["lastnameAdmin"])) {
            $lastnameAdmin = filter_input(INPUT_POST, "lastnameAdmin", FILTER_SANITIZE_SPECIAL_CHARS);
            if (strlen($lastnameAdmin) > 50) {
                $errors[] = "*Το επώνυμο δεν πρέπει να υπερβαίνει τους 50 χαρακτήρες.";
            }
        }
        if (!empty($_POST["emailAdmin"])) {
            $email = filter_input(INPUT_POST, "emailAdmin", FILTER_VALIDATE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "*Το email δεν είναι έγκυρο.";
            }
        }
        if (!empty($_POST["newPassword"])) {
            $oldpass = $password;
            $password = filter_input(INPUT_POST, "newPassword", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = trim($password);
            if (!empty($_POST["confirmNewPassword"])) {
                $newConfPassword = filter_input(INPUT_POST, "confirmNewPassword", FILTER_SANITIZE_SPECIAL_CHARS);
                $newConfPassword = trim($newConfPassword);
                if ($newConfPassword !== $password) {
                    $errors[] = "*Οι νέοι κωδικοί δεν ταιριάζουν μεταξύ τους";
                }
            } else {
                $errors[] = "*Η επιβεβαίωση νέου κωδικού πρόσβασης δεν μπορεί να είναι κενή";
            }

        }
        if (empty($_POST["confirmOldPassword"])) {
            $errors[] = "*Για την επιβεβαίωση της αλλαγής των στοιχείων, πρέπει να συμπληρώσετε το \"Confirm password\".";
        }
        else {
            if(isset($oldpass)){
                $confOldPass = $_POST["confirmOldPassword"];
                if($oldpass !== $confOldPass){
                    $errors[] = "*Ο κωδικός πρόσβασης και η επιβεβαίωση κωδικού δεν ταιριάζουν.";
                }
            }
            else{
                if ($_POST["confirmOldPassword"] !== $password) {
                    $errors[] = "*Ο κωδικός πρόσβασης και η επιβεβαίωση κωδικού δεν ταιριάζουν.";
                }
            }
        }
    }

    if (empty($errors)) {
        try {
            $sqlUser = "UPDATE administrator SET
                        nameAdmin = '$nameAdmin',
                        lastnameAdmin = '$lastnameAdmin',
                        emailAdmin = '$email',
                        passwordAdmin = '$password'
                        WHERE usernameAdmin = '$username'";

            mysqli_query($conn, $sqlUser);
            echo "*Η ενημέρωση στοιχείων διαχειρηστή ολοκληρώθηκε!. Συνδεθείτε ξανά" . PHP_EOL;
            header("Location: login.php");
        } catch (mysqli_sql_exception $e) {
            echo $e;
        }
    } else {
        echo "Σφάλμα:" . PHP_EOL;
        foreach ($errors as $error) {
            echo "<div class=\"error\">" . $error . "</div>" . PHP_EOL;
        }
    }
}
?>