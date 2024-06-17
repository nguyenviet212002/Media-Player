<?php
include('header.php');
require_once './api/dbcon.php';

?>
<style>
    div.gallery {

        margin: 5px;
        border: 1px solid #ccc;
        float: left;
        width: 350px;
    }

    div.gallery:hover {
        border: 1px solid #777;
    }

    div.gallery img {
        width: 100%;
        height: auto;
    }

    div.desc {
        color: black;
        background-color: white;
        padding: 15px;
        text-align: center;
    }
</style>
<div class="part-1">

    <?php
    // Define the active page variable based on the current page
    $active_page = basename($_SERVER['PHP_SELF'], ".php");
    // Include the navbar.php file
    include('side-bar.php');
    ?>

</div>

<div class="part-2">
    <h2>Images</h2>

            <?php
            $query = "SELECT * FROM image ORDER BY created_at";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_execute($stmt);
            $query_result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($query_result) > 0) {
                while ($image = mysqli_fetch_assoc($query_result)) {
                    $images = 'uploads/images/' .  $image['pre_name']
                   
            ?>
                <div class="gallery">
                    <a href="show-image.php?id=<?php echo $image['id'];?>" target="_blank" >
                        <img src="<?php echo $images ?>" alt="Cinque Terre" style="width: 350px;height: 200px;">
                    </a>
                    <div class="desc"><?php echo $image['image_name']?></div>
                </div>
                  
                <?php
                }
            } ?>

</div>


<?php

include('footer.php');

?>