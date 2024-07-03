<?php
session_start();
    if(isset($_SESSION['username'])){
        if($_SESSION['user_role'] === "admin"){
            $isAdmin = true;
        }
        else{
            $isAdmin = false;
        }
    }
?>

<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ΑΡΧΙΚΗ - Amorgos Rooms</title>
    <link rel="stylesheet" type="text/css" href="styles/styleIndex.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
        <article>
            <h2>Σας Καλώς Ορίζουμε στο Amorgos Rooms!</h2>
            <h2>Ελάτε να γνωρίσετε το όμορφο νησί της Αμοργού!</h2>
            <h3>Βρείτε το ιδανικό κατάλυμα που ταιριάζει σε εσάς και την παρέα σας και δημιουργήστε αξέχαστες στιγμές σε
                ένα μαγευτικό
                ταξίδι στο απέραντο γαλάζιο.
            </h3>
            <br>
            <p>Η Αμοργός, γνωστή για το απέραντο γαλάζιο που την περιβάλλει, είναι ένα μαγευτικό νησί των Κυκλάδων.
                Ιδανικός προορισμός για ξεκούραστες διακοπές, συνδυάζει χαλάρωση, νυχτερινή διασκέδαση και
                δραστηριότητες στη φύση.
            </p>
            <h2>Τι είναι το Amorgos Rooms;</h2>
            <section>
                <h3>Ταξιδιώτες</h3>
                <ul>
                    <li>Στην Amorgos Rooms σας βοηθάμε εύκολα και γρήγορα να βρείτε το κατάλληλο μέρος για να
                        διανικτερεύσετε.</li>
                    <li>Σας παρέχουμε πληροφορίες για τα πιο όμορφα σημεία του τόπου μας, που πρέπει οπωσδήποτε να
                        επισκευτείτε.</li>
                    <li>Ακόμη, για οτιδήποτε χρειστείτε μην δυστάσετε να επικοινωνήσετε μαζί μας.</li>
                </ul>
            </section>

            <section>
                <h3>Επαγγελματίες</h3>
                <p>Εάν είσαι επαγγελματίας το Amorgos Rooms είναι για σένα (ΠΑΜ!)</p>
                <ul>
                    <li>Συνεργάσου μαζί μας και άφησε την διαφήμιση του καταλύματός σου στα χέρια μας.</li>
                </ul>
            </section>

            <h2>Τι χρειάζεται; Είναι δύσκολο;</h2>
            <p>Για τους τουρίστες του νησιού χρειάζεται απλά να πατήσεις <a href="find-a-room.html">ΒΡΕΣ ΚΑΤΑΛΥΜΑ</a> κι
                αναζήτηση ξεκινά!</p>
            <p>Σε περίπτωση όπου είσαι επαγγελματίας το μόνο που χρειάζεται είναι να κάνεις μία <a
                    href="sign-up.html">εγγραφή</a> στην ιστοσελίδα του Amorgos Rooms ώστε να δείξεις στους ταξιδιώτες
                το κατάλυμα σου</p>
            <br>
            <h2>Aναζητάτε περισσότερες πληροφορίες για την Αμοργό;</h2>
            <div class="box">
                <h2>ΠΛΗΡΟΦΟΡΙΕΣ</h2><BR>
                <button onclick="window.open('more.html', '_blank')">MORE</button>
            </div>
        </article>
    </main>

    <aside class="sidebar-right">
        <div class="pin-map">
            <i class="fa-solid fa-location-dot"></i>
            <p>Αμοργός Κυκλάδες, Ελλάδα</p>
        </div>
        <img src="media/xartis-amorgos.jpg"> <br>
        <img src="media/Amorgos_Chora.jpg"> <br>
        <img src="media/Amorgos2.jpg">
    </aside>

    <footer>
        <HR>
        <a href="" id="arrow">&uarr;</a>
        <p><a href="contact.html" target="_blank">ΕΠΙΚΟΙΝΩΝΙΑ</a></p>
        <p>&copy; Amorgos Rooms</p>
    </footer>
</body>

</html>