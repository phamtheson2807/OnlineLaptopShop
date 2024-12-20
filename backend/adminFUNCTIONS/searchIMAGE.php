<?php
include '../../config/database.php';

if(isset($_GET['query'])) {
    $query = $_GET['query'];
    $sql = "SELECT * FROM Products WHERE name LIKE '%{$query}%' OR description LIKE '%{$query}%'";
    $run_sql = mysqli_query($conn, $sql);
    $output = "";

    if(mysqli_num_rows($run_sql) > 0) {
        while($row = mysqli_fetch_assoc($run_sql)) {
            $output .= "
            <tr>
                <td>{$row['name']}</td>
                <td>{$row['description']}</td>
                <td>{$row['price']}</td>
                <td>{$row['stock']}</td>
                <td><img src='../../uploads/{$row['image_url']}' style='width:70px;height:70px;'></td>
                <td><button class='btn btn-info' id='edit-images' data-id='{$row['product_id']}'>Edit</button></td>
                <td><button class='btn btn-danger' id='delete-image' data-id='{$row['product_id']}'>Delete</button></td>
            </tr>";
        }
    } else {
        $output = "<tr><td colspan='7'>No records found</td></tr>";
    }

    echo $output;
}
?>