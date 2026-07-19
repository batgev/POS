<?php 
    session_start();
   if($_SESSION['logged_in'] != true || !$_SESSION['logged_in']){
    header('Location: ../../../../auth/login.php');
    exit;
   }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Point Of Sales System</title>
    <link rel="stylesheet" href="../../styles/dashboard/addProductStyles.css?v=<?= filemtime('../../styles/dashboard/addProductStyles.css')?>">
</head><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<body>
    <div>
        <?php include('../../components/sidebar.php')?>
    </div>
    <div class="main-container">
        <div class="back-btn" title="go back to the home page">
            <a class="a" href="/POS/client/dashboards/admin/index.php">Go Home</a> 
        </div>

      <div class="add-product-container">
      <form class="add-product-form" >
            <span>Add a product to your inventory</span>
            <div>
                <label for="product-name">Product Name</label>
                <input type="text" id="product-name" placeholder="Eg. iPhone 13" maxlength="64">
            </div>
            <div>
                <label for="product-quantity">Product Quantity</label>
                <input type="number" id="product-quantity" max="100000000">
            </div>
            <div>
                <label for="product-unit-price">Product Unit Price</label>
                <input type="number" id="product-unit-price" max="100000000">
            </div>
            <div>
                <label for="product-cost-price">Product Cost Price</label>
                <input type="text" id="product-cost-price">
            </div>
            <div>
                <label for="product-selling-price">Product Selling Price</label>
                <input type="text" id="product-selling-price">
            </div>
            <div>
                <label for="product-image">Product Image</label>
                <input type="file" id="product-image">
            </div>
            <button type="button" id="add-product-btn" class="add-product-btn">Add Product</button>
        </form>
      </div>
    </div>
    <script src="../../js/dashboards/addProduct.js?v=<?= filemtime('../../js/dashboards/addProduct.js')?>"></script>
</body>
</html>