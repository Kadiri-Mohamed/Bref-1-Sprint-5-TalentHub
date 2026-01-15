<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

<?php if (!empty($error)): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>
<a href="/register"> already have an account</a>
</body>
</html>

<?php
use App\Core\Session;

// $userRole = $_SESSION['role_id'];
$userRole = Session::get('role_id');
echo $userRole;