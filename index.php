<?php

include_once('userdata.php');

// Fetch all products from the tblmaster table
$query = "SELECT * FROM tblmaster";
$allProduct = $conn->query($query);

$errors = [];

// Handle password update
if (isset($_POST['save'])) {
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if (empty($password)) {
        $errors['password'] = "Enter Password";
    }

    if (empty($cpassword)) {
        $errors['cpassword'] = "Enter Confirm Password";
    }

    if ($password !== $cpassword) {
        $errors['compare'] = "Password and Confirm Password should be the same";
    }

    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sqlUpdate = $conn->prepare("UPDATE tbluser SET password = ? WHERE id = ?");
        $sqlUpdate->bind_param("si", $passwordHash, $id);
        if ($sqlUpdate->execute()) {
            echo "Password updated successfully!";
        } else {
            echo "Error updating password!";
        }
    } else {
        foreach ($errors as $error) {
            echo "<div class='error'>$error</div>";
        }
    }
}

// Handle adding product to cart
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    $sqlSelect = $conn->prepare("SELECT * FROM tblmaster WHERE id = ?");
    $sqlSelect->bind_param("i", $pid);
    $sqlSelect->execute();
    $res = $sqlSelect->get_result();
    $dataForCart = $res->fetch_assoc();

    $productId = $dataForCart['id'];
    $pname = $dataForCart['name'];
    $pdescription = $dataForCart['description'];
    $pslug = $dataForCart['slug'];
    $pcategory = $dataForCart['category'];
    $psize = $dataForCart['size'];
    $pcolor = $dataForCart['color'];
    $pweight = $dataForCart['weight'];
    $poldprice = $dataForCart['oldprice'];
    $pnewprice = $dataForCart['newprice'];
    $pimages = $dataForCart['images'];

    if (isset($_GET['addToCart'])) {
        $stmt = $conn->prepare("INSERT INTO tblcart (name, description, slug, category, size, color, weight, oldprice, newprice, image, uid, pid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $pname, $pdescription, $pslug, $pcategory, $psize, $pcolor, $pweight, $poldprice, $pnewprice, $pimages, $id, $productId);
        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        }
        $stmt->close();
    }
}

if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
    $searchTerm = "%" . $searchTerm . "%";

    // Query to search products by name
    $stmt = $conn->prepare("SELECT * FROM tblmaster WHERE name LIKE ?");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
}


$title = "Dashboard";
$active = "active";

?>

<?php include_once 'includes/body.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <main>
        <?php
        while ($row = mysqli_fetch_assoc($allProduct)) {
        ?>
            <div class="card product-card">
                <div class="image image-class">
                    <a href="productPage.php?id=<?php echo $row['id']; ?>">
                        <img src="assets/img/productimage/<?php echo $row['images']; ?>" alt="">
                    </a>
                </div>
                <div class="caption">
                    <a href="productPage.php?id=<?php echo $row['id']; ?>">
                        <p class="rate">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </p>
                        <p class="product_name" style="color: black;"><?php echo $row["name"]; ?></p>
                        <div class="price-container">
                            <p class="price">Rs. <?php echo $row["newprice"]; ?></p>
                            <p class="discount">Rs. <?php echo $row["oldprice"]; ?></p>
                        </div>
                    </a>
                </div>

                <a class="btn btn-primary swalDefaultSuccess" href="index.php?pid=<?php echo $row['id']; ?>&addToCart=true" id="btnAddToCart" style="margin: 10px;">Add to cart</a>

            </div>
        <?php
        }
        ?>
    </main>

</div>

<?php include_once 'includes/footer.php'; ?>