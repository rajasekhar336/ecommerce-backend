<?php
require_once '../../config/database.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->userId) && !empty($data->productId) && !empty($data->quantity)) {
    $userId = $data->userId;
    $productId = $data->productId;
    $quantity = $data->quantity;

    $cartCollection = $db->cart;
    $result = $cartCollection->insertOne([
        'user_id' => $userId,
        'product_id' => $productId,
        'quantity' => $quantity
    ]);

    if ($result->getInsertedCount() > 0) {
        echo json_encode(['message' => 'Product added to cart']);
    } else {
        echo json_encode(['message' => 'Failed to add product to cart']);
    }
} else {
    echo json_encode(['message' => 'All fields are required']);
}
?>
