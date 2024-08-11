<?php
session_start();
include("../database/env.php");

$name = $_REQUEST["name"];
$email = $_REQUEST["email"];
$img = $_FILES["profile_img"];
$isValidEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

$errors = [];

if (empty($name)) {
    $errors["name_error"] = "Name is Required!";
}

if (empty($email)) {
    $errors["email_error"] = "Email Is Required!";
} elseif (!$isValidEmail) {
    $errors["email_error"] = "Invalid Email!";
} else {
    $id = $_SESSION["auth"]["id"];
    $query = "SELECT email FROM users WHERE email = '$email' AND id != '$id' ";
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        $errors["email_error"] = "Email is Already Available";
    }
}

if ($img["error"]) {
    $errors["image_error"] = "Invalid Image!";
} else if (!($img["type"] == "image/png" || $img["type"] == "image/jpeg")) {
    $errors["image_error"] = "Invalid Image Format!. JPG and PNG Allowed.";
} else if (round($img["size"] / 1024) > 300) {
    $errors["image_error"] = "Image Size Should Be Less Than 300KB";
}

if (count($errors) > 0) {
    $_SESSION["errors"] = $errors;
    header("Location: ../dashboard/profile.php");
} else {
    // Update Database
}
