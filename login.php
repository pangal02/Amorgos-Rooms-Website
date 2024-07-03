<?php
session_start();
    include_once "database.php";
    
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
    <title>ΕΙΣΟΔΟΣ</title>
    <link rel="stylesheet" type="text/css" href="styles/styleLogin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <form method="POST" action="login.php">
            <H1>Login</H1>
            <div class="input-box">
                <label for="username"></label>
                <input type="text" id="username" name="username" placeholder="Username">
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <label for="password"></label>
                <input type="password" id="password" name="password" placeholder="Password" >
                <i class='bx bxs-lock'></i>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox" name="rmbrPass"> Remember me</label>
                <a href="#">Forgot Password?</a>
            </div>

            <button type="submit" class="btn" name="login">Login</button>

            <div class="register-link">
                <p>Don't have an account? <a href="sign-up.php"> <strong>Register</strong></a></p>
            </div>
        </form>
    </div>
</body>
</html>

<?php
try{
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!empty($_POST["username"]) && !empty($_POST["password"])){
            $usr = $_POST["username"];
            $pass = $_POST["password"];
            if($conn){
                $sql_REG_USER = "SELECT * FROM registered_user
                        WHERE username='$usr' AND password='$pass'";
                $result_REG_USER = mysqli_query($conn, $sql_REG_USER);

                $sql_ADMIN = "SELECT * FROM administrator
                        WHERE usernameAdmin='$usr' AND passwordAdmin='$pass'";
                $result_ADMIN = mysqli_query($conn, $sql_ADMIN);

                if(mysqli_num_rows($result_REG_USER) > 0){ //!= false
                    $row_REG_USER = mysqli_fetch_assoc($result_REG_USER);
                    $_SESSION["nameManager"] = $row_REG_USER["nameManager"];
                    $_SESSION["lastnameManager"] = $row_REG_USER["lastnameManager"];
                    $_SESSION["nameCompany"] = $row_REG_USER["nameCompany"];
                    $_SESSION["phoneCompany"] = $row_REG_USER["phoneCompany"];
                    $_SESSION["email"] = $row_REG_USER["emailCompany"];
                    $_SESSION["username"] = $row_REG_USER["username"];
                    $_SESSION["password"] = $row_REG_USER["password"];
                    $_SESSION["user_role"] = "reg_user";
                    echo"<H1>YOU ARE LOGGED-IN NOW AS USER</H1>";
                    header("Location: user-profile.php");
                }
                else if(mysqli_num_rows($result_ADMIN) > 0){//!= false
                    $row_ADMIN = mysqli_fetch_assoc($result_ADMIN);
                    $_SESSION["nameAdmin"] = $row_ADMIN["nameAdmin"];
                    $_SESSION["lastnameAdmin"] = $row_ADMIN["lastnameAdmin"];
                    $_SESSION["username"] = $row_ADMIN["usernameAdmin"];
                    $_SESSION["password"] = $row_ADMIN["passwordAdmin"];
                    $_SESSION["email"] = $row_ADMIN["emailAdmin"];
                    $_SESSION["user_role"] = "admin";
                    echo"<H1>YOU ARE LOGGEDIN NOW AS ADMIN</H1>";
                    header("Location: admin-profile.php");
                }
                else{
                    echo "*Λάθος στοιχεία!";
                }
            }
            else{
                echo "Σφάλμα σύνδεσης με την Βάση";
            }
        }
        else{
            echo "<div class=\"error\">*Απαιτείται συμπλήρωση Όνομα χρήστη/Κωδικού πρόσβασης</div>";
        }
    }
}
catch(Exception $e){echo $e;}
?>