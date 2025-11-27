<?php
include '../database/db_connect.php';
function usernameExists($link, $username)
{
    $sql = "SELECT id from users WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $param_username);
        $param_username = $username;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $exists = mysqli_stmt_num_rows($stmt) == 1 ? true : false;
        mysqli_stmt_close($stmt);
        return $exists;
    }
    return false;
}

function registeUser($link, $username, $password)
{
    $sql = "INSERT INTO users(username, password,created_at) VALUES (?,?,NOW())";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
    return false;
}


function validateForm($link, $data)
{
    $errors = ['username' => '', 'password' => '', 'confirm_password' => ''];
    $username = trim($data['username']);
    $password = trim($data['password']);
    $confirm_password = trim($data['confirm_password']);

    if (empty($username)) {
        $errors['username'] = "please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors['username'] = "Username can only contain letters,numbers and UnderScores";
    } elseif (usernameExists($link, $username)) {
        $errors['username'] = "This username is already taken.";
    }

    if (empty($password)) {
        $errors['password'] = "please enter a password.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "password must have at least 6 characters.";
    }

    if (empty($confirm_password)) {
        $errors['confirm_password'] = "please confirm password.";
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = "password did not match.";
    }
    return [$errors, $username, $password, $confirm_password];
}

function validateLogin($link, $username, $password)
{
    $errors = ["username" => "", "password" => "", "login" => ""];
    $user = null;

    $username = trim($username);
    $password = trim($password);

    if (empty($username)) {
        $errors["username"] = "Please enter username.";
    }
    if (empty($password)) {
        $errors["password"] = "please enter Password";
    }
    if (empty($errros["username"]) && empty($errors["password"])) {
        $sql = "SELECT id,username,password FROM users WHERE username =?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $db_username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            $user = ["id" => $id, "username" => $db_username];
                        } else {
                            $errors["login"] = "Invalid Username or password.";
                        }
                    }
                } else {
                    $errors["login"] = "Invalid username or password.";
                }
            } else {
                $erros["login"] = "Oops! Something went wrong Please try again";
            }
            mysqli_stmt_close($stmt);
        }
    }
    return ["success" => empty($errors["username"]) && empty($errors["password"]) && empty($errors["login"]), "errors" => $errors, "user" => $user];
}

function resetpassword($link, $userId, $newpassword)
{
    if (strlen($newpassword) < 6) {
        return ["success" => false, "message" => "password must have at least 6 characters."];
    }
    $sql = "UPDATE users SET password=? ,created_at=NOW() WHERE id=?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        $hashedpassword = password_hash($newpassword, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "si", $hashedpassword, $userId);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return ["success" => true, "message" => "password reset successful"];
        } else {
            mysqli_stmt_close($stmt);
            return ["success" => false, "message" => "Something went wrong,try again later."];
        }
    } else {
        return ["success" => false, "message" => "Database query failed."];
    }
}
