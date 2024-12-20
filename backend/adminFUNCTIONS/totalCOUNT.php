<?php 

include '../../config/database.php';

$sql = "SELECT * FROM Products";
$run_sql = mysqli_query($conn, $sql);
$result = mysqli_num_rows($run_sql);
echo $result;

?>