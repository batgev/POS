<?php
    session_start();
    require_once('../../../server/db/config.php');

    if(!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true){
        header('Location: ../../../../auth/login.php');
        exit;
    }

    $lowStockLimit = 10;

    $stmt = $pdo->prepare(
        "SELECT product_name, product_quantity, product_image
         FROM products
         WHERE product_quantity < ?
         ORDER BY product_quantity ASC"
    );
    $stmt->execute([$lowStockLimit]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Low Stock | Point Of Sales System</title>

    <link rel="stylesheet" href="../../styles/dashboard/lowStock.css?v=<?= filemtime('../../styles/dashboard/lowStock.css')?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="lowstock-page">
    <div>
        <?php include('../../components/sidebar.php') ?>
    </div>

    <section class="lowstock-main">
        <div class="lowstock-header">
            <h2>Low Stock Products</h2>
            <p>Products with quantity less than <?= htmlspecialchars((string)$lowStockLimit) ?></p>
        </div>

        <div class="lowstock-table-wrap">
            <table class="lowstock-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($products)): ?>
                        <tr>
                            <td class="lowstock-empty" colspan="3">No low stock products found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($products as $product):
                            $image = $product['product_image'] ?? '';
                            $imageSrc = $image !== '' ? ('/POS/server/' . ltrim($image, '/')) : '';
                        ?>
                            <tr>
                                <td class="lowstock-product-name"><?= htmlspecialchars((string)($product['product_name'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string)($product['product_quantity'] ?? '')) ?></td>
                                <td>
                                    <?php if($imageSrc): ?>
                                        <img class="lowstock-img" src="<?= htmlspecialchars($imageSrc) ?>" alt="product">
                                    <?php else: ?>
                                        <span>-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>

