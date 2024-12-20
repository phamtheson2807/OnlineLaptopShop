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
    <title>Laptop Shop - Welcome <?php echo $_SESSION['username']; ?></title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/userVIEW.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
    <?php include 'buyMODAL.php'; ?>

    <!-- Laptop Detail Modal -->
    <?php include 'laptopDetailModal.php'; ?>
    <!-- Sort and Filter Modal -->
    <?php include 'sortFilterModal.php'; ?>

    <div class="wrapper">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <!--  Header -->
            <?php include 'userHEADER.php'; ?>
            <!-- Main Content -->
            <div class="content p-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4>Available Laptops</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-end flex-wrap" style="gap: 10px">
                                    <input type="text" id="searchInput" class="form-control search-bar" placeholder="Search laptops...">
                                    <!-- Button to trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sortFilterModal">
                                        Sort & Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="laptop-container" class="row g-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/bootstrap.js"></script>
    <script src="https://kit.fontawesome.com/your-code.js"></script>
    <script src="../../assets/js/displayLAPTOPS.js"></script>
    <script src="../../assets/js/userSidebar.js"></script>

</body>
</html>