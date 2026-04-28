<?php
include "db.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user already exists
    $check = "SELECT id FROM users WHERE email='$email'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        // User already exists
        $msg = "User already exists with this email!";
    } else {
        // Hash password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password)
                VALUES ('$name', '$email', '$hashed')";

        if ($conn->query($sql)) {
            // Redirect to login after success
            header("Location: login.php");
            exit();
        } else {
            $msg = "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Register</h2>

<form method="post">
Name: <input type="text" name="name" required><br><br>
Email: <input type="email" name="email" required><br><br>
Password: <input type="password" name="password" required><br><br>

<input type="submit" value="Register">
</form>

<p style="color:red;"><?php echo $msg; ?></p>

<a href="login.php">Back to Login</a>

</body>
</html>