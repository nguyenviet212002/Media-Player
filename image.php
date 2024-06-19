<?php
require_once './api/dbcon.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>HTML Video Element</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- <link rel="stylesheet" href="main.css" /> -->

</head>

<body>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond&family=DM+Mono:wght@400;500&display=swap');
        /* Basic styling for the gallery */
        
        body {
            font-family: 'Cormorant Garamond', sans-serif;
            margin: 0;
            padding: 0;
           background:  rgb(25, 134, 163);
        }
        
        h1 {
            text-align: center;
            padding: 40px;
            margin: 0;
            color: beige;
            font-size: 3em;
        }
        
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }
        
        .gallery img {
            margin: 10px;
            cursor: pointer;
            max-width: 300px;
            width: 50%;
            height: 200px;
            border-radius: 10px;
        }
        /* Lightbox styles */
        
        #lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            overflow: hidden;
            flex-direction: column;
        }
        
        #lightbox img {
            max-width: 80%;
            max-height: 60vh;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.8);
            border-radius: 10px;
        }
        
        #close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #fff;
            cursor: pointer;
            z-index: 2;
        }
        /* Style for navigation buttons */
        
        #prev-btn,
        #next-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #fff;
            background-color: rgba(0, 0, 0, 0.5);
            border: none;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        #prev-btn {
            left: 10px;
        }
        
        #next-btn {
            right: 10px;
        }
        
        #prev-btn:hover,
        #next-btn:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
        /* Styles for thumbnails */
        
        .thumbnail-container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .thumbnail {
            width: 50px;
            height: 40px;
            cursor: pointer;
            margin-top: 40px;
            margin-left: 5px;
            margin-right: 5px;
            border: 2px solid #fff;
            transition: opacity 0.3s;
        }
        
        .thumbnail:hover,
        .thumbnail.active-thumbnail {
            opacity: 0.7;
        }
        #close-btn{
            font-size:30px
        }
    </style>
    <h1>Image Gallery</h1>
  
    <div class="gallery" onclick="openLightbox(event)">
    <?php
            $query = "SELECT * FROM image ORDER BY created_at";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_execute($stmt);
            $query_result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($query_result) > 0) {
                while ($image = mysqli_fetch_assoc($query_result)) {
                    $images = 'uploads/images/' .  $image['pre_name']
                   
            ?>
    <div style="display:block">
        <img src="<?php echo $images?>" alt="Image 1" id="image" style="height:150px;width:200px">
        <p style="margin-left:10px;"><a href="edit-image.php?id=<?php echo $image['id']?>" style="color:white;text-decoration:none"><?php echo $image['image_name']?></a></p>
    </div>
        <?php
                }
            } ?>

    </div>
  
    <!-- Lightbox container -->
    <div id="lightbox">

        <!-- Close button -->
        <span id="close-btn" onclick="closeLightbox()" >&times;</span>

        <!-- Main lightbox image -->
        <img id="lightbox-img" src="" alt="lightbox image" style="height: 500px;width: 700px;padding-top:20px;object-fit:cover">

        <!-- Thumbnails container -->
        <div id="thumbnail-container">
            <!-- Thumbnails will be added dynamically using JavaScript -->
        </div>

        <!-- Previous and Next buttons -->
        <button id="prev-btn" onclick="changeImage(-1)"><</button>
        <button id="next-btn" onclick="changeImage(1)">></button>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button id="btnCounterClockWise" type="button" class="btn btn-primary"><i class="bi bi-arrow-counterclockwise"></i></button>
            <button id="btnClockWise" type="button" class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i></button>
        </div>
        <button type="button" class="btn btn-primary" id="blur">blur</button>
        <button type="button" class="btn btn-primary" id="sepia">sepia</button>
        <button type="button" class="btn btn-primary" id="grayscale">grayscale</button>
        <button type="button" class="btn btn-primary" id="btnDownload">Download</button>

    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script>
        let currentIndex = 0;
        const images = document.querySelectorAll('.gallery img');
        const totalImages = images.length;

        // Open the lightbox
        function openLightbox(event) {
            if (event.target.tagName === 'IMG') {
                const clickedIndex = Array.from(images).indexOf(event.target);
                currentIndex = clickedIndex;
                document.getElementById('lightbox').classList.add(currentIndex)
                updateLightboxImage();
                document.getElementById('lightbox').style.display = 'flex';
                document.getElementById("blur").addEventListener("click", function() {
                    document.querySelector('#lightbox-img').style['filter'] = 'blur(5px)';

                });
                document.querySelector('#sepia').addEventListener('click', function() {
                    document.querySelector('#lightbox-img').style['filter'] = 'sepia(100%)';

                });
                document.querySelector('#grayscale').addEventListener('click', function() {
                    document.querySelector('#lightbox-img').style['filter'] = 'grayscale(100%)';

                });
                // ACCESS IMAGE ELEMENT
                const rotated = document.getElementById('lightbox-img');
                console.log(rotated)
                    // VARIABLE TO HOLD THE CURRENT ANGLE OF ROTATION
                let rotation = 0;

                // HOW MUCH TO ROTATE THE IMAGE AT A TIME
                const angle = 90;

                // FUNCTION TO ROTATE IMAGE USING CSS
                function rotateImage(direction) {
                    rotated.style.margin = "60px" 
                    rotated.style.height = "500px" 
                    rotated.style.width = "700px" 
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
                    img.src = document.getElementById('lightbox-img').src;

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
                        a.href = canvas.toDataURL('image/png,image/jpg');
                        a.download = img_name;
                        document.body.appendChild(a);
                        a.click();
                    };

                }
            };

        }


        // Close the lightbox
        function closeLightbox() {
            document.getElementById('lightbox').style.display = 'none';
        }

        // Change the lightbox image based on direction (1 for next, -1 for prev)
        function changeImage(direction) {
            currentIndex += direction;
            console.log(currentIndex)
            if (currentIndex >= totalImages) {
                currentIndex = 0;
            } else if (currentIndex < 0) {
                currentIndex = totalImages - 1;
            }
            updateLightboxImage();
        }


        // Update the lightbox image and thumbnails
        function updateLightboxImage() {
            const lightboxImg = document.getElementById('lightbox-img');
            const thumbnailContainer = document.getElementById('thumbnail-container');

            // Update the main lightbox image
            lightboxImg.src = images[currentIndex].src;

            // Clear existing thumbnails
            thumbnailContainer.innerHTML = '';

            // Add new thumbnails
            images.forEach((image, index) => {
                const thumbnail = document.createElement('img');
                thumbnail.src = image.src;
                thumbnail.alt = `Thumbnail ${index + 1}`;
                thumbnail.classList.add('thumbnail');
                thumbnail.addEventListener('click', () => updateMainImage(index));
                thumbnailContainer.appendChild(thumbnail);
            });

            // Highlight the current thumbnail
            const thumbnails = document.querySelectorAll('.thumbnail');
            thumbnails[currentIndex].classList.add('name');
            thumbnails[currentIndex].classList.add('active-thumbnail');

        }

        // Update the main lightbox image when a thumbnail is clicked
        function updateMainImage(index) {
            currentIndex = index;
            updateLightboxImage();
        }

        // Add initial thumbnails
        updateLightboxImage();


        // To add keyboard navigation (left/right arrow keys)
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('lightbox').style.display === 'flex') {
                if (e.key === 'ArrowLeft') {
                    changeImage(-1);
                } else if (e.key === 'ArrowRight') {
                    changeImage(1);
                }
            }
        });
    </script>
</body>

</html>
