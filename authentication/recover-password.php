<?php
require_once '../database/config.php';

$errors = []; // Initialize the errors array

$id = $_REQUEST['id']; // Use $_POST instead of $_REQUEST for better security

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
      header("Location: login.php");
      exit(); // Add exit after header redirection to prevent further code execution
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Recover Password</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <b>Recover Password</b>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">You are only one step away from your new password, recover your password now.</p>

        <!-- Display errors -->
        <?php if (!empty($errors)) : ?>
          <div class="alert alert-danger">
            <?php foreach ($errors as $error) : ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form action="" method="post"> <!-- Keep action empty to submit to the same page -->
          <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"> <!-- Hidden field for user ID -->
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" name="save" class="btn btn-primary btn-block">Change password</button>
            </div>
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="login.php">Login</a>
        </p>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../assets/js/adminlte.min.js"></script>
</body>

</html>