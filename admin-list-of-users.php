<?php
include("database.php");
session_start();
include("header.php");

$column = isset($_GET['column']) ? $_GET['column'] : 'user_id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

$nextOrder = ($order === 'ASC') ? 'DESC' : 'ASC';

?>

<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ΛΟΓΑΡΙΑΣΜΟΣ - Amorgos Rooms</title>
    <link rel="stylesheet" type="text/css" href="styles/styleIndex.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <h1>Amorgos Rooms</h1>
        <?php if (isset($_SESSION['username'])):?>
            <?php if($isAdmin):?>
                <H2>Λογαριασμός ADMINISTRATOR</H2>
            <?php endif;?>
        <?php endif;?>
        <nav>
            <input type="checkbox" id="check">
            <label for="check" class="checkBtn">
                <i class="fa-solid fa-bars"></i>
            </label>
            <ul>
                <li><a href="index.php">ΑΡΧΙΚΗ</a></li>
                <li><a href="find-a-room.html">ΒΡΕΣ ΚΑΤΑΛΥΜΑ</a></li>
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
                    <li><a href="check-login.php">ΕΓΓΡΑΦΗ/ΣΥΝΔΕΣΗ</a></li>
                <?php endif;?>
            </ul>
        </nav>
    </header>

    <main>
        <p>Πίνακας εγκρίσεων:</p>
        <h1>Registered Users</h1>
        <table>
            <tr>
                <th><a href="?column=user_id&order=<?= $nextOrder; ?>">ID</a></th>
                <th><a href="?column=nameManager&order=<?= $nextOrder; ?>">Όνομα</a></th>
                <th><a href="?column=lastnameManager&order=<?= $nextOrder; ?>">Επώνυμο</a></th>
                <th><a href="?column=nameCompany&order=<?= $nextOrder; ?>">Όνομα επιχείρησης</a></th>
                <th><a href="?column=phoneCompany&order=<?= $nextOrder; ?>">Τηλέφωνο επιχείρησης</a></th>
                <th><a href="?column=emailCompany&order=<?= $nextOrder; ?>">Email</a></th>
                <th><a href="?column=username&order=<?= $nextOrder; ?>">Username</a></th>
                <th><a href="?column=approval&order=<?= $nextOrder; ?>">Εγκρίθηκε</a></th>
            </tr>
            <?php
            $sql = "SELECT * FROM registered_user ORDER BY $column $order";

            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if($row["approval"] == 1){
                        $aprvl = "ΝΑΙ";
                    }
                    else{
                        $aprvl = "ΟΧΙ";
                    }
                    echo "<tr>";
                    echo "<td>" . $row["user_id"] . "</td>";
                    echo "<td>" . $row["nameManager"] . "</td>";
                    echo "<td>" . $row["lastnameManager"] . "</td>";
                    echo "<td>" . $row["nameCompany"] . "</td>";
                    echo "<td>" . $row["phoneCompany"] . "</td>";
                    echo "<td>" . $row["emailCompany"] . "</td>";
                    echo "<td><a href='admin-check.php?email=" . urlencode($row["emailCompany"]) . "'>" . $row["username"] . "</a></td>";
                    echo "<td>" . $aprvl . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No users found</td></tr>";
            }
            mysqli_close($conn);
            ?>
        </table>
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
