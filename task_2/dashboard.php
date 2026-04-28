<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Dashboard</h2>

<p>Welcome, <?php echo $_SESSION['name']; ?>!</p>

<?php
if (isset($_COOKIE['last_login'])) {
    echo "<p>Last Login: " . $_COOKIE['last_login'] . "</p>";
}
?>

<a href="logout.php">Logout</a>

</body>
</html>