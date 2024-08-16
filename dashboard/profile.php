<?php
include("./include/DashboardHeader.php");

?>
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <form enctype="multipart/form-data" action="../controller/UpdateProfile.php" method="POST">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2>Profile</h2>
                            <button class="btn btn-primary">Update Profile</button>
                        </div>
                        <div class="card-body">
                            <div class="row d-flex justify-content-between align-items-center">
                                <div class="col-lg-3">
                                    <label for="avatar">
                                        <img src="<?= getProfileImg() ?>" class="rounded-circle w-100 profile-img" />
                                    </label>
                                    <input accept=".jpg, .jpeg, .png, .svg" type="file" id="avatar" name="profile_img" value="" class="d-none">
                                    <span class="text-danger"><?= $_SESSION["errors"]["image_error"] ?? null ?></span>
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" name="name" id="" class="form-control my-3" value="<?= $_SESSION["auth"]["name"] ?>" placeholder="Your Name" />
                                    <span class="text-danger"><?= $_SESSION["errors"]["name_error"] ?? null ?></span>
                                    <input type="email" name="email" id="" class="form-control my-3" value="<?= $_SESSION["auth"]["email"] ?>" placeholder="Your Email" />
                                    <span class="text-danger"><?= $_SESSION["errors"]["email_error"] ?? null ?></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow">
                <form action="../controller/UpdatePassword.php" method="POST" class="card-body">
                    <span class="text-danger"><?= $_SESSION["errors"]["user_error"] ?? null ?></span>
                    <input type="password" name="current_password" id="current_password" class="form-control my-2" placeholder="Enter Current Password" />
                    <span class="text-danger"><?= $_SESSION["errors"]["current_password_error"] ?? null ?></span>
                    <input type="password" name="new_password" id="new_password" class="form-control my-2" placeholder="Enter New Password" />
                    <span class="text-danger"><?= $_SESSION["errors"]["new_password_error"] ?? null ?></span>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control my-2" placeholder="Enter New Password" />
                    <span class="text-danger"><?= $_SESSION["errors"]["confirm_password_error"] ?? null ?></span>
                    <br />
                    <button class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- / Content -->

<?php
include("./include/DashboardFooter.php");
?>

<script>
    const imageInput = document.querySelector("#avatar");
    const profileImage = document.querySelector(".profile-img");

    function ProfileImageUpdate(event) {
        profileImage.src = URL.createObjectURL(event.target.files[0]);
    }

    imageInput.addEventListener("change", ProfileImageUpdate);
</script>

<?php
if (isset($_SESSION["success"])) {
?>
    <script>
        Toast.fire({
            icon: "success",
            title: "Profile updated successfully"
        });
    </script>
<?php
}
if (isset($_SESSION["password"])) {
?>
    <script>
        Toast.fire({
            icon: "success",
            title: "Password updated successfully"
        });
    </script>
<?php
}
unset($_SESSION["errors"]);
unset($_SESSION["success"]);
unset($_SESSION["password"]);
?>