<?php
require_once '../../config/database.php';
header('Content-Type: application/json');

$productId = $_GET['id'];

$productsCollection = $db->products;
$product = $productsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($productId)]);

echo json_encode($product);
?>
