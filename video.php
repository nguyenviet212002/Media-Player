<?php
include('header.php');
require_once './api/dbcon.php';

?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond&family=DM+Mono:wght@400;500&display=swap');
        body{
            font-family: 'Cormorant Garamond', sans-serif;
            margin: 0;
            padding: 0;
           background:  rgb(25, 134, 163);
        }
        /* Gallery wrapper */
        a{
            font-family: 'Cormorant Garamond', sans-serif;
        }
        h1 {
            font-family: 'Cormorant Garamond', sans-serif;
            text-align: center;
            padding: 40px;
            margin: 0;
            color: beige;
            font-size: 3em;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            grid-gap: 10px;
            max-width: 1200px;
            /* optional */
            margin: 0 auto;
            /* optional */
        }
        /* Thumbnail video */
        
        .gallery video {
            width: 100%;
            height: 200px;
            object-fit: cover;
            /* fill | contain | cover | scale-down */
            cursor: pointer;
        }
        /* Fullscreen video */
        
        .gallery video.full {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            width: 100vw;
            height: 100vh;
            background: #000;
            object-fit: scale-down;
        }
        /* Exit fullscreen */
        
        #vClose {
            position: fixed;
            display: none;
            top: 0;
            right: 0;
            z-index: 9999;
            font-size: 20px;
            font-weight: 700;
            padding: 10px 15px;
            color: #fff;
            background: #741414;
            cursor: pointer;
        }
        
        #vClose.show {
            display: block;
        }
        
        video {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
<h1>Video Gallery</h1>

    <!-- Close fullscreen video -->
    <div id="vClose" onclick="vtog(false)">X</div>

    <!-- Video gallery -->
    <div class="gallery">
    <?php
            $query = "SELECT * FROM video ORDER BY created_at";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_execute($stmt);
            $query_result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($query_result) > 0) {
                while ($video = mysqli_fetch_assoc($query_result)) {
                    $source = './uploads/videos/' . $video['pre_name'];
                    $id = "icon" . $video['vid'];
            ?>
            <div>
        <video width="320" height="240" controls>
            <source src="<?php echo $source ?>" type="video/mp4"> 
           <track default 
                    src="lion.vtt" 
                    kind="captions" 
                    srclang="en"
                    label="English Captions"/>
            
          </video>
           <p><a href="edit-video.php?id=<?php echo $video['vid'] ?>"><?php echo $video['video_name'] ?></a></p>
          </div>
          <?php
                }
            }
                ?>
    </div>

    <!-- <table border="1">
        <thead style="height:15mm;">
            <tr>
                <th style="padding: 15px;">Action</th>
                <th style="padding: 15px;">Video</th>
                <th style="padding: 15px;">Duration</th>
                <th style="padding: 15px;">Edit</th>
                <th style="padding: 15px;">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM video ORDER BY created_at";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_execute($stmt);
            $query_result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($query_result) > 0) {
                while ($video = mysqli_fetch_assoc($query_result)) {
                    $source = 'uploads/audios/' . $video['pre_name'];
                    $id = "icon" . $video['vid'];
            ?>

                    <tr style="padding: 15px;">
                        <td style="text-align: center; line-height:28px;">
                            <?php
                            $data = $video['vid'];
                            $url = "ground.php?data=" . urlencode($data);
                            echo '<a href="' . $url . '">';
                            echo '<i style="font-size: 28px; cursor:pointer;"
                                                class="bi bi-play-circle"></i>';
                            echo '</a>';

                            ?>
                        </td>
                        <td style="padding: 15px;"> <?= htmlspecialchars($video['video_name']) ?></td>

                        <td style="padding: 15px;">
                            <?php
                            echo $video['duration'];
                            ?>
                        </td>
                        <td style="padding: 15px;"  ><a href="edit-video.php?id=<?php echo $video['vid'];?>"> Edit</a> </td>
                        <td style="padding: 15px;" onclick="deletes()" > <a href="./api/delete_video.php?id=<?php echo $video['vid'];?>" >Delete</a></td>
                <?php
                }
            }
                ?>
                    </tr>
        </tbody>


    </table> -->
<script>
        let vid;
        document.addEventListener('DOMContentLoaded', init);

        function init() {
            vid = document.getElementById('video');
            console.log(vid);
            console.log({
                vid
            })
            let mediaType = vid.type;
            let str = vid.canPlayType("video/mp4");
            console.log(str);
            vid.volume = 0.9; //  0 - 1
        }
        let tt = vid.textTracks;
        let cues = tt[0].cues;
        console.log(tt);
        console.log(`There are ${tt.length} text tracks`);
        console.log(tt[0]);
        console.log(cues);
        console.log(cues.length);
        console.log(cues[0]);
        console.log(cues[0].text);
</script>
<?php

include('footer.php');

?>
