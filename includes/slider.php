<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="assets/img/logo.jpeg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Computer Store</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- User panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="assets/img/userimage/<?php echo $image; ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $fname; ?></a>
            </div>
        </div>
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <a href="authentication/login.php" class="btn btn-primary">Login</a>
                </div>
            </div> -->

        <!-- Navigation -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="index.php" class="nav-link <?php echo $title == 'Dashboard' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <?php if ($id) { ?>
                    <li class="nav-item">
                        <a href="feedback.php" class="nav-link <?php echo $title == 'Feedback' ? 'active' : ''; ?>">
                            <i class="nav-icon fab fa-facebook-messenger"></i>
                            <p>Feedback</p>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>