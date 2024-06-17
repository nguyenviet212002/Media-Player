<?php
session_start(); // Start the session

require_once './api/dbcon.php';
include('header.php');
?>
<div class="part-1">

    <?php
    // Define the active page variable based on the current page
    $active_page = basename($_SERVER['PHP_SELF'], ".php");
    // Include the navbar.php file
    include('side-bar.php');
    ?>

</div>
<div class="part-2">
    <h2>Upload Image </h2>



    <form action="./api/upload_image.php" method="post" enctype="multipart/form-data">

        <div class="form-1">

            <div class="message">
                <?php
                if (isset($_SESSION['Image_Upload'])) {
                    echo $_SESSION['Image_Upload'];
                    unset($_SESSION['Image_Upload']);
                }
                ?>
            </div>

            <div class="control-form">
                <label for="image_name">Image Name</label>
                <input type="text" name="image_name">
            </div>

            <div class="control-form">
                <label class="form-label">Upload Image</label>
                <input type="file" accept="image/png, image/gif, image/ ,image/h" class="form-control" id="f" name="file">
            </div>

            <div class="control-form">
                <input name="upload_image" type="submit" />
            </div>
    </form>
</div>

</div>
</div>


</body>

</html>