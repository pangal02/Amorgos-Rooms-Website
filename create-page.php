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
    <link rel="stylesheet" type="text/css" href="/styles/styleContact.css">
    <title>ΔΗΜΙΟΥΡΓΙΑ ΣΕΛΙΔΑΣ</title>
</head>

<body>

    <header>
        <h1>Amorgos Rooms</h1>
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
                    <li><a href="sign-up.php">ΕΓΓΡΑΦΗ/ΣΥΝΔΕΣΗ</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <form action="create-page.php" method="POST" enctype="multipart/form-data">
            <label for="bussinesName">*Επωνυμία επιχείρησης:</label>
            <input type="text" id="bussinesName" name="bussinesName" value="<?php echo $_SESSION["nameCompany"] ?>" readonly><br><br>

            <label for="descrBussines">*Περιγραφή επιχείρησης:</label>
            <textarea id="descrBussines" name="descrBussines"></textarea>*(τουλάχιστον 100 χαρακτηρες)<br><br>
            

            <label for="location">*Περιοχή: </label>
            <select id="location" name="location">Location search
                <option selected value="Χώρα Αμοργού" name="Χώρα Αμοργού">Χώρα Αμοργού</option>
                <option value="Κατάπολα" name="Κατάπολα">Κατάπολα</option>
                <option value="Αιγιάλη" name="Αιγιάλη">Αιγιάλη</option>
            </select><br><br>

            <label for="phoneBussines">*Τηλέφωνο επιχείρησης:</label>
            <input type="text" id="phoneBussines" name="phoneBussines" value="<?php echo $_SESSION["phoneCompany"] ?>" readonly><br><br>

            <label for="mobPhoneBussines">*Κινητό τηλέφωνο:</label>
            <input type="text" id="mobPhoneBussines" name="mobPhoneBussines"><br><br>

            <label for="emailBussines">*Εmail επιχείρησης:</label>
            <input type="email" id="emailBussines" name="emailBussines" value="<?php echo $_SESSION["email"] ?>" readonly><br><br>

            <label for="photo">Επιλέξτε φωτογραφία:</label>
            <input type="file" id="photo" name="photo"><br><br>

            <input type="submit" value="Ready!"><br><br>
            <h6>*Υποχρεωτικά πεδία</h6>
        </form>

        <form method="get" action="create-page.php">
            <h3>Σύνδεση με social media</h3>

            <label for="socialMedia">Link προς εξωτερικό URL, π.χ., Facebook/Instagram/Επίσημο site, κτλ: </label>
            <input type="text" id="socialMedia" name="socialMedia"><br><br>

            <label for="checkURL">Επιθυμώ σύνδεση με το παραπάνω URL </label>
            <input type="checkbox" id="checkURL" name="checkURL"><br><br>

            <input type="submit" value="Ready!">
        </form>
    </main>
</body>

</html>

<?php
function validInput($bdisc, $bmobile)
{
    $errors = [];
    if (!isset($bdisc)) {
        if (strlen($bdisc) < 100) {
            $errors[] = "Η περιγραφή καταλύματος δεν μπορει να περιέχει λιγότερους απο \"100\" χαρακτήρες";
        }
    } else {
        $errors = "Η περιγραφή καταλύματος δεν μπορει να είναι κενή";
    }
    if (!empty($bmobile)) {
        if (!preg_match('/^\d+$/', $bmobile)) {
            $errors[] = "*Το τηλέφωνο πρέπει να περιέχει μόνο αριθμούς.";
        }
    } else {
        $errors[] = "Το κινητό τηλέφωνο δεν μπορεί να είναι κενό";
    }
    return $errors;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nCompany = $_SESSION["nameCompany"];
    $phoneCompany = $_SESSION["phoneCompany"];
    $emailCompany = $_SESSION["email"];
    $bdiscr = filter_input(INPUT_POST, "descrBussines", FILTER_SANITIZE_SPECIAL_CHARS);
    $bmobile = filter_input(INPUT_POST, "mobPhoneBussines", FILTER_SANITIZE_SPECIAL_CHARS);
    $bmobile = trim($bmobile);
    $location = $_POST["location"];


    if ($_FILES["upfile"]["error"] == 0) {
        echo "Upload:" . $_FILES["upfile"]["name"] . "<br>";
        echo "Type:" . $_FILES["upfile"]["type"] . "<br>";
        echo "Size:" . ($_FILES["upfile"]["size"] / 1024) . "kB<br>";
        echo "Temporary stored in:" . $_FILES["upfile"]["tmp_name"];
    } else {
        echo "Error:" . $_FILES["upfile"]["error"] . "<br>";
    }
    $destination = "uploads/";
    if (!empty($_FILES["photo"])) {

        $destination .= $_FILES["photo"]["name"];
        $fname = $_FILES["photo"]["tmp_name"];
        // move_uploaded_file($fname, $destination);
    } else {
        echo "Δεν επιλέχθηκε αρχειο εικόνας";
    }

    $errors = validInput($bdisc, $bmobile);
    if (empty($errors)) {
        try {
            if ($conn) {
                $sql = "INSERT INTO room (name_company, discription_company, location_company, phone_company, mobile_phone, email_company)
                            VALUES ('$nCompany', '$bdiscr', '$location', '$phoneCompany', '$bmobile', '$emailCompany')";
                $result = mysqli_query($conn, $sql);
                echo "*Η εγγραφή ΚΑΤΑΛΗΜΑΤΟΣ ολοκληρώθηκε!." . PHP_EOL;
            } else {
                echo "Σφάλμα σύνδεσης με την βάση $'CONN'";
            }
        } catch (mysqli_sql_exception $e) {
            echo "Σφάλμα σύνδεσης " . $e;
        }
    } else {
        echo "Σφάλμα:" . PHP_EOL;
        foreach ($errors as $error) {
            echo "<div class=\"error\">" . $error . "</div>" . PHP_EOL;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $emailCompany = $_SESSION["email"];
    if (isset($_GET["checkURL"])) {
        if (!empty($_GET["socialMedia"])) {
            $url = $_GET["socialMedia"];
            echo "Επέλεξες την διαδρομή: '" . $url . "'<BR>";
            $sql_url = "UPDATE room SET
                        url_company = '$url'
                        WHERE email_company = '$emailCompany'";


            try {
                mysqli_query($conn, $sql_url);
                echo "OK";
            } catch (Exception $e) {
                echo $e;
            }
        }
    } else {
        echo "Αν επιθυμείτε να συνδέσετε την ιστοσελίδα μας με την δική μας, παρακαλώ επιλέξτε το κουτί \"URL\"";
    }
}

mysqli_close($conn);
?>