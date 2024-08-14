<?php
session_start();
include("../database/env.php");

$user_id = $_SESSION["auth"]["id"];
$name = $_REQUEST["name"];
$email = $_REQUEST["email"];
$img = $_FILES["profile_img"];
$extension = pathinfo($img["name"])["extension"] ?? null;
$isValidEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

$accepted_extension = [
    "jpg",
    "png",
    "jpeg",
    "svg"
];

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

if ($img["size"] > 0) {
    if (!in_array($extension, $accepted_extension)) {
        $errors["image_error"] = "$extension is not acceptable. Accepted extension are " . join(", ", $accepted_extension);
    }
}

if (count($errors) > 0) {
    $_SESSION["errors"] = $errors;
    header("Location: ../dashboard/profile.php");
} else {
    if ($img["size"] > 0) {
        define("UPLOAD_PATH", "../uploads");
        if (!file_exists(UPLOAD_PATH)) {
            mkdir(UPLOAD_PATH);
        }

        $old_profile_img = $_SESSION["auth"]["profile_img"];
        if (!empty($old_profile_img) && file_exists($old_profile_img)) {
            unlink($old_profile_img);
        }

        $file_name = pathinfo($img["name"])["filename"] . uniqid() . ".$extension";
        move_uploaded_file($img["tmp_name"], UPLOAD_PATH . "/$file_name");

        $query = "UPDATE users SET name='$name', email='$email', profile_img='../uploads/$file_name' WHERE id='$user_id'";
    } else {
        $query = "UPDATE users SET name='$name', email='$email' WHERE id='$user_id'";
    }

    $res = mysqli_query($conn, $query);
    if ($res) {
        $query = "SELECT * FROM users WHERE id='$user_id'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
        $_SESSION["auth"] = $user;
        $_SESSION["success"] = true;
        header("Location: ../dashboard/profile.php");
    }
}
