<?php
session_start();
require_once "functions.php";
include "header.php";
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location:welcome.php");
    exit;
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = validateLogin($link, $username, $password);
    $username_errr = $result["errors"]["username"];
    $password_err = $result["errors"]["password"];
    $login_err = $result["errors"]["login"];

    if ($result["success"]) {
        $user = $result["user"];
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        header("location:welcome.php");
        exit;
    }
    mysqli_close($link);
}
?>
<div class="container d-flex justify-content-center mt-5">
    <div class="wrapper border rounded-2 p-3">
        <h2 class="text-center">Login</h2>
        <p>Please fill in your credentials to login.</p>
        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group mb-3">
                <label for="" class="form-label">Username</label>
                <input type="text" name="username" placeholder="Please Enter Username"
                    class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo htmlspecialchars($username) ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="" class="form-label">Password</label>
                <input type="password" name="password" placeholder="Please Enter Password" class="form-control" <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>
                    value="<?php echo htmlspecialchars($password) ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group mb-3">
                <input type="submit" class="btn btn-primary" value="login">
            </div>
            <p>Don't have an Account?<a href="register.php">Sign Up now</a>.</p>
        </form>
    </div>
</div>
<?php include "footer.php"; ?>