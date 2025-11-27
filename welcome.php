<?php
session_start();
include "header.php";
require_once "functions.php";
require_once "../database/db_connect.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

function updatedata($link, $user_name, $country)
{
    $sql = "INSERT INTO cart (username, country, user_id) VALUES (?,?,?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssi", $param_user_name, $param_country, $param_user_id);
        $param_user_name = $user_name;
        $param_country   = $country;
        $param_user_id   = $_SESSION["id"];
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
    return false;
}
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = trim($_POST['user_name']);
    $country   = trim($_POST['country']);
    if ($user_name !== "" && $country !== "") {
        if (updatedata($link, $user_name, $country)) {
            $message = "<div class='alert alert-success'>Data inserted successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error inserting data.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Please fill all fields.</div>";
    }
}
?>
<div class="bg-warning p-3">
    <h1 class="text-center">WELCOME BACK! <b class="text-primary"><?php echo ucfirst(htmlspecialchars($_SESSION["username"])); ?></b></h1>
</div>
<div class="container mt-5 text-center">
    <div class="d-flex justify-content-between">
        <p class="card p-3 bg-light">You Can Reset Your Password <a href="reset.php" class="text-decoration-none text-warning">Reset Password</a></p>
        <p class="card p-3 bg-light"><a href="cart.php" class="text-decoration-none text-success ">Cart page</a></p>
        <p class="card p-3 bg-light">Sign Out of your Account <a href="logout.php" class="text-decoration-none text-danger ">logout</a></p>
    </div>
    <?php echo $message; ?>
    <div class="mt-4 d-flex justify-content-between">
        <form action="" method="post">
            <h2>USER INFORMATION</h2>
            <div class="mt-3">
                <label for="country">Choose a Country:</label>
                <select id="country" name="country" class="form-control" style="max-width:300px;margin:auto;">
                    <option value="">--Select Country--</option>
                    <option value="india">India</option>
                    <option value="usa">USA</option>
                    <option value="canada">Canada</option>
                    <option value="uk">United Kingdom</option>
                </select>
            </div>
            <div class="mt-3">
                <label>User Name</label>
                <input type="text" name="user_name" class="form-control" style="max-width:300px;margin:auto;">
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary" name="button_save">Save</button>
            </div>
        </form>
        <div class="border rounded py-2 px-5">
            <?php
            $listItems = ["List1", "List 1", "List 1", "List 1", "List 1", "List 1", "List 1", "List 1", "List 1", "List 1"];
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $perpage = 3;
            $totalItems = count($listItems);
            $totalpages = ceil($totalItems / $perpage);
            $offset = ($page - 1) * $perpage;
            $currentItems = array_slice($listItems, $offset, $perpage);
            echo "<ol start='" . ($offset + 1) . "'>";
            foreach ($currentItems as $item) {
                echo "<li>" . htmlspecialchars($item) . "</li>";
            }
            echo "</ol>";
            if ($page > 1) {
                echo '<a href="?page=' . ($page - 1) . '">Prev</a>';
            }
            if ($page < $totalpages) {
                echo '<a href="?page=' . ($page + 1) . '">next</a>';
            }
            ?>
        </div>
    </div>
</div>


