<?php
session_start();
include("../Database/connect.php"); // Your database connection

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user= $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT ccam_id, password, role FROM ccam_user WHERE username = ?");
  $stmt->bind_param("s", $user);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $hashed_password, $role);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
      $_SESSION['ccam_id'] = $id;
      $_SESSION['role'] = $role;

      if ($role === 'admin') {
        header("Location: ../Admin/admin.php");
      } else {
        header("Location: ../Main/Dashboard.php");
      }

    } else {
      $error = "Incorrect password.";
    }
  } else {
    $error = "No such user found.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - CCAM</title>
  <link rel="icon" href="../Photos/LOGO.png" type="image">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="loginstyle.css">
</head>
<body>

<div class="login-box">
  <div class="logo mb-3">
    <a href="../Landing/landing.php"><img src="../Photos/LOGO.png" alt="CCAM Logo"><a>
  </div>

  <h2 class="mb-4">Welcome Back!</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form id="loginForm" action="login.php" method="POST" novalidate>
    <div class="mb-3 text-start">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" name="username" required>
      <div class="invalid-feedback">Please enter your email or ID.</div>
    </div>

    <div class="mb-4 text-start">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" required>
      <div class="invalid-feedback">Please enter your password.</div>
    </div>

    <button type="submit" class="btn btn-login w-100" name="login">LOG IN</button>
  </form>

  <div class="register-link mt-3">
    New to CCAM? <a href="../Signup/signup.php">Register here</a>
  </div>
</div>

<script src="login.js"></script>
</body>
</html>