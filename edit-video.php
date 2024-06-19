<?php
session_start(); // Start the session

require_once './api/dbcon.php';
include('header.php');
?>

<div class="part-1">

    <?php
    $query = "SELECT * FROM `video` WHERE vid = " . $_GET['id'];
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
    <h2>Edit video </h2>


    <?php
    if (mysqli_num_rows($query_result) > 0) {
        while ($video = mysqli_fetch_assoc($query_result)) {
            $source = 'uploads/videos/' . $video['pre_name'];
            $id = "icon" . $video['vid'];

    ?>
            <form action="./api/edit_video.php?id=<?php echo $video['vid'] ?> " method="post" enctype="multipart/form-data">

                <div class="form-1">

                    <div class="message">

                    </div>

                    <div class="control-form">
                        <label for="image_name">video Name</label>
                        <input type="text" name="video_name" value="<?php echo $video['video_name'] ?>">
                    </div>

                    <div class="control-form">
                        <label class="form-label">Upload video</label>
                        <input type="file" accept="audio/mp3, audio/wav" class="form-control" id="f" name="file"  value="<?php echo $video['pre_name'] ?>">
                    </div>

                    <div class="control-form">
                        <input name="upload_video" type="submit" />
                    </div>
                    <h2 onclick="deletes()" ><a href="./api/delete_video.php?id=<?php echo $video['vid'];?>" >Delete</a></h2>

            </form> <?php
                }
            } ?>
</div>

</div>
</div>


</body>

</html>
