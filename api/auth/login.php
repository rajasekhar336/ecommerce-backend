<?php
require_once '../../config/database.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->email) && !empty($data->password)) {
    $email = $data->email;
    $password = $data->password;

    $usersCollection = $db->users;
    $user = $usersCollection->findOne(['email' => $email]);

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode(['message' => 'Login successful', 'user' => $user]);
    } else {
        echo json_encode(['message' => 'Invalid credentials']);
    }
} else {
    echo json_encode(['message' => 'Email and password are required']);
}
?>
