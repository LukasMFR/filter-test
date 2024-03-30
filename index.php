<?php
// Assuming you're using PDO to connect to the database.

// Database connection details.
$db_name = 'mysql:host=localhost;dbname=filter_test';
$db_user = 'root';
$db_password = '';

try {
    $pdo = new PDO($db_name, $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $db_name :" . $e->getMessage());
}

// Initialize an array to hold the filter conditions.
$conditions = [];
$params = [];

// Check for filters and add them to the conditions.
if (!empty($_GET['marque'])) {
    $conditions[] = 'marque = :marque';
    $params[':marque'] = $_GET['marque'];
}
if (!empty($_GET['boite'])) {
    $conditions[] = 'boite = :boite';
    $params[':boite'] = $_GET['boite'];
}
if (!empty($_GET['annee'])) {
    $conditions[] = 'annee = :annee';
    $params[':annee'] = $_GET['annee'];
}
if (!empty($_GET['kilometrage'])) {
    $conditions[] = 'kilometrage <= :kilometrage';
    $params[':kilometrage'] = $_GET['kilometrage'];
}
if (!empty($_GET['energie'])) {
    $conditions[] = 'energie = :energie';
    $params[':energie'] = $_GET['energie'];
}
if (!empty($_GET['prix'])) {
    $conditions[] = 'prix <= :prix';
    $params[':prix'] = $_GET['prix'];
}
if (!empty($_GET['hp'])) {
    $conditions[] = 'hp >= :hp';
    $params[':hp'] = $_GET['hp'];
}

// Build the SQL query with initial SELECT statement.
$sql = 'SELECT * FROM cars';

if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

// Initialize variables for sorting.
$sort_by = isset($_GET['sort_by']) && in_array($_GET['sort_by'], ['prix', 'annee', 'kilometrage', 'hp']) ? $_GET['sort_by'] : 'prix'; // Default sorting by price
$sort_order = isset($_GET['sort_order']) && $_GET['sort_order'] === 'DESC' ? 'DESC' : 'ASC'; // Default sorting order to ASC

// Add sorting to the SQL query.
$sql .= " ORDER BY $sort_by $sort_order";

// Prepare and execute the SQL query.
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

// Fetch the results.
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filtered Results</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Car Filters and Sorting</h2>

<!-- Filter and Sorting Form -->
<form action="" method="get">
    Marque: <input type="text" name="marque">
    Boîte: <select name="boite">
        <option value="">Any</option>
        <option value="Auto">Auto</option>
        <option value="Manuelle">Manuelle</option>
    </select>
    Année: <input type="number" name="annee" min="1900" max="2023">
    Kilométrage: <input type="number" name="kilometrage">
    Énergie: <select name="energie">
        <option value="">Any</option>
        <option value="Essence">Essence</option>
        <option value="Diesel">Diesel</option>
        <option value="Électrique">Électrique</option>
        <option value="Hybride">Hybride</option>
    </select>
    Prix: <input type="number" name="prix">
    HP: <input type="number" name="hp">
    Sort by: <select name="sort_by">
        <option value="prix">Prix</option>
        <option value="annee">Année</option>
        <option value="kilometrage">Kilométrage</option>
        <option value="hp">HP</option>
    </select>
    Order: <select name="sort_order">
        <option value="ASC">Ascending</option>
        <option value="DESC">Descending</option>
    </select>
    <input type="submit" value="Apply Filters">
</form>

<h2>Filtered Results</h2>

<table>
    <tr>
        <th>Marque</th>
        <th>Boîte</th>
        <th>Année</th>
        <th>Kilométrage</th>
        <th>Énergie</th>
        <th>Prix</th>
        <th>HP</th>
    </tr>
    <?php if (!empty($cars)): ?>
        <?php foreach ($cars as $car): ?>
            <tr>
                <td><?php echo htmlspecialchars($car['marque']); ?></td>
                <td><?php echo htmlspecialchars($car['boite']); ?></td>
                <td><?php echo htmlspecialchars($car['annee']); ?></td>
                <td><?php echo number_format(htmlspecialchars($car['kilometrage']), 0, '.', ' '); ?> km</td>
                <td><?php echo htmlspecialchars($car['energie']); ?></td>
                <td><?php echo number_format(htmlspecialchars($car['prix']), 2, ',', ' '); ?> €</td>
                <td><?php echo htmlspecialchars($car['hp']); ?> HP</td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7">No results found.</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>
