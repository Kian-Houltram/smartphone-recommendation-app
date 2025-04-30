<?php
include '../content/header.php';
require_once '../classes/Smartphone.php';

// Loading the smartphone data from the json file and converting into objects.
$smartphoneData = json_decode(file_get_contents('../data/smartphones.json'), true);
$smartphones = [];

foreach ($smartphoneData as $phoneData) {
    $smartphones[] = new Smartphone($phoneData);
}

$featuredPhones = $smartphones;
?>

<div class="container">
    <h1 class="mb-4">Welcome</h1>
    <p class="lead">Discover and compare the top smartphones with full specifications and user reviews.</p>

    <div class="row align-items-start">
        <!-- Creating smartphone carousel. -->
        <div class="col-lg-9">
            <div class="carousel-container position-relative">
                <div class="carousel-track d-flex" id="carouselTrack">
                    <?php foreach ($featuredPhones as $phone): ?>
                        <div class="card phone-card">
                            <img src="../images/<?= htmlspecialchars($phone->getImage()) ?>" class="card-img-top" alt="<?= htmlspecialchars($phone->getModel()) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($phone->getModel()) ?></h5>
                                <p class="card-text"><strong>Manufacturer:</strong> <?= htmlspecialchars($phone->getManufacturer()) ?></p>
                                <a href="smartphone.php?id=<?= urlencode($phone->getID()) ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Creating carousel navigation arrows. -->
                <button class="carousel-btn left" onclick="scrollCarousel(-1)">&#10094;</button>
                <button class="carousel-btn right" onclick="scrollCarousel(1)">&#10095;</button>
            </div>
        </div>

        <!-- Brief summary of the website (right). -->
        <div class="col-lg-3">
            <div class="site-description ps-3 pt-2">
                <h5 class="fw-semibold">What is this?</h5>
                <p style="font-size: 0.95rem;">
                    Our smartphone recommendation site helps you explore and compare the latest devices from top brands. Browse full specifications and user reviews to find the phone that fits your needs best.
                </p>
            </div>
        </div>
    </div>
</div>




<?php include '../content/footer.php'; ?>