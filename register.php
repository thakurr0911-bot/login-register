<?php
require_once "functions.php";
include "header.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    list($errors, $username, $password, $confirm_password) = validateForm($link, $_POST);

    $username_err = $errors['username'];
    $password_err = $errors['password'];
    $confirm_password_err = $errors['confirm_password'];

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        if (registeUser($link, $username, $password)) {
            header("location: login.php");
            exit;
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>
<div class="container d-flex justify-content-center mt-5">
    <div class="wrapper border rounded p-3">
        <h2 class="text-center mb-3">Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" placeholder="Please Enter Username"
                    class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" placeholder="Please Enter Password"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Please Confirm Password"
                    class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group mb-3">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</div>
<?php include "footer.php"; ?>