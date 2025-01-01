<?php
session_start();
require 'connect.php';

$email = $password = $error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT id, firstName, password, is_admin FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $firstName, $db_password, $is_admin);
        $stmt->fetch();

        if ($password === $db_password) {
            if ($is_admin == 1) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $firstName;
                $_SESSION['is_admin'] = 1;

                header("Location: admin_panel.php");
                exit;
            } else {
                $error_msg = "You are not authorized to access the admin panel.";
            }
        } else {
            $error_msg = "Invalid password.";
        }
    } else {
        $error_msg = "No account found with that email.";
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <?php echo !empty($error_msg) ? "<p style='color:red;'>$error_msg</p>" : ""; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>
