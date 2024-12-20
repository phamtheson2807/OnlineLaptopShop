<?php 
include '../../config/database.php';

if(isset($_POST["product_id"])){
    $product_id = $_POST["product_id"];
    $sql = "SELECT * FROM Products WHERE product_id='{$product_id}'";
    $run_sql = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($run_sql) > 0){
        $output .= "<div class='modal-body'>";
        while($row = mysqli_fetch_assoc($run_sql)){
            $output .= "<div class='form-group'>
                <label for=''>Name</label>
                <input type='text' value='{$row["name"]}' name='name' id='edit_name' class='form-control form-control-lg'>
                <input type='hidden' value='{$row["product_id"]}' name='product_id' class='form-control form-control-lg'>
            </div>
            <div class='form-group'>
                <label for=''>Description</label>
                <textarea name='description' id='edit_description' class='form-control form-control-lg'>{$row["description"]}</textarea>
            </div>
            <div class='form-group'>
                <label for=''>CPU</label>
                <input type='text' value='{$row["cpu"]}' name='cpu' id='edit_cpu' class='form-control form-control-lg'>
            </div>
            <div class='form-group'>
                <label for=''>GPU</label>
                <input type='text' value='{$row["gpu"]}' name='gpu' id='edit_gpu' class='form-control form-control-lg'>
            </div>
            <div class='form-group'>
                <label for=''>Price</label>
                <input type='text' value='{$row["price"]}' name='price' id='edit_price' class='form-control form-control-lg'>
            </div>
            <div class='form-group'>
                <label for=''>Stock</label>
                <input type='text' value='{$row["stock"]}' name='stock' id='edit_stock' class='form-control form-control-lg'>
            </div>
            <div class='form-group'>
                <label for=''>Image</label>
                <input type='file' name='new_image' class='form-control form-control-lg'>
                <img src='../../uploads/{$row["image_url"]}' style='width:70px;height:70px' />
                <input type='hidden' value='{$row["image_url"]}' name='old_image' class='form-control form-control-lg'>
            </div>";
        }
        $output .= "</div>";
        echo $output;
    }
}

if(isset($_POST["name"]) && isset($_FILES["image"])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $cpu = $_POST["cpu"];        // Add this line
    $gpu = $_POST["gpu"];        // Add this line
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $file = $_FILES["image"]["name"];
    $temp_file = $_FILES["image"]["tmp_name"];
    $file_size = $_FILES["image"]["size"];
    $extension = array('jpg', 'JPG', 'png', 'PNG', 'JPEG', 'jpeg');
    $validation = pathinfo($file, PATHINFO_EXTENSION);

    $new_name = rand()."-".$file;

    if($file_size > 5671361) {
        echo 2;
    } elseif(!in_array($validation, $extension)) {
        echo 3;
    } else {
        // Update INSERT query to include cpu and gpu
        $sql = "INSERT INTO Products (name, description, cpu, gpu, price, stock, image_url) 
                VALUES ('{$name}', '{$description}', '{$cpu}', '{$gpu}', '{$price}', '{$stock}', '{$new_name}')";
        if(mysqli_query($conn, $sql)) {
            move_uploaded_file($temp_file, "../../uploads/".$new_name);
            echo 1;
        } else {
            echo 0;
        }
    }
}

?>