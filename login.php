<?php
//Handles login
session_start();

// Check if user is already logged in
if (isset($_SESSION['username'])) {
    if ($_SESSION["admin"] == 'YES') {
        header("location: sales.php");
    } else {
        header("location: index.php");
    }
    exit();
}

require_once "config.php"; // Assume this file contains the database connection $conn

$username = $password = "";
$uerr = $perr = "";

// Process the form when submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if username and password are not empty
    if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $uerr = "Please enter both username and password.";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Prepare SQL statement
        $sql = "SELECT id, fullname, email, username, password, admin FROM loginform WHERE username = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind the username parameter
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind the result variables
                    mysqli_stmt_bind_result($stmt, $id, $fullname, $email, $username, $hashed_password, $admin);
                    if (mysqli_stmt_fetch($stmt)) {
                        // Verify the password
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct. Start a new session and set session variables
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["fullname"] = $fullname;
                            $_SESSION["email"] = $email;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;
                            $_SESSION["admin"] = $admin;

                            // Redirect the user based on their admin status
                            if ($admin == 'YES') {
                                header("location: sales.php");
                            } else {
                                header("location: index.php");
                            }
                        } else {
                            $perr = "Incorrect password.";
                        }
                    }
                } else {
                    $uerr = "An account with that username does not exist.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}
// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Burger Ordering System</title>
    <link rel="icon" href="Assets/logo.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="nav-container">
        <ul>
            <ul>
                <li class="brand"><img src="Assets/logo2.png" alt="Burger">King Of Burgers</li>
            </ul>
            <ul class="right-ul">
                <li><a href="index.php">Home</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a id="active" href="login.php">Login</a></li>
            </ul>
        </ul>
    </nav>
    <div class="container">
        <form action="" method="post">
            <section class="login-page">
                <div class="login-input">
                    <div class="login-details">
                        <label for="username">Username</label> <span style="color:red;"><?php echo $uerr; ?></span>
                        <input type="text" name="username" id="username">
                    </div>
                    <div class="login-details">
                        <label for="password">Password</label> <span style="color:red;"><?php echo $perr; ?></span>
                        <input type="password" name="password" id="password">
                    </div>
                </div>
                <div class="login-btn">
                    <button type="submit">Login</button>
                </div>
            </section>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/6f42fc440c.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>
