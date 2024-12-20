<link rel="stylesheet" href="../../assets/css/adminSIDEBAR.css">
<nav class="sidebar">
    <h3 class="mb-4">Admin Dashboard</h3>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="adminVIEW.php">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="adminMESSAGES.php">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-envelope"></i> Messages
                    </div>
                    <div class="admin-message-badge" style="
                        width: 8px;
                        height: 8px;
                        position: absolute;
                        right: 15px;
                        top: 50%;
                        transform: translateY(-50%);
                        display: none;
                        background-color: #dc3545;
                        border-radius: 50%;
                        border: 2px solid #dc3545;
                        z-index: 1000;
                    "></div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="adminViewORDERS.php">
                <i class="fas fa-box"></i> Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="returnOrders.php">
            <i class="fas fa-undo"></i> Return Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutConfirmModal">
            <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</nav>

<style>
.admin-message-badge {
    width: 8px;
    height: 8px;
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    display: none;
    background-color: #dc3545;
    border-radius: 50%;
    border: 2px solid #fff;
}
</style>
<script src="../../assets/js/jquery.js"></script>
<script src="../../assets/js/bootstrap.js"></script>
<script src="../../assets/js/adminSidebar.js"></script>