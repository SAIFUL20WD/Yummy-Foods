<?php
session_start();

$title = $_REQUEST["title"];
$detail = $_REQUEST["detail"];
$cta_tilte = $_REQUEST["cta_title"];
$cta_link = $_REQUEST["cta_link"];
$video_link = $_REQUEST["video_link"];
$banner_image = $_FILES["banner_image"];
$extension = pathinfo($banner_image["name"])["extension"] ?? null;

$acceptedExtension = ["jpg", "png"];

$errors = [];

if (empty($title)) {
    $errors["title_error"] = "Title is Required!";
}

if (empty($detail)) {
    $errors["detail_error"] = "Detail is Required!";
}

if ($banner_image["size"] == 0) {
    $errors["banner_image_error"] = "Banner Image is Required!";
} elseif (!in_array($extension, $acceptedExtension)) {
    $errors["banner_image_error"] = "$extension is not acceptable. Accepted extension are" . join(", ", $acceptedExtension);
}

if (count($errors) > 0) {
    $_SESSION["errors"] = $errors;
    header("Location: ../dashboard/banner.php");
} else {
    define("UPLOAD_PATH", "../uploads");
    if (!file_exists(UPLOAD_PATH)) {
        mkdir(UPLOAD_PATH);
    }
    $file_name = "Banner-" . uniqid() . ".$extension";
    move_uploaded_file($banner_image["tmp_name"], UPLOAD_PATH . "/$file_name");

    include("../database/env.php");

    $query = "INSERT INTO banners(title, detail, cta_title, cta_link, video_link, banner_img) VALUES ('$title','$detail','$cta_tilte','$cta_link','$video_link','../uploads/$file_name')";
    $res = mysqli_query($conn, $query);
    if ($res) {
        $_SESSION["success"] = true;
        header("Location: ../dashboard/banner.php");
    }
}
