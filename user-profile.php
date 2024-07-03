<?php
include("database.php");
session_start();
include("header.php");
function hello()
{
    echo "Γειά σου, {$_SESSION["nameManager"]}!";
}


$nameManager = $_SESSION["nameManager"];
$lastnameManager = $_SESSION["lastnameManager"];
$nameCompany = $_SESSION["nameCompany"];
$phoneCompany =  $_SESSION["phoneCompany"];
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
        <H2>Λογαριασμός απλου χρήστη</H1>
            <nav>
                <input type="checkbox" id="check">
                <label for="check" class="checkBtn">
                    <i class="fa-solid fa-bars"></i>
                </label>
                <ul>
                    <li><a href="index.php">ΑΡΧΙΚΗ</a></li>
                    <li><a href="find-a-room.php">ΒΡΕΣ ΚΑΤΑΛΥΜΑ</a></li>
                    <li><a href="more.html">ΠΕΡΙΣΣΟΤΕΡΑ</a></li>
                    <li><a href="contact.html" target="_blank">ΕΠΙΚΟΙΝΩΝΙΑ</a></li>
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
                        <li><a href="sign-up.php">ΕΓΓΡΑΦΗ/ΣΥΝΔΕΣΗ</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
    </header>

    <main>
        <h2>Λογαριασμός</h2>
        <?php hello(); ?>
        <form action="user-profile.php" method="post">
            <input type="checkbox" id="updateData" name="updateData">
            <label for="updateData">Ενημέρωση στοιχείων</label><br>
            </div>
            <label for="nameManager"><u>Όνομα Υπεύθυνου</u>: </label>
            <?php echo $nameManager . " ->" ?>
            <input type="text" id="nameManager" name="nameManager"> <br><br>

            <label for="lastnameManager"><u>Επίθετο Υπεύθυνου</u>: </label>
            <?php echo $lastnameManager . " ->" ?>
            <input type="text" id="lastnameManager" name="lastnameManager"><br><br>

            <label for="nameCompany"><u>Επωνυμία Επιχείρησης</u>: </label>
            <?php echo $nameCompany . " ->" ?>
            <input type="text" id="nameCompany" name="nameCompany"><br><br>

            <label for="phoneCompany"><u>Τηλέφωνο Επιχείρησης</u>: </label>
            <?php echo $phoneCompany . " ->" ?>
            <input type="tel" id="phoneCompany" name="phoneCompany"><br><br>

            <label for="emailCompany"><u>Email Επιχείρησης</u>: </label>
            <?php echo $email . " ->" ?>
            <input type="email" id="emailCompany" name="emailCompany"><br><br>

            <label for="password"><u>Password</u>: </label>
            <?php echo $password . " ->" ?>
            <input type="password" id="password" name="newPassword">

            <label for="confirmNewPassword">~>Confirm New Password: </label>
            <input type="password" id="confirmNewPassword" name="confirmNewPassword"><br><br>

            <label for="confirmOldPassword">*Τωρινό Password</label>
            <input type="password" id="confirmOldPassword" name="confirmOldPassword"><br><br>
            <input type="submit" name="submit" value="Ενημέρωση στοιχείων">
            <p>* Υποδηλώνει υποχρεωτικο στοιχείο για την αλλαγή δεδομένων.</p>
            </div>
        </form>
    </main>

</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    if (!isset($_POST["updateData"])) {
        $errors[] = "Για να κανετε αλλαγές πρέπει να έχετε επιλέξει το κουμπί \"Ενημέρωση στοιχείων\"";
    } 
    else {
        if (!empty($_POST["nameManager"])) {
            $nameManager = filter_input(INPUT_POST, "nameManager", FILTER_SANITIZE_SPECIAL_CHARS);
            if (strlen($nameManager) > 50) {
                $errors[] = "*Το όνομα δεν πρέπει να υπερβαίνει τους 50 χαρακτήρες.";
            }
        }
        if (!empty($_POST["lastnameManager"])) {
            $lastnameManager = filter_input(INPUT_POST, "lastnameManager", FILTER_SANITIZE_SPECIAL_CHARS);
            if (strlen($lastnameManager) > 50) {
                $errors[] = "*Το επώνυμο δεν πρέπει να υπερβαίνει τους 50 χαρακτήρες.";
            }
        }
        if (!empty($_POST["nameCompany"])) {
            $nameCompany = filter_input(INPUT_POST, "nameCompany", FILTER_SANITIZE_SPECIAL_CHARS);
            if (strlen($nameCompany) > 50) {
                $errors[] = "*Η εταιρεία δεν πρέπει να υπερβαίνει τους 100 χαρακτήρες.";
            }
        }
        if (!empty($_POST["phoneCompany"])) {
            $phoneCompany = filter_input(INPUT_POST, "phoneCompany", FILTER_SANITIZE_SPECIAL_CHARS);
            if (!preg_match('/^\d+$/', $phoneCompany)) {
                $errors[] = "*Το τηλέφωνο πρέπει να περιέχει μόνο αριθμούς.";
            }
        }
        if (!empty($_POST["emailCompany"])) {
            $email = filter_input(INPUT_POST, "emailCompany", FILTER_VALIDATE_EMAIL);
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
            $sqlUser = "UPDATE registered_user SET
                        nameManager = '$nameManager',
                        lastnameManager = '$lastnameManager',
                        nameCompany = '$nameCompany',
                        phoneCompany = '$phoneCompany',
                        emailCompany = '$email',
                        password = '$password'
                        WHERE username = '$username'";

            mysqli_query($conn, $sqlUser);
            echo "*Η ενημέρωση στοιχείων χρήστη ολοκληρώθηκε!. Συνδεθείτε ξανά" . PHP_EOL;
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