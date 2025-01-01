<?php
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donor_name = $_POST['donor_name'];
    $donor_email = $_POST['donor_email'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    $sql = "INSERT INTO donations (donor_name, donor_email, amount, payment_method)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $donor_name, $donor_email, $amount, $payment_method);
    if ($stmt->execute()) {
        $success = "Thank you for your donation of BDT $amount!";
    } else {
        $error = "An error occurred. Please try again.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
        <h1>Make a Donation</h1>
        <nav>
        <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="donation_summary.php">Donation Summary</a></li>
        </ul>
        </nav>
        </header>

        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php elseif (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <form method="POST" action="">
            <label for="donor_name">Your Name:</label><br>
            <input type="text" id="donor_name" name="donor_name" required><br><br>

            <label for="donor_email">Your Email:</label><br>
            <input type="email" id="donor_email" name="donor_email" required><br><br>

            <label for="amount">Donation Amount (BDT):</label><br>
            <input type="number" id="amount" name="amount" min="1" step="0.01" required><br><br>

            <label for="payment_method">Payment Method:</label><br>
            <select id="payment_method" name="payment_method" required>
                <option value="Cash">Cash</option>
                <option value="Mobile Payment">Mobile Payment</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select><br><br>

            <input type="submit" value="Donate">
        </form>
    </div>
</body>
</html>
