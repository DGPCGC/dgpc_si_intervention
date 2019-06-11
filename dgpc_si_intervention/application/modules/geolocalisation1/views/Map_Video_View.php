<!DOCTYPE html>
<html lang="en">

<head>
<?php include VIEWPATH.'includes/header.php' ?>
</head>
<body>
    <div class="container" style="background-color: white">
       <fieldset>
       	<legend>Video</legend>
       
       <?php
       echo '<video controls width="250"> <source src="data:video/mp4;base64,'.base64_encode($video['VIDEO_BLOB']) .'" type="video/mp4"> </video>';                                      
                          
       ?>
       </fieldset>
    </div>
    </body>
    </html>