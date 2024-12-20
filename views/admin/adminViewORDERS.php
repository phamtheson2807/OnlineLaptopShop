<!-- views/admin/adminViewORDERS.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Admin</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/adminVIEW.css">
    <link rel="stylesheet" href="../../assets/css/adminViewORDERS.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <!-- Include Sidebar here -->
        <?php include 'adminSIDEBAR.php'; ?>

        <?php include 'messageUserModal.php'; ?>
        <div class="main-content">
            <!-- Include Header here -->
            <?php include 'adminHEADER.php'; ?>
            
            <div class="container-fluid mt-0">
                <h2>All Orders</h2>
                <div class="controls-wrapper">
                    <div class="export-container">
                        <button id="exportPdfBtn" class="btn btn-danger">Export PDF</button>
                    </div>
                    <div class="search-filter-container">
                        <select id="statusFilter" class="form-select">
                            <option value="">All Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Out for Delivery">Out for Delivery</option>
                            <option value="Complete">Complete</option>
                            <option value="For Returned">For Returned</option>
                            <option value="Canceled">Canceled</option>
                            <option value="Return Complete">Return Complete</option>
                        </select>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search orders...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th> <!-- Select All Checkbox -->
                                <th>Location</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Amount</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Carrier</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody id="ordersTableBody">
                        </tbody>
                    </table>
                </div>
                
                <!-- Total Sum Section -->
                <div class="d-flex justify-content-end mt-3" style="gap: 8px;">
                    <div class="card bg-light border-primary" style="min-width: 200px;">
                        <div class="card-body py-2">
                            <div class="d-flex align-items-center" style="gap: 10px;">
                                <i class="fas fa-shopping-cart text-primary me-2 fa-lg"></i>
                                <div>
                                    <h6 class="card-title mb-0">Selected Item Total</h6>
                                    <p class="card-text h5 mb-0">₱<span id="SelectedItemTotal">0.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-light border-success" style="min-width: 200px;">
                        <div class="card-body py-2">
                            <div class="d-flex align-items-center" style="gap: 10px;">
                                <i class="fas fa-check-circle text-success me-2 fa-lg"></i>
                                <div>
                                    <h6 class="card-title mb-0">Amount Completed</h6>
                                    <p class="card-text h5 mb-0">₱<span id="totalSumCompleted">0.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-light border-danger" style="min-width: 200px;">
                        <div class="card-body py-2">
                            <div class="d-flex align-items-center" style="gap: 10px;">
                                <i class="fas fa-coins text-danger me-2 fa-lg"></i>
                                <div>
                                    <h6 class="card-title mb-0">Total Amount</h6>
                                    <p class="card-text h5 mb-0">₱<span id="totalSum">0.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
<script src="../../assets/js/jquery.js"></script>
<script src="../../assets/js/bootstrap.js"></script>
<script src="../../assets/js/adminViewORDERS.js"></script></div>