<?php
include '../content/header.php';
require_once '../classes/Smartphone.php';

// Creates a session if one is not already started.
if ( session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Loading the smartphones from the JSON file, Converting smartphones to objects.
$smartphoneData = json_decode(file_get_contents('../data/smartphones.json'), true);
$smartphones = [];

foreach ($smartphoneData as $phoneData) {
    $smartphones[] = new Smartphone($phoneData);
}


// Get sort paramters from URL (defaults to sorting by score descending.)
$sort = $_GET['sort'] ?? 'score';
$order = $_GET['order'] ?? 'desc';

// Only allows sorting in the approved columns.
$validSorts = ['Score', 'Manufacturer'];
if (!in_array($sort, $validSorts)) {
    $sort = 'Score';
}

// Function to toggle sort order for the clicked column.
$toggleOrder = function($column) use ($sort, $order) {
    return ($sort === $column && $order === 'asc') ? 'desc' : 'asc';
};

// Sorts the smartphones array based on selected column and order.
usort($smartphones, function ($a, $b) use ($sort, $order) {
    if ($sort === 'Manufacturer') {
        $valA = strtolower($a->getManufacturer());
        $valB = strtolower($b->getManufacturer());
    } else {
        $valA = (float) $a->getScore();
        $valB = (float) $b->getScore();
    }

    return $order === 'asc' ? $valA <=> $valB : $valB <=> $valA;
});
?>

<h1>Smartphone Rankings</h1>

<!-- Creating a table to display smartphone data with clickable sortable headers -->
<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>Model</th>
            <th>
                <a href="?sort=Manufacturer&order=<?= $toggleOrder('Manufacturer') ?>" class="text-white text-decoration-none">
                    Manufacturer <?= $sort === 'Manufacturer' ? ($order === 'asc' ? '▲' : '▼') : '⇅' ?>
                </a>
            </th>
            <th>Release Date</th>
            <th>Screen Size</th>
            <th>
                <a href="?sort=score&order=<?=$toggleOrder($sort)?>" class="text-white text-decoration-none">
                    Score <?= $sort === 'Score' ?  ($order === 'asc' ? '▲' : '▼') : '⇅' ?>
                </a>
            </th>
            <th>Details</th>
        </tr>
    </thead>
        <?php foreach ($smartphones as $phone): ?>
            <tr>
                <td><?= htmlspecialchars($phone->getModel()) ?></td>
                <td><?= htmlspecialchars($phone->getManufacturer()) ?></td>
                <td><?= htmlspecialchars($phone->getReleaseDate()) ?></td>
                <td><?= htmlspecialchars($phone->getScreenSize()) ?></td>
                <td><strong><?= htmlspecialchars($phone->getScore()) ?></strong></td>
                <td>
                    <a href="smartphone.php?id=<?= urlencode($phone->getID()) ?>" class="btn btn-sm btn-primary">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../content/footer.php'; ?>