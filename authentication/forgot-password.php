<?php

require_once '../database/config.php';

$errors = array();

if (isset($_POST['button'])) {
  $email = $_POST['email'];

  if (empty($email)) {
    $errors['email'] = "Please enter email";
  }

  if (empty($errors)) {
    $sqlSelect = $conn->prepare("SELECT * FROM tbluser WHERE email = '$email'");
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();
    $user = $result->fetch_assoc();
    $id = $user['id'];

    if ($result) {
      header("Location: ../authentication/recover-password.php?id=$id");
      exit();
    } else {
      $errors['email'] = "Please enter registered email";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>

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
      <a href="../../index2.html"><b>Forgot Password</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

        <form method="post">
          <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger">
              <?php foreach ($errors as $error) : ?>
                <p><?php echo $error; ?></p>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="Enter your Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" name="button" class="btn btn-primary btn-block">Request new password</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="login.php">Login</a>
        </p>
        <p class="mb-0">
          <a href="register.php" class="text-center">Register a new membership</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>