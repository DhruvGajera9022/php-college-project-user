<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search here" aria-label="Recipient's username" aria-describedby="basic-addon2" name="search" id="search">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button">Search</button>
                </div>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" href="cart.php">
                <i class="fa fa-shopping-cart"></i>
                <span class="badge badge-danger navbar-badge"><?php echo $totalProductsInCart; ?></span>
            </a>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>

        <!-- Menu Dropdown -->
        <?php if ($id) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown">
                    <i class="fas fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="profile.php" class="dropdown-item">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" id="passwordChange" data-toggle="modal" data-target="#modal-default">
                        <i class="fas fa-key mr-2"></i> Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="authentication/logout.php" class="dropdown-item">
                        <i class='fas fa-sign-out-alt'></i> Logout
                    </a>
                </div>
            </li>
        <?php } else { ?>
            <a href="profile.php" class="btn btn-primary">Login</a>
        <?php } ?>
    </ul>
</nav>


<!-- Change Password Dialog -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="dashboard.php" method="post" id="formPassword">
                <div class="modal-body" style="display: flex; flex-direction: column; gap: 5px;">
                    <label for="password">Password: </label>
                    <input type="password" placeholder="Enter password" name="password" id="password">
                    <label for="cpassword">Confirm Password: </label>
                    <input type="text" placeholder="Enter confirm password" name="cpassword" id="cpassword">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Change" name="save" />
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>