<?php

function show($data){


    echo "<pre>";
        print_r($data);
    echo "</pre>";
}

function resize_image($file,$max_resolution){

    if(file_exists($file)){
        
        $original_image = imagecreatefromjpeg($file);

        // Resolution
        $original_width = imagesx($original_image);
        $original_height = imagesy($original_image);

        // Try width first
        $ratio = $max_resolution / $original_width;

        $new_width = $max_resolution;

        $new_height = $original_height * $ratio;
   


        // If that dint work
        if($new_height > $max_resolution) {
            $ratio = $max_resolution / $original_height;
            $new_height = $max_resolution;
            $new_width = $original_width * $ratio;

        }

        if($original_image){

            $new_image = imagecreatetruecolor($new_width,$new_height);
            imagecopyresampled($new_image,$original_image,0,0,0,0,$new_width,$new_height,$original_width,$original_height);

            imagejpeg($new_image,$file,90);

        }

    }

}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_FILES['image']) && $_FILES['image']['type'] == 'image/jpeg'){

        move_uploaded_file($_FILES['image']['tmp_name'], $_FILES['image']['name']);

        $file = $_FILES['image']['name'];

        resize_image($file,"300");

        echo "<img src='$file'/>";

    }

}


?>

<form action="" method="post" enctype="multipart/form-data">

    <input type="file" name="image"><br/><br/>
    <input type="submit" value="Postar">

</form>