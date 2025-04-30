<?php
include '../content/header.php';
require_once '../classes/User.php';

// Creating a session if one is not already started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$errors = []; //Array used to store error messages.
$userFound = False; //Tracks whether login is successful.

// When form is submitted by user.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Loading users from JSON file for comparision, Creating user objects.
    $usersData = json_decode(file_get_contents('../data/users.json'), true);
    $users = [];
    
    foreach ($usersData as $userData) {
        $users[] = new User($userData);
    }

    // If username and password matches a record in JSON file, redirects user to index page. 
    foreach ($users as $user) {
        if ($user->getUsername() === $username && password_verify($password, $user->getPassword())) {
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['firstName'] = $user->getFirstName();
            $userFound = true;
            header("Location: index.php");
            exit;
        }
    }
    
    // If username and/or password dont match a record, stores an error message in $errors array.
    if (!$userFound) {
        $errors[] = "Invalid username or password.";
    }
}
?>

<!-- Checks if errors array isnt empty and returns any contents. -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Form for entering login details -->
<form method ="POST" class="mb-4">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" required>
    </div>
    <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name ="password" id="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>


<?php include '../content/footer.php'; ?>