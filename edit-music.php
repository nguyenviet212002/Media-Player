<?php
session_start(); // Start the session

require_once './api/dbcon.php';
include('header.php');
?>

<div class="part-1">

    <?php
    $query = "SELECT * FROM `music` WHERE mid = " . $_GET['id'];
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
    <h2>Edit Music </h2>


    <?php
    if (mysqli_num_rows($query_result) > 0) {
        while ($music = mysqli_fetch_assoc($query_result)) {
            $source = 'uploads/audios/' . $music['pre_name'];
            $id = "icon" . $music['mid'];

    ?>
            <form action="./api/edit_music.php?id=<?php echo $music['mid'] ?> " method="post" enctype="multipart/form-data">

                <div class="form-1">

                    <div class="message">

                    </div>

                    <div class="control-form">
                        <label for="image_name">Music Name</label>
                        <input type="text" name="music_name" value="<?php echo $music['music_name'] ?>">
                    </div>

                    <div class="control-form">
                        <label class="form-label">Upload Music</label>
                        <input type="file" accept="audio/mp3, audio/wav" class="form-control" id="f" name="file"  value="<?php echo $music['pre_name'] ?>">
                    </div>

                    <div class="control-form">
                        <input name="upload_music" type="submit" />
                    </div>

            </form> <?php
                }
            } ?>
</div>

</div>
</div>


</body>

</html>