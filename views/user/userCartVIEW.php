<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../loginPAGE.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart - <?php echo $_SESSION['username']; ?></title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/userCartVIEW.css">
    <link rel="stylesheet" href="../../assets/css/userHEADER.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <!-- Include Sidebar here -->
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <!-- Include Header here -->
            <?php include 'userHEADER.php'; ?>
            
            <div class="container">
                <h2 class="mb-4">Shopping Cart</h2>
                <div id="cart-items"></div>
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Total: ₱<span id="cart-total">0.00</span></h4>
                            <button class="btn btn-success" id="checkout-btn">Proceed to Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="cartPaymentModal" tabindex="-1" aria-labelledby="cartPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartPaymentModalLabel">Checkout Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add section to display selected items -->
                    <div id="cart-details">
                        <h6>Selected Items:</h6>
                        <div id="selected-items-list" class="mb-3">
                            <!-- Selected items will be dynamically inserted here -->
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="paymentOption">Payment Option</label>
                        <select class="form-control" id="paymentOption">
                            <option value="Meet Up">Meet Up</option>
                            <option value="Cash on Delivery">Cash on Delivery</option>
                            <option value="Cash on Pickup">Cash on Pickup</option>
                        </select>
                    </div>
                    <div class="form-group mt-3" id="carrier-group" style="display: none;">
                        <label for="carrier">Carrier</label>
                        <select class="form-control" id="carrier">
                            <option value="--">--</option>
                            <option value="LBC">LBC</option>
                            <option value="Lalamove">Lalamove</option>
                            <option value="J&T">J&T</option>
                            <option value="Ninja Express">Ninja Express</option>
                            <option value="Food Panda">Food Panda</option>
                            <option value="Private Driver">Private Driver</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <label for="totalAmount">Total Amount: ₱<span id="totalAmount">0.00</span></label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="proceedCartPayment">Proceed to Payment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/your-code.js"></script>
    <script src="../../assets/js/userCartVIEW.js"></script>
</body>
</html>