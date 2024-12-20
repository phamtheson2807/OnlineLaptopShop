<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['admin_id'] = 2;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Return Orders</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/adminVIEW.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include 'adminSIDEBAR.php'; ?>
        
        <div class="main-content">
            <?php include 'adminHEADER.php'; ?>
            
            <div class="container my-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Return Orders</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Product</th>
                                        <th>Reason</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Location</th>
                                        <th>Carrier</th>
                                    </tr>
                                </thead>
                                <tbody id="returnOrdersTable">
                                    <!-- Data loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/bootstrap.js"></script>
    <script src="../../assets/js/adminReturnOrders.js"></script>
</body>
</html>