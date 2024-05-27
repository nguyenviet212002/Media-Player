<?php
include('header.php');
require_once './api/dbcon.php';

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
    <h2>Audios</h2>
    <table class="song-table" border="1">
        <thead style="height:15mm;">
            <tr>
                <th style="padding: 15px;">Name image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM image ORDER BY created_at";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_execute($stmt);
            $query_result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($query_result) > 0) {
                while ($image = mysqli_fetch_assoc($query_result)) {
                   
            ?>

                    <tr style="height:15mm;">
                    
                        <td><?= htmlspecialchars($image['image_name']) ?></td>

                        <td>
                            <a href="show-image.php?id=<?php echo $image['id'];?>">xem hình ảnh</a>
                        </td>
                <?php
                }
            } ?>
                    </tr>
        </tbody>
    </table>
</div>


<?php

include('footer.php');

?>