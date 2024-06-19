<?php
session_start(); // Start the session

require_once './api/dbcon.php';
include('header.php');
?>

<div class="part-1">

    <?php
    $query = "SELECT * FROM `image` WHERE id = " . $_GET['id'];
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $query_result = mysqli_stmt_get_result($stmt);
    // Define the active page variable based on the current page
    $active_page = basename($_SERVER['PHP_SELF'], ".php");
    // Include the navbar.php file
    include('side-bar.php');
    ?>

</div>
<div class="part-2">
    <h2>Edit image </h2>


    <?php
    if (mysqli_num_rows($query_result) > 0) {
        while ($image = mysqli_fetch_assoc($query_result)) {
            $source = 'uploads/images/' . $image['pre_name'];
            $id = "icon" . $image['id'];

    ?>
            <form action="./api/edit_image.php?id=<?php echo $image['id'] ?> " method="post" enctype="multipart/form-data">

                <div class="form-1">

                    <div class="message">

                    </div>

                    <div class="control-form">
                        <label for="image_name">Image Name</label>
                        <input type="text" name="image_name" value="<?php echo $image['image_name'] ?>">
                    </div>

                    <div class="control-form">
                        <label class="form-label">Upload image</label>
                        <input type="file" accept="audio/mp3, audio/wav" class="form-control" id="f" name="file"  value="<?php echo $image['pre_name'] ?>">
                    </div>

                    <div class="control-form">
                        <input name="upload_image" type="submit" />
                    </div>

            </form>
            <h2 onclick="deletes()" ><a href="./api/delete_image.php?id=<?php echo $image['id'];?>" >Delete</a></h2>
            <?php
                }
            } ?>

</div>

</div>
</div>
<script>
funtion deletes(){
    alert("bạn có muốn xóa không ?")
}</script>

</body>

</html>
