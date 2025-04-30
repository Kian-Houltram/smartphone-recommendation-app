<?php
include '../content/header.php';
require_once '../classes/Smartphone.php';
require_once '../classes/Review.php';

// Creating a session if one is not already started.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Loading smartphones JSON file, Converts smartphones to objects.
$smartphoneData = json_decode(file_get_contents('../data/smartphones.json'), true);
$smartphones = [];

foreach ($smartphoneData as $phoneData) {
    $smartphones[] = new Smartphone($phoneData);
}


// Gets the smartphone ID.
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Finds the smartphone with the ID
$selectedPhone = null;
foreach ($smartphones as $phone) {
    if ($phone->getID() == $id) {
        $selectedPhone = $phone;
        break;
    }
}

// Sets up pagination for reviews, limitting to 3 reviews per pageS
$reviewsPerPage = 3;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$startIndex = ($page - 1) * $reviewsPerPage;

?>

<?php 

// Loading review JSON file, Converting reviews to objects.
$reviewData = json_decode(file_get_contents('../data/reviews.json'), true);
$reviews = [];

$reviewsFile = '../data/reviews.json';

foreach ($reviewData as $reviewEntry) {
    $reviews[] = new Review($reviewEntry);
}

// Creates a new review if the form is submitted and the user is logged in.
if ($selectedPhone):
    if (isset($_POST['submit_review']) && isset($_SESSION['username'])) {
        $newReview = new Review ([
            'username' => $_SESSION['username'],
            'rating' => (int) $_POST['rating'],
            'comment' => trim($_POST['comment']),
            'phone_id' => $selectedPhone->getID()
        ]);

        $reviews[] = $newReview;

        // Saves updated reviews to file.
        $reviewArrayData = array_map(fn($r) => $r->toArray(), $reviews);
        
        file_put_contents($reviewsFile, json_encode($reviewArrayData, JSON_PRETTY_PRINT));
        
    }

        ?>
    <h1 class="mb-4"><?= htmlspecialchars($selectedPhone->getModel()) ?></h1>

    <div class="row">
        <div class="col-md-5">
            <img src="../images/<?= htmlspecialchars($selectedPhone->getImage()) ?>" class="img-fluid" alt="<?= htmlspecialchars($selectedPhone->getModel()) ?>">
        </div>
        <div class="col-md-7">
            <ul class="list-group mb-3">
                <li class="list-group-item"><strong>Manufacturer:</strong> <?=htmlspecialchars($selectedPhone->getManufacturer()) ?></li>
                <li class="list-group-item"><strong>Screen Size:</strong> <?=htmlspecialchars($selectedPhone->getScreenSize()) ?></li>
                <li class="list-group-item"><strong>Dimensions:</strong> <?=htmlspecialchars($selectedPhone->getDimensions()) ?></li>
                <li class="list-group-item"><strong>Weight:</strong> <?=htmlspecialchars($selectedPhone->getWeight()) ?></li>
                <li class="list-group-item"><strong>Release Date:</strong> <?=htmlspecialchars($selectedPhone->getReleaseDate()) ?></li>
                <li class="list-group-item"><strong>OS:</strong> <?=htmlspecialchars($selectedPhone->getOS()) ?></li>
                <li class="list-group-item"><strong>Score:</strong> <?=htmlspecialchars($selectedPhone->getScore()) ?></li>
            </ul>

            <p><strong>Our Recommendation:</strong></p>
            <p><?= htmlspecialchars($selectedPhone->getDescription()) ?></p>

            <a href="index.php" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>


<?php else: ?>
    <div class="alert alert-danger">
        Smartphone Not Found. <a href="index.php">Go back</a>
    </div>
<?php endif; ?>

<?php if(isset($_SESSION['username'])): ?>
    <hr>
    <h3>Create a Review</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (0-10)</label>
            <input type="number" name="rating" id="rating" class="form-control" min="0" max="10" required>
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" name="submit_review" class="btn btn-primary">Submit Review</button>
    </form>
<?php endif; ?>

<hr>
<h3>Reviews</h3>
<?php
$reviewsForPhones = array_filter($reviews, function($review) use($selectedPhone) {
    return $review->getPhoneID() == $selectedPhone->getID();
});

// Shows the newest reviews first.
$reviewsForPhones = array_reverse($reviewsForPhones);

// Slices for pagination.
$totalReviews = count($reviewsForPhones);
$paginatedReviews = array_slice($reviewsForPhones, $startIndex, $reviewsPerPage);
$totalPages = ceil($totalReviews / $reviewsPerPage);

if (count($reviewsForPhones) > 0):
    foreach ($paginatedReviews as $review):?>
    <div class="border rounded p-3 mb-3 bg-light">
        <strong><?= htmlspecialchars($review->getUsername()) ?></strong>
        <span class="text-muted">rated <?= $review->getRating() ?>/10</span><br>
        <p><?= htmlspecialchars($review->getComment()) ?></p>
    </div>
<?php endforeach; ?>
<?php else: ?>
    <p>No reviews yet. Be the first to review!</p>
<?php endif; ?>

<?php if ($totalPages > 1): ?>
    <nav aria-label="Review pagination">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?id=<?= urlencode($selectedPhone->getID()) ?>&page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>


<?php include '../content/footer.php';?>

