<?php
include 'header.php';
require_once '../classes/Smartphone.php';
require_once '../classes/User.php';

// Creating a session if one is not already started.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirecting to login page if user is not already logged in.
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Loading all users from JSON file, Converting users to objects.
$usersData = json_decode(file_get_contents('../data/users.json'), true);
$users = [];

foreach ($usersData as $userData) {
    $users[] = new User($userData);
}

// Loading all smartphones from JSON file, Converting smartphones to objects.
$smartphoneData = json_decode(file_get_contents('../data/smartphones.json'), true);
$smartphones = [];

foreach($smartphoneData as $phoneData) {
    $smartphones[] = new Smartphone($phoneData);
}

// Finding the details of the user currently logged in. 
$currentUser = null;
foreach ($users as $user) {
    if ($user->getUsername() === $_SESSION['username']) {
        $currentUser = $user;
        break;
    }
}
?>


<div class="container mt-4">
  <h1>My Account</h1>

  <?php if ($currentUser): ?>
    <div class="row">
      <!-- User information box -->
      <div class="col-md-6 col-lg-5 mb-4">
        <div class="p-4 bg-white rounded shadow-sm border h-100">
          <p><strong>Username:</strong> <?= htmlspecialchars($currentUser->getUsername()) ?></p>
          <p><strong>First Name:</strong> <?= htmlspecialchars($currentUser->getFirstName()) ?></p>
          <p><strong>Surname:</strong> <?= htmlspecialchars($currentUser->getSurname()) ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($currentUser->getEmail()) ?></p>
        </div>
      </div>

      <!-- Favourite Smartphone Box -->
      <div class="col-md-6 col-lg-5 mb-4">
        <div class="p-4 bg-white rounded shadow-sm border h-100">
          <h5 class="fw-semibold mb-3">Select Favourite Smartphone</h5>
          <form method="POST" action="update_account.php">
            <div class="mb-3">
              <label for="favourite" class="form-label">Favourite Smartphone</label>
              <select name="favourite" id="favourite" class="form-select" required>
                <option value="">-- Select a Smartphone --</option>
                <?php foreach ($smartphones as $phone): ?>
                  <option value="<?= htmlspecialchars($phone->getID()) ?>"
                    <?= $currentUser->getFavourite() == $phone->getID() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($phone->getModel()) ?> (<?= htmlspecialchars($phone->getManufacturer()) ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Favourite</button>
          </form>
        </div>
      </div>
    </div>
  <?php else: ?>
    <!-- Error if user is not found -->
    <div class="alert alert-danger">User not found.</div>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
