<?php
require_once '../../config/database.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->email) && !empty($data->password)) {
    $name = $data->name;
    $email = $data->email;
    $password = password_hash($data->password, PASSWORD_DEFAULT);

    $usersCollection = $db->users;
    $result = $usersCollection->insertOne([
        'name' => $name,
        'email' => $email,
        'password' => $password
    ]);

    if ($result->getInsertedCount() > 0) {
        echo json_encode(['message' => 'User registered successfully']);
    } else {
        echo json_encode(['message' => 'Registration failed']);
    }
} else {
    echo json_encode(['message' => 'All fields are required']);
}
?>
