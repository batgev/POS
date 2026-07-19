<?php
session_start();
require_once('../../../server/db/config.php');

if(!isset($_SESSION['user_id']) || $_SESSION['logged_in'] != true){
    header('Location: ../../../../auth/login.php');
    exit;
}

// Product id can come via query string
$id = isset($_GET['id']) ? (string)$_GET['id'] : '';

$product = null;
if($id !== ''){
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

if(!$product){
    // If product not found, show simple message.
    $_msg = 'Product not found.';
    $product = [];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product | Point Of Sales System</title>
    <link rel="stylesheet" href="../../styles/dashboard/addProductStyles.css?v=<?= filemtime('../../styles/dashboard/addProductStyles.css')?>">
</head>
<body>
    <div>
        <?php include('../../components/sidebar.php')?>
    </div>

    <div class="main-container">
        <div class="back-btn" title="go back to the home page">
            <a class="a" href="/POS/client/dashboards/admin/viewProducts.php">Home</a> / editProduct
        </div>

        <?php if(isset($_msg)): ?>
            <div style="margin: 10px 0; color: #dc3545; font-weight: 600;"><?= htmlspecialchars((string)$_msg) ?></div>
        <?php endif; ?>

        <form class="add-product-form">
            <span>Edit product details</span>

            <div>
                <label for="product-name">Product Name</label>
                <input type="text" id="product-name" value="<?= htmlspecialchars((string)($product['product_name'] ?? '')) ?>" placeholder="Eg. iPhone 13" maxlength="64">
            </div>

            <div>
                <label for="product-quantity">Product Quantity</label>
                <input type="number" id="product-quantity" value="<?= htmlspecialchars((string)($product['product_quantity'] ?? '')) ?>" max="100000000">
            </div>

            <div>
                <label for="product-unit-price">Product Unit Price</label>
                <input type="number" id="product-unit-price" value="<?= htmlspecialchars((string)($product['product_unit_price'] ?? '')) ?>" max="100000000">
            </div>

            <div>
                <label for="product-cost-price">Product Cost Price</label>
                <input type="text" id="product-cost-price" value="<?= htmlspecialchars((string)($product['cost_price'] ?? '')) ?>">
            </div>

            <div>
                <label for="product-selling-price">Product Selling Price</label>
                <input type="text" id="product-selling-price" value="<?= htmlspecialchars((string)($product['selling_price'] ?? '')) ?>">
            </div>

            <div>
                <label>Current Image</label><br>
                <?php
                    $img = $product['product_image'] ?? '';
                    $imgSrc = $img !== '' ? ('/POS/server/' . ltrim($img, '/')) : '';
                ?>
                <?php if($imgSrc): ?>
                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="product" style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px; border: 1px solid #eee;" />
                <?php else: ?>
                    <span>-</span>
                <?php endif; ?>
            </div>

            <div>
                <label for="product-image">Change Image (optional)</label>
                <input type="file" id="product-image">
            </div>

            <button type="button" id="add-product-btn" class="add-product-btn" data-product-id="<?= htmlspecialchars((string)$id) ?>">Update Product</button>
        </form>
    </div>

    <script>
        // Reuse existing addProduct JS only if needed; instead provide minimal fetch here.
        const btn = document.getElementById('add-product-btn');
        const productNameEl = document.getElementById('product-name');
        const productQuantityEl = document.getElementById('product-quantity');
        const productUnitPriceEl = document.getElementById('product-unit-price');
        const productCostPriceEl = document.getElementById('product-cost-price');
        const productSellingPriceEl = document.getElementById('product-selling-price');
        const productImageEl = document.getElementById('product-image');

        btn.addEventListener('click', async () => {
            const productId = btn.getAttribute('data-product-id');

            if(!productId){
                return alert('Missing product id');
            }

            if(!productNameEl.value || !productQuantityEl.value || !productUnitPriceEl.value || !productCostPriceEl.value || !productSellingPriceEl.value){
                return alert('all fields are mandatory');
            }

            const formData = new FormData();
            formData.append('productId', productId);
            formData.append('productName', productNameEl.value);
            formData.append('productQuantity', productQuantityEl.value);
            formData.append('productUnitPrice', productUnitPriceEl.value);
            formData.append('productCost', productCostPriceEl.value);
            formData.append('productSellingPrice', productSellingPriceEl.value);

            const file = productImageEl.files[0];
            if(file){
                formData.append('productImage', file);
            }

            try{
                const res = await fetch('../../../server/controllers/dashboards/addProductController.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();
                if(!data.success){
                    return alert(data.message || 'Update failed');
                }
                alert(data.message || 'Updated successfully');
                window.location.href = '/POS/client/dashboards/admin/viewProducts.php';
            }catch(err){
                console.error(err);
                alert('something went wrong');
            }
        });
    </script>
</body>
</html>

