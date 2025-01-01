<?php
require 'connect.php';

$totalSql = "SELECT SUM(amount) AS total_donations FROM donations";
$totalResult = $conn->query($totalSql);
$totalData = $totalResult->fetch_assoc();
$totalDonations = $totalData['total_donations'];

$methodSql = "SELECT payment_method, SUM(amount) AS method_total FROM donations GROUP BY payment_method";
$methodResult = $conn->query($methodSql);
$methods = $methodResult->fetch_all(MYSQLI_ASSOC);

$donationsSql = "SELECT donor_name, donor_email, amount, payment_method FROM donations";

$donationsResult = $conn->query($donationsSql);
$donations = $donationsResult->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Summary</title>
    
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
        <h1>Donation Summary</h1>
        <nav>
        <ul>
                <li><a href="home.php">Home</a></li>
                </ul>
        </nav>
        </header>

        <h2>Total Donations</h2>
        <p>Total Amount Donated: <strong>BDT <?php echo number_format($totalDonations, 2); ?></strong></p>

        <h2>Donations by Payment Method</h2>
        <?php if (count($methods) > 0): ?>
            <ul>
                <?php foreach ($methods as $method): ?>
                    <li><?php echo htmlspecialchars($method['payment_method']); ?>: BDT <?php echo number_format($method['method_total'], 2); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No donations found.</p>
        <?php endif; ?>

        <h2>Individual Donations</h2>
        <?php if (count($donations) > 0): ?>
            <table border="1">
                <tr>
                    <th>Donor Name</th>
                    <th>Email</th>
                    <th>Amount (BDT)</th>
                    <th>Payment Method</th>
                    
                </tr>
                <?php foreach ($donations as $donation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($donation['donor_name']); ?></td>
                        <td><?php echo htmlspecialchars($donation['donor_email']); ?></td>
                        <td><?php echo number_format($donation['amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($donation['payment_method']); ?></td>
                        
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No donations found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
