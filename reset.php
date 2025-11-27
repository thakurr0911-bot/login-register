<?php
session_start();
if (isset($_SESSIOn["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location:login.php");
    exit;
}
require_once "../database/db_connect.php";
require_once "functions.php";
include "header.php";

$new_password_err = $confirm_password_err = "";
$new_password = $confirm_password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter the new password";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Password must have at least 6 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please Enter the password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($new_password !== $confirm_password) {
            $confirm_password_err = "passwords do not match.";
        }
    }

    if (empty($new_password_err) && empty($confirm_password_err)) {
        $result = resetpassword($link, $_SESSION["id"], $new_password);
        if ($result["success"]) {
            session_destroy();
            header("location:login.php");
            exit;
        } else {
            echo "<div class='alert alert-danger text-center'>" . $result["message"] . "</div>";
        }
    }
}
?>

<div class="container d-flex justify-content-center mt-5">
    <div class="wrapper border rounded-2 p-3">
        <h2 class="text-center mb-3">
            Reset Password
        </h2>
        <p class="text-center">Please fill this form to reset your password</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group mb-3">
                <label for="" class="form-label">New Password</label>
                <input type="password" name="new_password"
                    class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="" class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password"
                    class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group mb-3">
                <input type="submit" class="btn btn-primary" value="submit">
                <a href="welcome.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>