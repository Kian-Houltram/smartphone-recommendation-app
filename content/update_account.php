<?php
// Creates a session if one is not already started.
session_start();
require_once '../classes/User.php';

// Redirects the user to login page if not logged in. 
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$usersFile = '../data/users.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['favourite'])) {
    $usersData = json_decode(file_get_contents($usersFile), true);
    $users = [];

    // Converts each user record into a user object
    foreach ($usersData as $userData) {
        $users[] = new User($userData);
    }

    $favourite = $_POST['favourite'];

    // Finds the logged in user and updates favourite smartphone.
    foreach ($users as $user) {
        if ($user->getUsername() === $_SESSION['username']) {
            $user->setFavourite($favourite);
            break;
        }
    }

    // Converts user objects back to arrays and saves to file. 
    $userArrayData = array_map(fn($user) => $user->toArray(), $users);

    file_put_contents($usersFile, json_encode($userArrayData, JSON_PRETTY_PRINT));

    // Redirects user to the account page after update.
    header("Location: account.php");
    exit;
}
