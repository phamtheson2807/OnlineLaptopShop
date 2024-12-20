<link rel="stylesheet" href="../../assets/css/adminHEADER.css">
<header class="header">
    <div class="d-flex justify-content-between align-items-center">
        <div class="admin-info">
            <i class="fas fa-user-shield fa-2x"></i>
            <span>Admin Dashboard</span>
        </div>
        <!-- Add toggle button for mobile -->
        <button class="btn btn-dark d-md-none me-2" id="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutConfirmModal" tabindex="-1" role="dialog" aria-labelledby="logoutConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutConfirmModalLabel">Logout Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to logout?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="../../backend/logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>

<script src="../../assets/js/jquery.js"></script>
<script src="../../assets/js/bootstrap.js"></script>
<script src="https://kit.fontawesome.com/your-code.js"></script>
<script src="../../assets/js/userSidebar.js"></script>
<script>
    $(document).ready(function() {
        $('#confirmLogout').click(function() {
            window.location.href = '../../backend/logout.php';
        });
    });
</script>