<?php
require_once '../../config/database.php';
header('Content-Type: application/json');

$productsCollection = $db->products;
$products = $productsCollection->find()->toArray();

echo json_encode($products);
?>
