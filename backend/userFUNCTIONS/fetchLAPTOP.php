<?php
include '../../config/database.php';

function getLaptops($conn) {
    $sql = "SELECT product_id, name, description,cpu, gpu, price, stock, image_url FROM Products";
    $result = $conn->query($sql);
    
    $laptops = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $laptops[] = $row;
        }
    }
    return json_encode($laptops);
}

header('Content-Type: application/json');
echo getLaptops($conn);
$conn->close();
?>