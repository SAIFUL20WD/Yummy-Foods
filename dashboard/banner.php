<?php
include("./include/DashboardHeader.php");
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <form action="../controller/StoreBanner.php" method="POST" enctype="multipart/form-data">
                    <div class="card-header d-flex py-0 pt-3 justify-content-between align-items-center">
                        <h4>Add Banner</h4>
                        <button class="btn btn-primary">Store</button>
                    </div>
                    <div class="card-body">
                        <input type="" name="title" class="form-control my-2" value="" placeholder="Banner Title">
                        <span class="text-danger"><?= $_SESSION["errors"]["title_error"] ?? null ?></span>
                        <textarea name="detail" class="form-control my-2" placeholder="Banner Detail"></textarea>
                        <span class="text-danger"><?= $_SESSION["errors"]["detail_error"] ?? null ?></span>
                        <input type="" name="cta_title" class="form-control my-2" placeholder="Cta Title">
                        <input type="" name="cta_link" class="form-control my-2" placeholder="Cta Link">
                        <input type="" name="video_link" class="form-control my-2" placeholder="Video Link">
                        <label for="" class="d-block">
                            Banner Image
                            <input accept=".jpg, .png" type="file" name="banner_image" class="form-control">
                        </label>
                        <span class="text-danger"><?= $_SESSION["errors"]["banner_image_error"] ?? null ?></span>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-lg-8">
            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Banner Title</th>
                            <th>CTA</th>
                            <th>Video</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td>#</td>
                            <td>Banner Title</td>
                            <td>Cta</td>
                            <td>Video</td>
                            <td>E, D</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>



    </div>
</div>

<?php
include("./include/DashboardFooter.php");

if (isset($_SESSION["success"])) {
?>
    <script>
        Toast.fire({
            icon: "success",
            title: "Banner Stored successfully"
        });
    </script>
<?php
}

unset($_SESSION["errors"]);
unset($_SESSION["success"])
?>