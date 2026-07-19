<?php 
    session_start();
    require_once('../../../server/db/config.php');

    if(!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true){
        header('Location: ../../../../auth/login.php');
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM products");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Determine whether the table has an id column.
    $hasId = !empty($products) && array_key_exists('id', $products[0]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products | Point Of Sales System</title>

    <link rel="stylesheet" href="../../styles/dashboard/viewProducts.css?v=<?= filemtime('../../styles/dashboard/viewProducts.css')?>">
</head>
<body>
    <div>
        <?php include('../../components/sidebar.php') ?>
    </div>

    <section class="main-section">   
        <div >
            <div style="margin-left:30px;font-weight:bold;font-size:30px;">
                <span>Total Products</span>
                <span><?= htmlspecialchars((string)count($products)) ?></span>
            </div>
        </div>

        <div class="table-section">
            <h3 style="margin: 1rem 0;">Products</h3>

            <table class="products-table" style="width: 100%; border-collapse: collapse; background: #fff;">
                <thead>
                    <tr>
                        <?php if($hasId): ?>
                            <th style="text-align:left; padding: 10px; border-bottom: 1px solid #ddd;">ID</th>
                        <?php endif; ?>
                        <th style="text-align:left; padding: 10px; border-bottom: 1px solid #ddd;">Product Name</th>
                        <th style="text-align:left; padding: 10px; border-bottom: 1px solid #ddd;">Quantity</th>
                        <th style="text-align:left; padding: 10px; border-bottom: 1px solid #ddd;">Unit Price</th>
                        <th style="text-align:left; padding: 10px; border-bottom: 1px solid #ddd;">Cost Price</th>
                        <th style="text-align:left; padding: 10px; border-bottom: 1px solid #ddd;">Selling Price</th>
                        <th style="text-align:left; padding: 10px; border-bottom: 1px solid #ddd;">Image</th>
                        <th style="text-align:left; padding: 10px; border-bottom: 1px solid #ddd;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($products)): ?>
                        <tr>
                            <td colspan="<?= $hasId ? '8' : '7' ?>" style="padding: 14px;">No products found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($products as $index => $product):
                            $rowId = $hasId ? ($product['id'] ?? '') : ($index + 1);
                            $image = $product['product_image'] ?? '';
                            $imageSrc = $image !== '' ? ('/POS/server/' . ltrim($image, '/')) : '';
                        ?>
                            <tr>
                                <?php if($hasId): ?>
                                    <td style="padding: 10px; border-bottom: 1px solid #eee;"><?= htmlspecialchars((string)$rowId) ?></td>
                                <?php endif; ?>
                                <td style="padding: 10px; border-bottom: 1px solid #eee;"><?= htmlspecialchars((string)($product['product_name'] ?? '')) ?></td>
                                <td style="padding: 10px; border-bottom: 1px solid #eee;"><?= htmlspecialchars((string)($product['product_quantity'] ?? '')) ?></td>
                                <td style="padding: 10px; border-bottom: 1px solid #eee;"><?= htmlspecialchars((string)($product['product_unit_price'] ?? '')) ?></td>
                                <td style="padding: 10px; border-bottom: 1px solid #eee;"><?= htmlspecialchars((string)($product['cost_price'] ?? '')) ?></td>
                                <td style="padding: 10px; border-bottom: 1px solid #eee;"><?= htmlspecialchars((string)($product['selling_price'] ?? '')) ?></td>
                                <td style="padding: 10px; border-bottom: 1px solid #eee;">
                                    <?php if($imageSrc): ?>
                                        <img src="<?= htmlspecialchars($imageSrc) ?>" alt="product" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                    <?php else: ?>
                                        <span>-</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 10px; border-bottom: 1px solid #eee;">
<a href="../admin/editProduct.php?id=<?= urlencode((string)$rowId) ?>" style="display:inline-block; padding: 6px 10px; background: #0b5ed7; color: #fff; border-radius: 6px; text-decoration: none;">Edit</a>
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

