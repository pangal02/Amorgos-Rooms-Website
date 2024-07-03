<?php
    session_start();
    include("header.php");
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
        <?php hello(); ?>
        <p>Εδώ βλέπετε πληροφορίες σχετικά με το προφίλ σας.</p>
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
    function hello(){
        echo "<p>Γειά σου {$_SESSION['name']}!</p>";
    }
?>