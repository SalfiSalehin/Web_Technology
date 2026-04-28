<?php
session_start();
include "db.php";

$cookie_email = $_COOKIE['user_email'] ?? "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];

            // Cookies
            setcookie("user_email", $email, time()+86400, "/");
            setcookie("last_login", date("Y-m-d H:i:s"), time()+86400, "/");

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Wrong password!";
        }
    } else {
        $error = "No account found!";
    }
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Login</h2>

<form method="post">
Email: <input type="email" name="email" value="<?php echo $cookie_email; ?>" required><br><br>
Password: <input type="password" name="password" required><br><br>
<input type="submit" value="Login">
</form>

<p style="color:red;"><?php echo $error; ?></p>

<p>Don't have an account? <a href="register.php">Register</a></p>

</body>
</html>