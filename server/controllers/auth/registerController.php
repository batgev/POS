<?php
require_once __DIR__  . '/../../db/config.php';


header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$username = trim($data['username'] ?? '');
$password = $data['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'all fields are required']);
    exit;
}

try {
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users(username,password,role) VALUES(?,?,?)');
    $stmt->execute([$username, $hash_password, 'admin']);
    echo json_encode(['success' => true, 'message' => 'registered succesfully']);
} catch (PDOException  $e) {
    if ($e->getCode() == 23000) {
        echo json_encode(['success' => false, 'message' => 'user exists already']);
        exit;
    } 
        error_log($e->getMessage());
        echo json_encode(['success' => false, 'message' => 'server error, try again']);
    
}


