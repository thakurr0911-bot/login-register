<?php
session_start();
include "header.php";
require_once "functions.php";
require_once "../database/db_connect.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["id"];

// FIXED: added space before ORDER BY
$sql = "SELECT username, country FROM cart   WHERE user_id = ?  ORDER BY id DESC";

if ($stmt = mysqli_prepare($link, $sql)) {

    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<p>";
            echo "Username: " . htmlspecialchars($row['username']) . "<br>";
            echo "Country: " . htmlspecialchars($row['country']) . "<br>";
            echo "</p><hr>";
        }
    } else {
        echo "<p>No records found.</p>";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<p>Query failed.</p>";
}
echo "<a href='welcome.php'>back</a>";