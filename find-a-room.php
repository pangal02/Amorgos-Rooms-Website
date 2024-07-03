<?php
session_start();
include("database.php");
?>
<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/styleFindRoom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>ΒΡΕΣ ΚΑΤΑΛΥΜΑ</title>
    <style>
        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            padding-top: 20px;
            /* για να υπάρχει χώρος για το label */
            box-sizing: border-box;
        }

        .form-group label {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 12px;
            color: #777;
            pointer-events: none;
            transition: all 0.2s;
        }

        .form-group input:focus+label,
        .form-group input:not(:placeholder-shown)+label,
        .form-group select:focus+label,
        .form-group select:not([value=""])+label {
            top: -10px;
            left: 10px;
            font-size: 10px;
            color: #333;
        }
    </style>
</head>

<body>
    <header>
        <H1>Amorgos Rooms</H1>

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
        <H2>ΒΡΕΣ ΚΑΤΑΛΥΜΑ</H2>
    </header>

    <main>
        <form class="filters" method="POST" action="find-a-room.php">
            <div class="search-box">
                <label for="search"><i class="fa-solid fa-magnifying-glass"></i></label>
                <input type="search" id="search" name="searchbar" placeholder="Search...">
            </div>

            <div class="form-group">
                <label for="searchLocation">Location</label>
                <select id="searchLocation" name="searchLocation">Location search
                    <option selected value="" name="">-</option>
                    <option value="Χώρα Αμοργού" name="Χώρα Αμοργού">Χώρα</option>
                    <option value="Κατάπολα" name="Κατάπολα">Κατάπολα </option>
                    <option value="Αιγιάλη" name="Αιγιάλη">Αιγιάλη</option>
                </select>
            </div>
            <input type="submit" class="btn" value="Go!">
        </form>

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                
                if(empty($_POST["searchbar"]) && empty($_POST["searchLocation"])){
                    try{
                        $sql_all = "SELECT * FROM room";
                        $result = mysqli_query($conn, $sql_all);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<section>";
                                echo "<div class='"."first-con"."'>";
                                echo "<H3><strong>" . $row["name_company"] . "</strong> </H3>";
                                echo "<p>". $row["location_company"] . "</p>";
                                echo "<p> Τηλ: " . $row["phone_company"] . "</p>";
                                echo "<p> email: " . $row["email_company"] ."</p>";
                                echo "<a href=\"". "contact.html" . "\" target='_blank'>Επικοινωνήστε απευθείας</a>";
                                echo "</div>";
                                echo "<div class=\"sec-con\">";
                                echo "<a href=\"" . $row["url_company"] . "\"> <img src=\""."link" ."\" alt=\"More...\"></a>";
                                echo "</div>";
                                echo "</section>";
                            }
                        }

                    }
                    catch(mysqli_sql_exception $e){
                        echo $e;
                    }
                }
                else if(!empty($_POST["searchbar"] && empty($_POST["searchLocation"]))){
                    $searchbar = $_POST["searchbar"];
                    echo "<br>Ψάχνετε για '".$searchbar."'<br>";
                    try{
                        $sql_sb = "SELECT * FROM room
                                    WHERE name_company LIKE '%$searchbar%'";
                        $result = mysqli_query($conn, $sql_sb);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<section>";
                                echo "<div class='"."first-con"."'>";
                                echo "<H3><strong>" . $row["name_company"] . "</strong> </H3>";
                                echo "<p>". $row["location_company"] . "</p>";
                                echo "<p> Τηλ: " . $row["phone_company"] . "</p>";
                                echo "<p> email: " . $row["email_company"] ."</p>";
                                echo "<a href=\"". "contact.html" . "\" target='_blank'>Επικοινωνήστε απευθείας</a>";
                                echo "</div>";
                                echo "<div class=\"sec-con\">";
                                echo "<a href=\"" . $row["url_company"] . "\"> <img src=\""."link" ."\" alt=\"More...\"></a>";
                                echo "</div>";
                                echo "</section>";
                            }
                        }
                        else{
                            echo "<br>Δεν βρέθηκαν καταλύματα για '{$searchbar}'";
                        }
                    }catch(mysqli_sql_exception $e){echo $e;}
                }
                else if(!empty($_POST["searchLocation"]) && empty($_POST["searchbar"])){
                    $location = $_POST["searchLocation"];
                    echo "<br>Tοποθεσία '".$location."'<br>";
                    try{
                        $sql_loc = "SELECT * FROM room
                                    WHERE location_company LIKE '$location'";
                        $result = mysqli_query($conn, $sql_loc);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<section>";
                                echo "<div class='"."first-con"."'>";
                                echo "<H3><strong>" . $row["name_company"] . "</strong> </H3>";
                                echo "<p>". $row["location_company"] . "</p>";
                                echo "<p> Τηλ: " . $row["phone_company"] . "</p>";
                                echo "<p> email: " . $row["email_company"] ."</p>";
                                echo "<a href=\"". "contact.html" . "\" target='_blank'>Επικοινωνήστε απευθείας</a>";
                                echo "</div>";
                                echo "<div class=\"sec-con\">";
                                echo "<a href=\"" . $row["url_company"] . "\"target='_blank'> <img src=\""."link" ."\" alt=\"More...\"></a>";
                                echo "</div>";
                                echo "</section>";
                            }
                        }
                    }catch(mysqli_sql_exception $e){echo $e;}
                }
            }
        ?>
         
    </main>

    <footer>
        <HR>
        <a href="#" id="arrow">&uarr;</a>
        <p><a href="contact.html" target="_blank">ΕΠΙΚΟΙΝΩΝΙΑ</a></p>
        <p>&copy; AmorgosApp</p>
    </footer>
</body>

</html>