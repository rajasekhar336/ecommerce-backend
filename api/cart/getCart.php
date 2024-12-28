<?php
require_once '../../config/database.php';
header('Content-Type: application/json');

$userId = $_GET['userId'];

$cartCollection = $db->cart;
$cartItems = $cartCollection->aggregate([
    [
        '$lookup' => [
            'from' => 'products',
            'localField' => 'product_id',
            'foreignField' => '_id',
            'as' => 'product'
        ]
    ],
    [
        '$match' => ['user_id' => $userId]
    ]
])->toArray();

echo json_encode($cartItems);
?>
