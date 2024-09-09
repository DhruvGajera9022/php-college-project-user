<?php

include_once('userdata.php');

// Fetch all products from the tblmaster table
$query = "SELECT * FROM tblmaster";
$allProduct = $conn->query($query);

$errors = [];

if (isset($_POST['Submit'])) {
    $feedback = $_POST['feedback'];

    if (empty($feedback)) {
        $error = "Feedback must be required";
    }

    if (empty($error)) {
        $stmt = $conn->prepare("INSERT INTO tblfeedback (email, feedback) VALUES (?, ?)");
        if (!$stmt) {
            $error['db_error'] = "Database error: " . $conn->error;
        } else {
            $stmt->bind_param("ss", $email, $feedback);
            if ($stmt->execute()) {
                header("Location: index.php");
                exit;
            } else {
                $error['db_error'] = "Database error: Failed to register";
            }
            $stmt->close();
        }
    }
}


$title = "Feedback";
$active = "active";

?>

<?php include_once 'includes/body.php'; ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Feedback</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Feedback</h3>
                                </div>
                                <!-- /.card-header -->

                                <!-- form start -->
                                <form method="post" id="formAddRole">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="fullname">User Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?php echo $email; ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="feedback">Feedback <span class="text-danger">*</span></label>
                                            <textarea name="feedback" class="form-control" id="feedback" placeholder="Enter Feedback"></textarea>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>

                                <?php if (isset($error['db_error'])): ?>
                                    <div class="alert alert-danger mt-2"><?php echo $error['db_error']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_once 'includes/footer.php'; ?>