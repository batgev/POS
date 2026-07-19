<?php 
require_once('../../db/config.php');

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'method not allowed']);
    exit();
}

$product_id = isset($_POST['productId']) && $_POST['productId'] !== '' ? (int)$_POST['productId'] : null;

$product_name = trim((string)($_POST['productName'] ?? ''));
$product_quantity = $_POST['productQuantity'] ?? null;
$product_unitPrice = $_POST['productUnitPrice'] ?? null;
$product_cost = trim((string)($_POST['productCost'] ?? ''));
$product_sellingPrice = trim((string)($_POST['productSellingPrice'] ?? ''));

if ($product_id === null) {
    if ($product_name === '' || $product_quantity === null || $product_unitPrice === null || $product_cost === '' || $product_sellingPrice === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'all fields are mandatory']);
        exit();
    }
} else {
    // For update, we still require core fields
    if ($product_name === '' || $product_quantity === null || $product_unitPrice === null || $product_cost === '' || $product_sellingPrice === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'all fields are mandatory']);
        exit();
    }
}

$product_quantity = (int)$product_quantity;
$product_unitPrice = (float)$product_unitPrice;
$product_cost = (float)$product_cost;
$product_sellingPrice = (float)$product_sellingPrice;

if ($product_id !== null && $product_id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'invalid product id']);
    exit();
}

if ($product_quantity < 0 || $product_unitPrice < 0 || $product_cost < 0 || $product_sellingPrice < 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'invalid numeric values']);
    exit();
}

$uploadedImagePath = null;

// Handle optional upload (image is optional during update; if omitted, keep existing)
if (isset($_FILES['productImage']) && is_array($_FILES['productImage']) && ($_FILES['productImage']['name'] ?? '') !== '') {
    if ($_FILES['productImage']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'image upload failed']);
        exit();
    }

    $tmpName = $_FILES['productImage']['tmp_name'];
    $originalName = $_FILES['productImage']['name'];

    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($ext, $allowedExt, true)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'invalid image type']);
        exit();
    }

    $uploadDir = __DIR__ . '/../../uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filename = 'product_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
    $destination = $uploadDir . '/' . $filename;

    if (!move_uploaded_file($tmpName, $destination)) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'failed to store image']);
        exit();
    }

    // Store relative path or filename based on how your UI expects it.
    $uploadedImagePath = 'uploads/' . $filename;
}

try {
    // If productId is present => update, otherwise insert
    if ($product_id !== null) {
        if ($uploadedImagePath === null) {
            // Keep existing image
            $stmt = $pdo->prepare(
                "UPDATE products 
                 SET product_name = ?, product_quantity = ?, product_unit_price = ?, cost_price = ?, selling_price = ?
                 WHERE id = ?"
            );
            $stmt->execute([
                $product_name,
                $product_quantity,
                $product_unitPrice,
                $product_cost,
                $product_sellingPrice,
                $product_id
            ]);
        } else {
            $stmt = $pdo->prepare(
                "UPDATE products 
                 SET product_name = ?, product_quantity = ?, product_unit_price = ?, cost_price = ?, selling_price = ?, product_image = ?
                 WHERE id = ?"
            );
            $stmt->execute([
                $product_name,
                $product_quantity,
                $product_unitPrice,
                $product_cost,
                $product_sellingPrice,
                $uploadedImagePath,
                $product_id
            ]);
        }

        echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO products (product_name, product_quantity, product_unit_price, cost_price, selling_price, product_image) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->execute([
            $product_name,
            $product_quantity,
            $product_unitPrice,
            $product_cost,
            $product_sellingPrice,
            $uploadedImagePath
        ]);

        echo json_encode(['success' => true, 'message' => 'Product added successfully']);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'server error, try again']);
}

exit();
?>
