<?php
session_start();
include("database.php"); // Περιέχει τη σύνδεση με τη βάση δεδομένων
include("header.php");

// Αποθηκεύουμε το email από το GET στο session
if (isset($_GET["email"])) {
    $_SESSION["email"] = $_GET["email"];
}

?>

<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ΕΓΓΡΙΣΗ ΚΑΤΑΛΥΜΑΤΩΝ - Amorgos Rooms</title>
    <link rel="stylesheet" type="text/css" href="styles/styleIndex.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <header>
        <h1>Amorgos Rooms</h1>
        <?php if (isset($_SESSION['username'])) : ?>
            <?php if ($isAdmin) : ?>
                <H2>Λογαριασμός ADMINISTRATOR</H2>
            <?php endif; ?>
        <?php endif; ?>
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
                <?php if (isset($_SESSION['username'])):?>
                    <?php if($isAdmin):?>
                        <li><a href="admin-profile.php">ΠΡΟΦΙΛ</a></li>
                        <p><a href="logout.php">Logout</a></p>
                    <?php else:?>
                        <li><a href="user-profile.php">ΠΡΟΦΙΛ</a></li>
                        <p><a href="logout.php">Logout</a></p> 
                    <?php endif;?>
                <?php else: ?>
                    <li><a href="sign-up.php">ΕΓΓΡΑΦΗ/ΣΥΝΔΕΣΗ</a></li>
                <?php endif;?>
            </ul>
        </nav>
    </header>

    <main>
        <p>Πίνακας εγκρίσεων:</p>
        <h1>Έγκριση χρήστη από ROOM</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Όνομα επιχείρησης</th>
                <th>Περιγραφή επιχείρησης</th>
                <th>Τηλέφωνο επιχείρησης</th>
                <th>Κινητό τηλέφωνο</th>
                <th>Email</th>
            </tr>
            <?php
            // Ανάκτηση email από το session
            $rEmail = $_SESSION["email"];
            
            // Ερώτημα SQL για ανάκτηση δεδομένων από τον πίνακα room
            $sql = "SELECT * FROM room WHERE email_company = '$rEmail'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Μετατροπή της τιμής approval σε "ΝΑΙ" ή "ΟΧΙ"
                     
                    if($row["approval"] == 1){
                        $aprvl = "NAI";
                    }
                    else{
                        $aprvl = "OXI";
                    }
                    
                    echo "<tr>";
                    echo "<td>" . $row["room_id"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["name_company"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["discription_company"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["phone_company"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["mobile_phone"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email_company"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Δεν βρέθηκαν εγγραφές</td></tr>";
            }
            ?>
        </table>
        
        <form action="admin-check.php" method="POST">
            <p>ΑΠΟΔΟΧΗ ΧΡΗΣΤΗ;</p><br><br>
            <input type="submit" id="btn-yes" name="btn-yes" value="Αποδοχή χρήστη">
            <input type="submit" id="btn-no" name="btn-no" value="Απόρριψη χρήστη">
        </form>
    </main>
</body>

</html>

<?php
// Ελέγχουμε αν έχει πατηθεί κάποιο κουμπί από τη φόρμα
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ελέγχουμε αν η σύνδεση με τη βάση δεδομένων είναι ενεργή
    if (!$conn) {
        echo "Σφάλμα: Αποτυχία σύνδεσης με τη βάση δεδομένων";
    } else {
        // Ανάκτηση του email από το session
        $rEmail = $_SESSION["email"];

        // Ελέγχουμε ποιο κουμπί πατήθηκε και εκτελούμε το αντίστοιχο SQL ερώτημα
        if (isset($_POST["btn-yes"])) {
            $sql_updt_t = "UPDATE registered_user SET approval = '1' WHERE emailCompany = '$rEmail'";
            try {
                mysqli_query($conn, $sql_updt_t);
                echo "Η εγγραφή του χρήστη εγκρίθηκε!";
                header("Location: admin-list-of-users.php");
            } catch (mysqli_sql_exception $e) {
                echo "Σφάλμα SQL: " . $e;
            }
        }

        if(isset($_POST["btn-no"])){
            $sql_updt_f = "UPDATE registered_user SET approval = '0' WHERE emailCompany = '$rEmail'";
            $sql_del = "DELETE FROM room WHERE email_company = '$rEmail'";
            try{
                mysqli_query($conn, $sql_updt_f);
                mysqli_query($conn, $sql_del);
                echo "Η εγγραφή του καταλύματος αφαιρέθηκε";
                header("Location: admin-list-of-users.php");
            }
            catch (mysqli_sql_exception $e) {
                echo "Σφάλμα SQL: " . $e->getMessage();
            }
        }
    }
}
mysqli_close($conn);
?>
