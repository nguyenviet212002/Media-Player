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
    <h2>Images</h2>
    <?php
    // var_dump($_GET['id']);
    $query = "SELECT * FROM `image` WHERE id = ".$_GET['id'];
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $query_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($query_result) > 0) {
        while ($image = mysqli_fetch_assoc($query_result)) {
        $images = 'uploads/images/'.$image['pre_name'];
    ?>

        <img src="<?php echo $images ?>" alt="" style="width: 500px;height: 500px;object-fit: cover;">
         
    <?php
        }
    } ?>
</div>


<?php

include('footer.php');

?>