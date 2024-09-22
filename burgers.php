<?php
session_start();
require_once "config.php";
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}
if ($_SESSION["admin"] == 'NO') {
    header("location: index.php");
    exit();
}

// Fetch the food items from the database
$sql = "SELECT * FROM fooditems";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}

// Group food items by itemName
$foodItems = [];
while ($row = $result->fetch_assoc()) {
    $foodItems[$row['itemName']][] = $row;
}

// Handle form submission to update food item prices
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['food'])) {
        foreach ($_POST['food'] as $id => $foodData) {
            $price = $foodData['price'];
            $discountedPrice = $foodData['discountedPrice'];

            $updateQuery = "UPDATE fooditems SET price = '$price', discountedPrice = '$discountedPrice' WHERE id = '$id'";
            if (!$conn->query($updateQuery)) {
                die("Error updating record: " . $conn->error);
            }
        }
        header("location: burgers.php");
        exit();
    }

    // Handle form submission to create a new food item
    if (isset($_POST['addFoodItem'])) {
        $itemName = $_POST['itemName'];
        $price = $_POST['price'];
        $discountedPrice = $_POST['discountedPrice'];
        $itemType = $_POST['itemType'];

        // Prepare an SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO fooditems (itemName, price, discountedPrice, itemType) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $itemName, $price, $discountedPrice, $itemType);

        if ($stmt->execute()) {
            echo "<script>
                alert('New food item added successfully!');
                window.location.href = 'burgers.php';
            </script>";
        } else {
            echo "Error adding food item: " . $stmt->error;
        }

        $stmt->close();
    }
}
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
            <li class="brand"><img src="Assets/logo.png" alt="Music">King Of Burgers</li>
            <ul class="right-ul">
                <li><a href="index.php">Home</a></li>
                <li><a href="sales.php">Sales</a></li>
                <li><a id="active" href="burgers.php">Burgers</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </ul>
    </nav>
    
    <div class="container" style="display: flex; flex-direction: column; justify-content: space-between; align-items: flex-end;">
        <div class="add-food-item" style= "margin-top: 80px; width: 180px;"> 
            <button id="openModal">Add New Food Item</button>
        </div>
        <form method="POST" action="">
            <div class="food-items">
            
                <?php
                foreach ($foodItems as $itemName => $items) {
                    // Display the item name once
                    echo '<div class="food">';
                    echo '<div class="food-details">';
                    echo '<h3>' . htmlspecialchars($itemName) . '</h3>';
                    echo '<ul>';
                    
                    foreach ($items as $item) {
                        $itemClass = ($item['itemType'] === 'Non-Veg') ? 'read' : 'green';
                        echo '<li class="' . $itemClass . '">';
                        echo 'Price: Rs. <input type="number" name="food[' . $item['id'] . '][price]" value="' . htmlspecialchars($item['price']) . '" min="0" required>';
                        echo '  Discounted Price: Rs. <input type="number" name="food[' . $item['id'] . '][discountedPrice]" value="' . htmlspecialchars($item['discountedPrice']) . '" min="0" required>';
                        echo '</li>';
                    }
                    
                    echo '</ul>';
                    echo '</div>'; // food-details
                    echo '</div>'; // food
                }
                ?>
                <div class="to-cart1">
                    <button type="submit">Update Prices</button>
                </div>
            </div>
        </form>

    </div>

    <div id="foodItemModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 style="margin-bottom: 10px;">Add New Food Item</h2>
            <form method="POST" action="">
                <table style="border-collapse: collapse; width: 100%;">
                    <tr>
                        <td style="padding: 10px;"><label for="itemName">Item Name:</label></td>
                        <td style="padding: 10px;"><input type="text" name="itemName" required></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;"><label for="price">Price:</label></td>
                        <td style="padding: 10px;"><input type="number" name="price" min="0" required></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;"><label for="discountedPrice">Discounted Price:</label></td>
                        <td style="padding: 10px;"><input type="number" name="discountedPrice" min="0" required></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;"><label for="itemType">Item Type:</label></td>
                        <td style="padding: 10px;">
                            <select name="itemType" required>
                                <option value="Veg">Veg</option>
                                <option value="Non-Veg">Non-Veg</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div style="text-align: center; margin-top: 15px;">
                    <button type="submit" name="addFoodItem">Add Food Item</button>
                </div>
            </form>
        </div>
    </div>



    <script src="https://kit.fontawesome.com/6f42fc440c.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>

    <script>
        // Get the modal
        var modal = document.getElementById("foodItemModal");

        // Get the button that opens the modal
        var btn = document.getElementById("openModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
