<?php 

include '../../config/database.php';

$sql = "SELECT * FROM Products";
$result = mysqli_query($conn, $sql);
$output = "";

if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $output .= "<tr>
            <td>{$row['name']}</td>
            <td>{$row['description']}</td>
            <td>{$row['cpu']}</td>
            <td>{$row['gpu']}</td>
            <td>{$row['price']}</td>
            <td>{$row['stock']}</td>
            <td><img src='../../uploads/{$row['image_url']}' width='50px' height='50px'></td>
            <td><button class='edit-btn btn btn-primary' data-id='{$row['product_id']}'>Edit</button></td>
            <td><button class='btn btn-danger delete-btn' data-id='{$row['product_id']}'>Delete</button></td>
        </tr>";
    }
    echo $output;
} else {
    echo "<tr><td colspan='9' class='text-center'>No Record Found</td></tr>";
}
?>