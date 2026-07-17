<?php
require_once(__DIR__ . '/../../db/config.php');

header('Content-Type: application/json');
session_start();

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request payload (expected JSON).']);
    exit();
}

$username = trim((string)($data['username'] ?? ''));
$password = (string)($data['password'] ?? '');

if ($username === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'all fields are required']);
    exit();
}

try {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username=?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['logged_in'] = true;

        echo json_encode([
            'success' => true,
            'message' => 'logged in successfully',
            'role' => ($user['role'] ?? 'admin')
        ]);
    } else {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'invalid credentials']);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'server error, try again']);
}

exit();

