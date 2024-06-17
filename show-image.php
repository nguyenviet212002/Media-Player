<?php
include('header.php');
require_once './api/dbcon.php';

?>
<style>
    #btnCounterClockWise,
    #btnClockWise,
    #btnDownload,#blur,#grayscale,#sepia {
        background-color: #04AA6D;
        color: white;
        /* Green */
        border: none;
        padding: 5px 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 10px 5px;
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
    // var_dump($_GET['id']);
    $query = "SELECT * FROM `image` WHERE id = " . $_GET['id'];
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $query_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($query_result) > 0) {
        while ($image = mysqli_fetch_assoc($query_result)) {
            $images = 'uploads/images/' . $image['pre_name'];
    ?>


            <div class="container">
                <img id="image" onclick="rotate90(img)" src="<?php echo $images ?>" width="800" height="500">
            </div>
            <div>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button id="btnCounterClockWise" type="button" class="btn btn-primary"><i class="bi bi-arrow-counterclockwise"></i></button>
                    <button id="btnClockWise" type="button" class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i></button>
 
                </div>
                <div style="display: flex;">
                <button type="button" class="btn btn-primary" id="blur">blur</button>
                <button type="button" class="btn btn-primary" id="sepia">sepia</button>
                <button type="button" class="btn btn-primary" id="grayscale">grayscale</button>

                </div>
                <button type="button" class="btn btn-primary" id="btnDownload">Download</button>

            </div>
    <?php
        }
    } ?>

</div>



<script>
    //
    document.querySelector('#blur').addEventListener('click', function() {
    document.querySelector('#image').style['filter'] = 'blur(5px)';

        });
   
   document.querySelector('#sepia').addEventListener('click', function() {
    document.querySelector('#image').style['filter'] = 'sepia(100%)';

        });
        document.querySelector('#grayscale').addEventListener('click', function() {
    document.querySelector('#image').style['filter'] = 'grayscale(100%)';

        });

    //roating
    window.onload = (event) => {
        // ACCESS IMAGE ELEMENT
        const rotated = document.getElementById('image');

        // VARIABLE TO HOLD THE CURRENT ANGLE OF ROTATION
        let rotation = 0;

        // HOW MUCH TO ROTATE THE IMAGE AT A TIME
        const angle = 90;

        // FUNCTION TO ROTATE IMAGE USING CSS
        function rotateImage(direction) {
            if (direction == 'clockwise') {
                // ENSURE ANG RANGE OF 0 TO 359 WITH "%" OPERATOR
                rotation = (rotation + angle) % 360;
                rotated.style.transform = `rotate(${rotation}deg)`;
            } else if (direction == 'counterclockwise') {
                rotation = (rotation - angle) % 360;
                rotated.style.transform = `rotate(${rotation}deg)`;
            }
        }

        document.querySelector('#btnClockWise').addEventListener('click', function() {
            rotateImage('clockwise');
        });

        document.querySelector('#btnCounterClockWise').addEventListener('click', function() {
            rotateImage('counterclockwise');
        });

        document.querySelector('#btnDownload').addEventListener('click', function() {
            downloadRotated();
        });

        function downloadRotated() {
            let img = new Image();
            img.src = document.getElementById('image').src;

            // CREATE A CANVAS OBJECT
            let canvas = document.createElement("canvas");

            // WAIT TILL THE IMAGE IS LOADED.
            img.onload = function() {
                rotateImage();
                saveImage(img.src.replace(/^.*[\\\/]/, ''));
            }

            let rotateImage = () => {
                // CRATE CANVAS CONTEXT
                let ctx = canvas.getContext("2d");

                // ASSIGN WIDTH AND HEIGHT
                canvas.width = img.width;
                canvas.height = img.height;

                ctx.translate(canvas.width / 2, canvas.height / 2);

                // ROTATE THE IMAGE AND DRAW IT ON THE CANVAS.
                // I AM NOT SHOWING THE CANVAS ON THE WEBPAGE.
                ctx.rotate(rotation * Math.PI / 180);
                ctx.drawImage(img, -img.width / 2, -img.height / 2);
            };

            let saveImage = (img_name) => {
                let a = document.createElement('a');
                a.href = canvas.toDataURL('image/png');
                a.download = img_name;
                document.body.appendChild(a);
                a.click();
            };

        }
    };
    //zoom
    const container = document.querySelector('.container')
    const img = document.querySelector('img')

    let zoom = 1
    container.addEventListener('wheel', e => {
        img.style.transformOrigin = `${e.offsetX}px ${e.offsetY}px`

        zoom += e.deltaY * -0.01
        zoom = Math.min(Math.max(1, zoom), 5)

        if (zoom == 1) {
            img.style.left = '0px'
            img.style.top = '0px'
        }

        img.style.transform = `scale(${zoom})`
    })


    let clicked = false
    let xAxis;
    let x;
    let yAxis;
    let y;

    container.addEventListener('mouseup', () => container.style.cursor = 'auto')

    container.addEventListener('mousedown', e => {
        clicked = true;
        xAxis = e.offsetX - img.offsetLeft;
        yAxis = e.offsetY - img.offsetTop;

        container.style.cursor = 'grabbing'
    })

    window.addEventListener('mouseup', () => clicked = false)

    container.addEventListener('mousemove', e => {
        if (!clicked) return
        e.preventDefault()

        x = e.offsetX
        y = e.offsetY

        img.style.left = `${x - xAxis}px`
        img.style.top = `${y - yAxis}px`

        checkSize()
    })

    function checkSize() {
        let containerOut = container.getBoundingClientRect()
        let imgIn = img.getBoundingClientRect()

        if (parseInt(img.style.left) > 0) {
            img.style.left = '0px'
        } else if (imgIn.right < containerOut.right) {
            img.style.left = `-${imgIn.width - containerOut.width}px`
        }
        if (parseInt(img.style.top) > 0) {
            img.style.top = '0px'
        } else if (imgIn.bottom < containerOut.bottom) {
            img.style.top = `-${imgIn.height - containerOut.height}px`
        }
    }
</script>
<?php

include('footer.php');

?>