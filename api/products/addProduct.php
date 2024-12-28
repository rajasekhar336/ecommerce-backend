<?php
require_once '../../config/database.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->price) && !empty($data->description)) {
    $name = $data->name;
    $price = $data->price;
    $description = $data->description;

    $productsCollection = $db->products;
    $result = $productsCollection->insertOne([
        'name' => $name,
        'price' => $price,
        'description' => $description
    ]);

    if ($result->getInsertedCount() > 0) {
        echo json_encode(['message' => 'Product added successfully']);
    } else {
        echo json_encode(['message' => 'Failed to add product']);
    }
} else {
    echo json_encode(['message' => 'All fields are required']);
}
?>
