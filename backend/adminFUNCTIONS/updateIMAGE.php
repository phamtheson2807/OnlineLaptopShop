<?php
include '../../config/database.php';

if(isset($_POST['product_id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['cpu']) && isset($_POST['gpu']) && isset($_POST['price']) && isset($_POST['stock'])) {
    
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $cpu = $_POST['cpu'];
    $gpu = $_POST['gpu']; 
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $old_image = $_POST['old_image'];

    // Check if new image was uploaded
    if(isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $file = $_FILES['image']['name'];
        $tmp_file = $_FILES['image']['tmp_name'];
        $file_size = $_FILES['image']['size'];
        $extension = array("jpeg", "jpg", "png", "gif", "JPEG", "JPG", "PNG", "GIF");
        $validation = pathinfo($file, PATHINFO_EXTENSION);
        
        if($file_size > 5671361) {
            echo 2; // File too large
            exit;
        }
        if(!in_array($validation, $extension)) {
            echo 3; // Invalid extension
            exit;
        }

        $new_image = rand()."-".$file;
        
        // Upload new image and delete old one
        if(move_uploaded_file($tmp_file, '../../uploads/'.$new_image)) {
            if(file_exists('../../uploads/'.$old_image)) {
                unlink('../../uploads/'.$old_image);
            }
            // Update with new image
            $sql = "UPDATE Products SET 
                    name='{$name}', 
                    description='{$description}', 
                    cpu='{$cpu}',
                    gpu='{$gpu}',
                    price='{$price}', 
                    stock='{$stock}', 
                    image_url='{$new_image}' 
                    WHERE product_id='{$product_id}'";
        }
    } else {
        // Update without changing image
        $sql = "UPDATE Products SET 
                name='{$name}', 
                description='{$description}', 
                cpu='{$cpu}',
                gpu='{$gpu}',
                price='{$price}', 
                stock='{$stock}' 
                WHERE product_id='{$product_id}'";
    }

    if(mysqli_query($conn, $sql)) {
        echo 1; // Success
    } else {
        echo 0; // Database error
    }
} else {
    echo 0; // Missing required fields
}
?>