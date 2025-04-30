<?php
include '../content/header.php';
require_once '../classes/User.php';

// Creating a session if one is not already started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$errors = []; // Creating an array to store error messages.
$success = false; // Used to track success of registration.

$usersFile = '../data/users.json';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Getting the form data.
    $username = trim($_POST['username']);
    $firstName = trim($_POST['firstName']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Checks if any required fields are left empty.
    if (empty($username) || empty($firstName) || empty($surname) || empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    // Loading the user JSON file, Converting users to objects.
    $usersData = json_decode(file_get_contents('../data/users.json'), true);
    $users = [];
    
    foreach ($usersData as $userData) {
        $users[] = new User($userData);
    }

    // Checks if the username already exists in the file.
    foreach ($users as $user) {
        if ($user->getUsername() === $username) {
            $errors[] = "Username already exists.";
            break;
        }
    }

    // Creates a new user record if there are no errors. 
    if (empty($errors)) {
        $newUser = new User([
            'username' => $username,
            'firstName' => $firstName,
            'surname' => $surname,
            'email' => $email,
            'password' => $password,
            'favourite' => null
        ]);
    
        $users[] = $newUser;
    
        // Converts user objects to arrays before saving.
        $userArrayData = array_map(fn($user) => $user->toArray(), $users);
    
        file_put_contents($usersFile, json_encode($userArrayData, JSON_PRETTY_PRINT));
        $success = true;
    }
}
?>

<h1>Registration</h1>

<!-- Creating a success message if registration works. -->
<?php if ($success): ?>
    <div class="alert alert-success">Registration Successful! <a href="login.php">Login Here</a>.</div>
<?php endif; ?>

<!-- Returns error messages if any have been added to the array. -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Form for registration -->
<form method="POST" class="mb-4">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="firstName" class="form-label">First Name</label>
        <input type="text" name="firstName" id="firstName" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="surname" class="form-label">Surname</label>
        <input type="text" name="surname" id="surname" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" name="email" id="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
</form>

<?php include '../content/footer.php'; ?>