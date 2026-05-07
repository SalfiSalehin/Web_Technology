<?php
// config/database.php — Database connection (procedural MySQLi)

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'university_library');

function get_db_connection() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
        die(json_encode([
            'success' => false,
            'message' => 'Connection failed: ' . mysqli_connect_error()
        ]));
    }
    return $conn;
}
