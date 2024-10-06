<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}
if ($_SESSION["admin"] == 'YES') {
    header("location: sales.php");
    exit();
}
require_once "config.php";

// Fetch the food items from the database
$sql = "SELECT * FROM fooditems";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}

$foodItems = [];
while ($row = $result->fetch_assoc()) {
    $foodItems[] = $row;
}

$groupedItems = [];
foreach ($foodItems as $item) {
    $groupedItems[$item['itemName']][] = $item;
}

$cartItemN = [];
$cartItemQ = [];
$cartItemP = [];
$err = $addr = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['tocart'])) {
        $hasItems = false; // Flag to check if any items are selected
        
        foreach ($foodItems as $item) {
            $quantity = $_POST[$item['id']] ?? 0; // Assuming 'id' is the primary key
            if ($quantity > 0) {
                $cartItemN[] = $item['itemName'];
                $cartItemQ[] = $quantity;
                $cartItemP[] = $quantity * $item['price'];
                $hasItems = true; // Set flag if at least one item is selected
            }
        }
        
        // If no items were selected, set the error message
        if (!$hasItems) {
            $err = "*Please select quantity for at least one item";
        }
    }
}


// Calculate total price and handle address submission
$totPrice = $tax = 0;
foreach ($cartItemP as $pr) {
    $totPrice += $pr;
}
if ($totPrice > 0) {
    $tax = $totPrice * (8 / 100);
    $_SESSION["tax"] = $tax;
    $totPrice += $tax;
    $_SESSION["netAmount"] = $totPrice;
    if (empty(trim($_POST['addr']))) {
        $err = "*Please enter Delivery Address";
    } else {
        $_SESSION["addr"] = $_POST['addr'];
        header("location: cart.php");
    }

    $_SESSION["cartItemN"] = $cartItemN;
    $_SESSION["cartItemQ"] = $cartItemQ;
    $_SESSION["cartItemP"] = $cartItemP;
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
                <li><a href="index.php">Home</a></li>
                <li><a id="active" href="store.php">Store</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </ul>
    </nav>
    <div class="container">
    <form action="" method="post">
        <?php if (!empty($err)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($err); ?>
            </div>
        <?php endif; ?>
        
        <div class="food-items">
            <?php foreach ($groupedItems as $itemName => $items): ?>
                <div class="food">
                    <div class="food-details" style="width: 500px;">
                        <h3><?php echo htmlspecialchars($itemName); ?></h3>
                        <ul>
                            <?php foreach ($items as $item): ?>
                                <li style="display: flex; align-items: center;">
                                    <?php if (!empty($item['filePath'])): ?>
                                        <img src="<?php echo htmlspecialchars($item['filePath']); ?>" alt="<?php echo htmlspecialchars($item['itemName']); ?>" style="width: 80px; height: auto; margin-right: 10px;">
                                    <?php else: ?>
                                        <span>No image available</span>
                                    <?php endif; ?>
                                    <input class="food-quantity" type="number" name="<?php echo $item['id']; ?>" min="0" max="10" value="0" >
                                    <div class="newLine">
                                    <span style="margin-left: 10px;">Price: Rs. <b><span><?php echo htmlspecialchars($item['price']); ?></span></b></span><br>
                                    <div style="margin-left: 10px; margin-top: 8px;">Discounted Price: Rs.  <b><span><?php echo htmlspecialchars($item['discountedPrice']); ?></b></span></div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div> <!-- food-details -->
                </div> <!-- food -->
            <?php endforeach; ?>
            <div class="address-container">
                <div class="address">
                    <div>
                        Delivery Address:
                    </div><br>
                    <div>
                        <input class="delivery-address" type="text" name="addr" placeholder="221b Baker St, London NW1 6XE">
                    </div>
                </div>

                <div class="to-cart" style="margin-top: 13px;">
                    <button name="tocart" type="submit">Add to Cart</button>
                </div>
            </div> <!-- address-container -->
        </div>    
    </form>
</div>

<div class="bottom-right-image">
        <img src="Assets/1Cake.png" alt="Cake Image"> <!-- Replace with your image source -->
    </div>

<script src="https://kit.fontawesome.com/6f42fc440c.js" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>
</html>
