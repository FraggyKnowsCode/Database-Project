<?php
require 'connect.php'; 
session_start();

$email = $password = "";
$email_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, firstName, lastName, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $firstName, $lastName, $db_password);
                if ($stmt->fetch()) {

                    if ($password == $db_password) {

                        $_SESSION["user_id"] = $id;
                        $_SESSION["user_firstName"] = $firstName;
                        $_SESSION["user_lastName"] = $lastName;


                        header("Location: dashboard.php");
                        exit;
                    } else {
                        $login_err = "Invalid password.";
                    }
                }
            } else {
                $login_err = "No account found with that email.";
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Waste Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Login</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="register.php">Register</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                    <span class="error"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <span class="error"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <button type="submit">Login</button>
                    <span class="error"><?php echo $login_err; ?></span>
                </div>
            </form>
        </main>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Food Waste Management System. All rights reserved by Fahad.</p>
        </footer>
    </div>
</body>
</html>
