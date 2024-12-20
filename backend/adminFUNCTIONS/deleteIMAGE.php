<?php 

include '../../config/database.php';

if(isset($_POST["id"])){
    $product_id = $_POST["id"];
    $sql = "SELECT * FROM Products WHERE product_id='{$product_id}'";
    $run_sql = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($run_sql);

    if ($result) {
        unlink("../../uploads/".$result["image_url"]);
        $sql1 = "DELETE FROM Products WHERE product_id='{$product_id}'";
        $run_sql1 = mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");
        $run_sql1 = mysqli_query($conn, $sql1);
        $run_sql1 = mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");
        if($run_sql1){
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}
?>