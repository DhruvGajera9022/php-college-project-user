<?php

require_once 'database/config.php';
session_start();

// Redirect to login page if the user is not authenticated
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id'];

// Retrieve user details from the database
$sqlSelect = $conn->prepare("SELECT * FROM tbluser WHERE id = ?");
$sqlSelect->bind_param("i", $id);
$sqlSelect->execute();
$res = $sqlSelect->get_result();
$data = $res->fetch_assoc();

$image = $data['image'] ?? "avatar.png";
$fname = $data['fname'] ?? "User";

$productId = $_GET['id'] ?? '';

if ($productId) {
    $stmt = $conn->prepare("SELECT * FROM tblmaster WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $dataProduct = $res->fetch_assoc();
    } else {
        // Handle case where the product is not found
        header("Location: 404.php");
        exit;
    }
    $stmt->close();
}

// Handle adding product to cart
// if (isset($_GET['pid']) && isset($_GET['addToCart'])) {
//     $pid = $_GET['pid'];
//     $sqlSelect = $conn->prepare("SELECT * FROM tblmaster WHERE id = ?");
//     $sqlSelect->bind_param("i", $pid);
//     $sqlSelect->execute();
//     $res = $sqlSelect->get_result();
//     $dataForCart = $res->fetch_assoc();

//     $pname = $dataForCart['name'];
//     $pdescription = $dataForCart['description'];
//     $pslug = $dataForCart['slug'];
//     $pcategory = $dataForCart['category'];
//     $psize = $dataForCart['size'];
//     $pcolor = $dataForCart['color'];
//     $pweight = $dataForCart['weight'];
//     $poldprice = $dataForCart['oldprice'];
//     $pnewprice = $dataForCart['newprice'];
//     $pimages = $dataForCart['images'];

//     $stmt = $conn->prepare("INSERT INTO tblcart (name, description, slug, category, size, color, weight, oldprice, newprice, image, uid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
//     $stmt->bind_param("sssssssssss", $pname, $pdescription, $pslug, $pcategory, $psize, $pcolor, $pweight, $poldprice, $pnewprice, $pimages, $id);
//     if ($stmt->execute()) {
//         // header("Location: productPage.php?id=" . htmlspecialchars($productId));
//         header("Location: index.php");
//         exit;
//     }
//     $stmt->close();
// }

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

$title = "Product";

?>

<?php include_once 'includes/body.php'; ?>

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="col-12">
                            <img src="assets/img/productimage/<?php echo htmlspecialchars($dataProduct['images'] ?? 'default.png'); ?>" class="product-image" alt="Product Image">
                        </div>
                        <div class="col-12 product-image-thumbs">
                            <?php
                            // Assuming $dataProduct['images'] contains a list of image filenames, separated by commas.
                            $images = explode(',', $dataProduct['images'] ?? '');
                            foreach ($images as $image) {
                                if (trim($image)) {
                                    echo '<div class="product-image-thumb"><img src="assets/img/productimage/' . htmlspecialchars(trim($image)) . '" alt="Product Image"></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h1 class="my-3"><?php echo htmlspecialchars($dataProduct['name'] ?? 'Product Name'); ?></h1>
                        <p><?php echo htmlspecialchars($dataProduct['description'] ?? 'Product Description'); ?></p>

                        <hr>

                        <div class="price-container">
                            <h4 class="price">Rs. <?php echo htmlspecialchars($dataProduct["newprice"] ?? '0'); ?></h4>
                        </div>

                        <div class="mt-4">
                            <a class="btn btn-outline-dark flex-shrink-0" href="index.php?pid=<?php echo $dataProduct['id']; ?>">
                                <i class="fas fa-cart-plus fa-lg mr-2 bi-cart-fill me-1"></i>
                                Add to Cart
                            </a>
                        </div>

                        <table class="table table-sm table-bordered my-3">
                            <colgroup>
                                <col width="50%">
                                <col width="50%">
                            </colgroup>
                            <thead>
                                <tr class="bg-dark">
                                    <th class="text-center">Field Name</th>
                                    <th class="text-center">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sections = [
                                    'Performance' => ['Processor' => 'processor', 'Clock Speed' => 'clock_speed', 'GPU' => 'gpu', 'RAM' => 'ram', 'RAM Slot' => 'ram_slot', 'SSD/HDD' => 'ssd_hdd', 'OS' => 'os'],
                                    'Display' => ['Display Size' => 'display_size', 'Display Type' => 'display_type', 'Touch Screen' => 'display_touch'],
                                    'Power and Battery' => ['Power Adapter' => 'power_adapter', 'Battery Capacity' => 'battery_capacity', 'Battery Hour' => 'battery_hour'],
                                    'Body' => ['Dimension' => 'dimension', 'Weight' => 'weight', 'Colors' => 'colors'],
                                    'IO and Ports' => ['IO Ports' => 'io_ports', 'Fingerprint Sensor' => 'fingerprint_sensor', 'Camera' => 'camera', 'Keyboard' => 'keyboard', 'Touchpad' => 'touchpad'],
                                    'Connectivity' => ['WIFI' => 'wifi', 'Bluetooth' => 'bluetooth'],
                                    'Audio' => ['Speaker' => 'speaker', 'Mic' => 'mic']
                                ];

                                foreach ($sections as $section => $fields) {
                                    echo "<tr><th colspan='2' class='text-center bg-secondary'>$section</th></tr>";
                                    foreach ($fields as $field => $dbField) {
                                        echo "<tr><th>$field</th><td>" . htmlspecialchars($dataProduct[$dbField] ?? "") . "</td></tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>

<?php include_once 'includes/footer.php'; ?>