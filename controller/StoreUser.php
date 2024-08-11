<?php
session_start();

include("../database/env.php");

$user_name = $_REQUEST["username"];
$email = $_REQUEST["email"];
$password = $_REQUEST["password"];
$confirm_password = $_REQUEST["confirm_password"];
$terms = $_REQUEST["terms"] ?? false;

$encPassword = password_hash($password, PASSWORD_BCRYPT);

$isValidEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

$errors = [];

// Validations
if (empty($user_name)) {
    $errors["name_error"] = "Username is Required!";
}

if (empty($email)) {
    $errors["email_error"] = "Email is Required!";
} else if (!$isValidEmail) {
    $errors["email_error"] = "Invalid Email!";
} else {
    $query = "SELECT email FROM `users` WHERE email = '$email'";
    $res = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($res);

    if ($user) {
        $errors["email_error"] = "Email Already Exists!";
    }
}

if (empty($password)) {
    $errors["password_error"] = "Password is Required!";
} else if (strlen($password) < 8) {
    $errors["password_error"] = "Password should be greater or equal to 8 characters!";
} else if ($password !== $confirm_password) {
    $errors["password_error"] = "Password and Confirm Password does not match!";
}

if (!$terms) {
    $errors["terms_error"] = "Please accept our terms and policy";
}

// Error or Save To Database
if (count($errors) > 0) {
    $_SESSION["errors"] = $errors;
    header("Location: ../auth/signup.php");
} else {
    $query = "INSERT INTO users(name, email, password) VALUES ('$user_name','$email','$encPassword')";
    $res = mysqli_query($conn, $query);
    if ($res) {
        $_SESSION["success"] = "Sign up Successfully";
        header("Location: ../auth/signin.php");
    }
}
