<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $password==$user['password']) {
        $user['roles'] = $user['role'];
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
    <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/dashboard.css"> <!-- Using existing dashboard.css -->

  <!-- JS -->
  <script src="js/main.js"></script>
  <script src="js/form-validation.js"></script>
  <script src="js/dashboard.js"></script>
</head>
<body>
<div class="container">
  <h1>📦 Login</h1>
  <?php if (isset($error)) : ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <form method="post" class="login-form">
    <div class="form-group">
      <label>Username</label>
      <input type="text" name="username" required />
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" required />
    </div>
    <div class="form-group">
      <input type="submit" value="Login" class="btn primary" />
    </div>
  </form>
  <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
