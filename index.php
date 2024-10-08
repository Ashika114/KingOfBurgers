<?php
session_start();
require_once "config.php";
if(!(isset($_SESSION['admin']))){
    $_SESSION['admin'] = "NIL";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Cake Ordering System</title>
    <link rel="icon" href="Assets/logo.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="nav-container">
        <ul>
            <ul>
                <li class="brand"><img src="Assets/1Cake.png" alt="Cake">Cake Haven</li>
            </ul>
            <ul class="right-ul">
                <li><a id="active" href="index.php">Home</a></li>
                <?php if($_SESSION["admin"]=='YES'): ?>
                <li><a href="sales.php">Sales</a></li>
                <li><a href="cake.php">Cakes</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="logout.php">Logout</a></li>
                <?php elseif ($_SESSION["admin"]=='NIL'):?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
                <?php else:?>
                <li><a href="store.php">Store</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="logout.php">Logout</a></li>
                <?php endif;?>
            </ul>
        </ul>
    </nav>
    <div class="container">
        <section class="banner">
            <img src="Assets/2CakeBG.jpg" alt="Background Image">
        </section>
        <section class="slogan">
            <h1>Slice of Heaven: <br>Freshly Baked Cakes<br> Delivered to Your Door</h1>
        </section>
        <section class="speciality">
            <div class="speciality-content">
                <div class="speciality-pic">
                    <img src="Assets/CakeDevilery.png" alt="d">
                </div>
                <div class="speciality-head">
                    <h2>Door Step Delivery</h2>
                </div>
            </div>
            <div class="speciality-content">
                <div class="speciality-pic">
                    <img src="Assets/Wallet Cake.png" alt="w">
                </div>
                <div class="speciality-head">
                    <h2>Affordable Price</h2>
                </div>

            </div>
            <div class="speciality-content">
                <div class="speciality-pic">
                    <img src="Assets/1CakeBG.jpg" alt="b">
                </div>
                <div class="speciality-head">
                    <h2>Exquisite Cake</h2>
                </div>
            </div>
        </section>
    </div>

    <script src="https://kit.fontawesome.com/6f42fc440c.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>