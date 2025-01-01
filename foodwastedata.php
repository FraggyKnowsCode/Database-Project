<?php
require 'connect.php'; 

$food_category = $amount_wasted = $cause_of_waste = $location = $disposal_method = $date_of_waste = $user_id = $id = $available = "";
$food_category_err = $amount_wasted_err = $cause_of_waste_err = $location_err = $disposal_method_err = $date_of_waste_err = $user_id_err = $id_err = $available_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["food_category"]))) {
        $food_category_err = "Please select a food category.";
    } else {
        $food_category = trim($_POST["food_category"]);
    }

    if (empty(trim($_POST["amount_wasted"]))) {
        $amount_wasted_err = "Please enter the amount wasted.";
    } elseif (!is_numeric(trim($_POST["amount_wasted"]))) {
        $amount_wasted_err = "Amount wasted must be a number.";
    } else {
        $amount_wasted = trim($_POST["amount_wasted"]);
    }

    if (empty(trim($_POST["cause_of_waste"]))) {
        $cause_of_waste_err = "Please describe the cause of waste.";
    } else {
        $cause_of_waste = trim($_POST["cause_of_waste"]);
    }

    if (empty(trim($_POST["location"]))) {
        $location_err = "Please enter the location.";
    } else {
        $location = trim($_POST["location"]);
    }

    if (empty(trim($_POST["disposal_method"]))) {
        $disposal_method_err = "Please select a disposal method.";
    } else {
        $disposal_method = trim($_POST["disposal_method"]);
    }

    if (empty(trim($_POST["date_of_waste"]))) {
        $date_of_waste_err = "Please enter the date of waste.";
    } else {
        $date_of_waste = trim($_POST["date_of_waste"]);
    }

    if (empty(trim($_POST["user_id"]))) {
        $user_id_err = "Please enter your user ID.";
    } else {
        $user_id = trim($_POST["user_id"]);
    }

    if (empty(trim($_POST["id"]))) {
        $id_err = "Please enter your ID.";
    } else {
        $id = trim($_POST["id"]);
    }

    if (!isset($_POST["available"])) {
        $available_err = "Please specify availability.";
    } else {
        $available = ($_POST["available"] === '1') ? 1 : 0; 
    }

    if (empty($id_err) && empty($date_of_waste_err) && empty($food_category_err) && empty($amount_wasted_err) && empty($cause_of_waste_err) && empty($location_err) && empty($disposal_method_err) && empty($user_id_err) && empty($available_err)) {
        $user_check_sql = "SELECT COUNT(*) FROM users WHERE Id = ?";
        $user_check_stmt = $conn->prepare($user_check_sql);
        $user_check_stmt->bind_param("i", $user_id);
        $user_check_stmt->execute();
        $user_check_stmt->bind_result($user_exists);
        $user_check_stmt->fetch();
        $user_check_stmt->close();

        if ($user_exists == 0) {
            $user_id_err = "User ID does not exist.";
        } else {
            $sql = "INSERT INTO foodwastedata (Id, food_category, amount_wasted, cause_of_waste, location, disposal_method, date_of_waste, user_id, available) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issssssis", $id, $food_category, $amount_wasted, $cause_of_waste, $location, $disposal_method, $date_of_waste, $user_id, $available);

            if ($stmt->execute()) {
                echo "Food waste data submitted successfully!";
                echo '<br><br>';
                echo '<a href="home.php"><button>Go Home</button></a>';
                exit;
            } else {
                echo "Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Food Waste Data - Food Waste Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Submit Food  Data</h1>
            <nav>
                <ul>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="home.php">Home</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="user_id">User ID</label>
                    <input type="text" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                    <span class="error"><?php echo $user_id_err; ?></span>
                </div>

                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" id="id" name="id" value="<?php echo $id; ?>">
                    <span class="error"><?php echo $id_err; ?></span>
                </div>

                <div class="form-group">
                    <label for="date_of_waste">Date of Waste</label>
                    <input type="date" id="date_of_waste" name="date_of_waste" value="<?php echo $date_of_waste; ?>">
                    <span class="error"><?php echo $date_of_waste_err; ?></span>
                </div>

                <div class="form-group">
                    <label for="food_category">Food Category</label>
                    <select id="food_category" name="food_category">
                        <option value="">Select a category</option>
                        <option value="vegetables" <?php echo ($food_category == 'vegetables') ? 'selected' : ''; ?>>Vegetables</option>
                        <option value="fruits" <?php echo ($food_category == 'fruits') ? 'selected' : ''; ?>>Fruits</option>
                        <option value="cooked" <?php echo ($food_category == 'cooked') ? 'selected' : ''; ?>>Cooked</option>
                        <option value="dairy" <?php echo ($food_category == 'dairy') ? 'selected' : ''; ?>>Dairy</option>
                        <option value="dry" <?php echo ($food_category == 'dry') ? 'selected' : ''; ?>>Dry Food</option>
                        <option value="others" <?php echo ($food_category == 'others') ? 'selected' : ''; ?>>Others</option>
                    </select>
                    <span class="error"><?php echo $food_category_err; ?></span>
                </div>

                <div class="form-group">
                    <label for="amount_wasted">Amount Wasted (kg)</label>
                    <input type="number" step="0.01" id="amount_wasted" name="amount_wasted" value="<?php echo $amount_wasted; ?>">
                    <span class="error"><?php echo $amount_wasted_err; ?></span>
                </div>

                <div class="form-group">
                    <label for="cause_of_waste">Cause of Waste</label>
                    <textarea id="cause_of_waste" name="cause_of_waste"><?php echo $cause_of_waste; ?></textarea>
                    <span class="error"><?php echo $cause_of_waste_err; ?></span>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <textarea id="location" name="location"><?php echo $location; ?></textarea>
                    <span class="error"><?php echo $location_err; ?></span>
                </div>

                <div class="form-group">
                    <label for="disposal_method">Disposal Method</label>
                    <select id="disposal_method" name="disposal_method">
                        <option value="">Select a method</option>
                        <option value="landfill" <?php echo ($disposal_method == 'landfill') ? 'selected' : ''; ?>>Landfill</option>
                        <option value="compost" <?php echo ($disposal_method == 'compost') ? 'selected' : ''; ?>>Compost</option>
                        <option value="donation" <?php echo ($disposal_method == 'donation') ? 'selected' : ''; ?>>Donation</option>
                    </select>
                    <span class="error"><?php echo $disposal_method_err; ?></span>
                </div>

                <div class="form-group">
                    <label for="available">Available</label>
                    <input type="radio" id="available_yes" name="available" value="1" <?php echo ($available === '1') ? 'checked' : ''; ?>> Yes
                    <input type="radio" id="available_no" name="available" value="0" <?php echo ($available === '0') ? 'checked' : ''; ?>> No
                    <span class="error"><?php echo $available_err; ?></span>
                </div>

                <div class="form-group">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
