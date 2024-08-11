<?php
session_start();

$email = $_REQUEST["email"];
$password = $_REQUEST["password"];

$isValidEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

$errors = [];

// Validations
if (empty($email)) {
    $errors["email_error"] = "Email is Required!";
} else if (!$isValidEmail) {
    $errors["email_error"] = "Invalid Email!";
}

if (empty($password)) {
    $errors["password_error"] = "Password is Required!";
} else if (strlen($password) < 8) {
    $errors["password_error"] = "Password should be greater or equal to 8 characters!";
}

// Error or Send to Dashboard
if (count($errors) > 0) {
    $_SESSION["errors"] = $errors;
    header("Location: ../auth/signin.php");
} else {
    include "../database/env.php";
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $encPassword = $user["password"];
        if (password_verify($password, $encPassword)) {
            $_SESSION["auth"] = $user;
            header("Location: ../dashboard/index.php");
        } else {
            $errors["password_error"] = "Invalid Password!";
            $_SESSION["errors"] = $errors;
            header("Location: ../auth/signin.php");
        }
    } else {
        $errors["email_error"] = "No user found with that email!";
        $_SESSION["errors"] = $errors;
        header("Location: ../auth/signin.php");
    }
}
