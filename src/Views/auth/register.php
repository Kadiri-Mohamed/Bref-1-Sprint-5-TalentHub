<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<h1>Create an account</h1>

<?php if (!empty($error)): ?>
    <p style="color: red;">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<form method="POST" action="?page=register">
    <!-- (Optionnel) CSRF token -->
    <?php if (isset($_SESSION['csrf_token'])): ?>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    <?php endif; ?>

    <div>
        <label for="name">Full name</label><br>
        <input
            type="text"
            id="name"
            name="name"
            required
            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
    </div>

    <br>

    <div>
        <label for="email">Email address</label><br>
        <input
            type="email"
            id="email"
            name="email"
            required
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    </div>

    <br>

    <div>
        <label for="password">Password</label><br>
        <input
            type="password"
            id="password"
            name="password"
            required>
    </div>

    <br>

    <div>
        <label for="role">Select role</label><br>
        <select id="role" name="role" required>
            <option value="">-- Choose a role --</option>
            <option value="candidate"
                <?= (($_POST['role'] ?? '') === 'candidate') ? 'selected' : '' ?>>
                Candidate
            </option>
            <option value="recruiter"
                <?= (($_POST['role'] ?? '') === 'recruiter') ? 'selected' : '' ?>>
                Recruiter
            </option>
        </select>
    </div>

    <br>

    <button type="submit">Register</button>
</form>

<p>
    Already have an account?
    <a href="/login">Login here</a>
</p>

</body>
</html>
