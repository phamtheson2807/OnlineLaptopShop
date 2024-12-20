<?php
session_start();
include '../../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../views/loginPAGE.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user orders
$sql = "SELECT ao.*, p.name as product_name, o.status, o.payment_option, o.carrier, o.total_amount 
        FROM allorder ao
        JOIN orders o ON ao.order_id = o.order_id
        JOIN products p ON ao.product_id = p.product_id
        WHERE ao.user_id = ?
        ORDER BY ao.all_order_id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/adminViewORDERS.css">
    <link rel="stylesheet" href="../../assets/css/orderHISTORY.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include 'userHEADER.php'; ?>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>
        <!-- Return Modal -->
        <?php include 'productReturnModal.php'; ?>
        <div class="main-content">
            <div class="container-fluid mt-4">
                <h2 class="text-center mb-4">Order History</h2>
                <div class="mb-1 d-flex justify-content-center">
                    <div class="d-flex justify-content-start w-100">
                        <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#returnModal">
                            Return Product
                        </button>
                    </div>
                    <input type="text" id="searchInput" class="form-control w-50" placeholder="Search orders...">
                </div>
                <div class="table-responsive">
                    <?php if (count($orders) > 0): ?>
                        <table class="table table-striped table-hover table-bordered" id="orderTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Payment Method</th>
                                    <th>Carrier</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                        <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                                        <td><?php echo htmlspecialchars($order['price']); ?></td>
                                        <td><?php echo htmlspecialchars($order['total_amount']); ?></td>
                                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                                        <td><?php echo htmlspecialchars($order['payment_option']); ?></td>
                                        <td><?php echo htmlspecialchars($order['carrier']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No orders found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#orderTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

</body>
</html>
<script src="../../assets/js/productReturn.js"></script>