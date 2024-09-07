<?php

require_once 'database/config.php';
session_start();

// Redirect to login page if the user is not authenticated
// if (!isset($_SESSION['id'])) {
//     header("Location: login.php");
//     exit;
// }

$id = $_SESSION['id'];

// Retrieve user details from the database
if ($id) {
    $sqlSelect = $conn->prepare("SELECT * FROM tbluser WHERE id = ?");
    $sqlSelect->bind_param("i", $id);
    $sqlSelect->execute();
    $res = $sqlSelect->get_result();
    $data = $res->fetch_assoc();

    $image = $data['image'];
    $fname = $data['fname'];
} else {
    $image = "avatar.png";
    $fname = "User";
}

if(isset($_REQUEST['pid'])){
    $pid = $_REQUEST['pid'];

    $query = "DELETE FROM tblcart WHERE id = '$pid' ";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location: cart.php');
    }

}

$selectCartProduct = $conn->prepare("SELECT * FROM tblcart WHERE uid = ?");
$selectCartProduct->bind_param("i", $id);
$selectCartProduct->execute();
$allProduct = $selectCartProduct->get_result();

if ($id) {
    // Retrieve the total number of products in the cart
    $sqlSelectCart = $conn->prepare("SELECT COUNT(*) as total FROM tblcart WHERE uid = ?");
    $sqlSelectCart->bind_param("i", $id);
    $sqlSelectCart->execute();
    $res = $sqlSelectCart->get_result();
    $dataCart = $res->fetch_assoc();

    $totalProductsInCart = $dataCart['total'];
} else {
    $totalProductsInCart = 0;
}

$title = "Cart";

?>
<?php include_once "includes/body.php"; ?>

<section class="h-100 h-custom" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card">
                    <div class="card-body p-4">

                        <div class="row">

                            <div class="col-lg-7">
                                <h5 class="mb-3"><a href="index.php" class="text-body"><i
                                            class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping</a></h5>
                                <hr>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <p class="mb-1">Shopping cart</p>
                                        <p class="mb-0">You have <?php echo $totalProductsInCart ?> items in your cart</p>
                                    </div>
                                    <div>
                                        <p class="mb-0"><span class="text-muted">Sort by:</span> <a href="#!"
                                                class="text-body">price <i class="fas fa-angle-down mt-1"></i></a></p>
                                    </div>
                                </div>

                                <?php
                                while ($row = $allProduct->fetch_assoc()) {
                                    $PID = $row['pid'];
                                    $sqlCountProductCart = $conn->prepare("SELECT COUNT(*) as total FROM tblcart WHERE pid = ?");
                                    $sqlCountProductCart->bind_param("i", $PID);
                                    $sqlCountProductCart->execute();
                                    $res = $sqlCountProductCart->get_result();
                                    $dataCountProductCart = $res->fetch_assoc();
                                    $totalCountProductsInCart = $dataCountProductCart['total'];
                                ?>


                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex flex-row align-items-center">
                                                    <div>
                                                        <img
                                                            src="assets/img/productimage/<?php echo $row['image']; ?>"
                                                            class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5><?php echo $row['name'] ?></h5>
                                                        <p class="small mb-0"><?php echo $row['size']; ?></p>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <div style="width: 50px;">
                                                        <h5 class="fw-normal mb-0"><?php echo $totalCountProductsInCart; ?></h5>
                                                    </div>
                                                    <div style="width: 90px;">
                                                        <h5 class="mb-0">Rs.<?php echo $row['newprice']; ?></h5>
                                                    </div>
                                                    <a href="cart.php?pid=<?php echo $row['id'];?>" style="color: #cecece;"><i class="fas fa-trash-alt"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                            </div>
                            <div class="col-lg-5">

                                <div class="card bg-primary text-white rounded-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h5 class="mb-0">Card details</h5>
                                            <img src="assets/img/userimage/<?php echo $image; ?>"
                                                class="img-fluid rounded-3" style="width: 45px;" alt="Avatar">
                                        </div>

                                        <p class="small mb-2">Card type</p>
                                        <a href="#!" type="submit" class="text-white"><i
                                                class="fab fa-cc-mastercard fa-2x me-2"></i></a>
                                        <a href="#!" type="submit" class="text-white"><i
                                                class="fab fa-cc-visa fa-2x me-2"></i></a>
                                        <a href="#!" type="submit" class="text-white"><i
                                                class="fab fa-cc-amex fa-2x me-2"></i></a>
                                        <a href="#!" type="submit" class="text-white"><i class="fab fa-cc-paypal fa-2x"></i></a>

                                        <form class="mt-4">
                                            <div data-mdb-input-init class="form-outline form-white mb-4">
                                                <input type="text" id="typeName" class="form-control form-control-lg" siez="17"
                                                    placeholder="Cardholder's Name" />
                                                <label class="form-label" for="typeName">Cardholder's Name</label>
                                            </div>

                                            <div data-mdb-input-init class="form-outline form-white mb-4">
                                                <input type="text" id="typeText" class="form-control form-control-lg" siez="17"
                                                    placeholder="1234 5678 9012 3457" minlength="19" maxlength="19" />
                                                <label class="form-label" for="typeText">Card Number</label>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <div data-mdb-input-init class="form-outline form-white">
                                                        <input type="text" id="typeExp" class="form-control form-control-lg"
                                                            placeholder="MM/YYYY" size="7" id="exp" minlength="7" maxlength="7" />
                                                        <label class="form-label" for="typeExp">Expiration</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div data-mdb-input-init class="form-outline form-white">
                                                        <input type="password" id="typeText" class="form-control form-control-lg"
                                                            placeholder="&#9679;&#9679;&#9679;" size="1" minlength="3" maxlength="3" />
                                                        <label class="form-label" for="typeText">Cvv</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between">
                                            <p class="mb-2">Subtotal</p>
                                            <p class="mb-2">Rs. 300000</p>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <p class="mb-2">Shipping</p>
                                            <p class="mb-2">Rs. 00</p>
                                        </div>

                                        <div class="d-flex justify-content-between mb-4">
                                            <p class="mb-2">Total(Incl. taxes)</p>
                                            <p class="mb-2">Rs. 300000</p>
                                        </div>

                                        <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-block btn-lg">
                                            <div class="d-flex justify-content-between">
                                                <span>Rs. 300000</span>
                                                <span>Checkout <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                                            </div>
                                        </button>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once "includes/footer.php"; ?>