<?php 
    session_start();
    require_once('../../../server/db/config.php');

    if(!$_SESSION['user_id'] || $_SESSION['logged_in'] != true){
        header('Location: ../../../../auth/login.php');
    }

  
        $stmt= $pdo->prepare("
        SELECT 
        (SELECT COUNT(product_name) FROM products) AS total_products,
        (SELECT COUNT(product_name) FROM products WHERE product_quantity < 10) AS low_stock ");
        $stmt->execute();
        $products = $stmt->fetch(PDO::FETCH_ASSOC);
   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Point Of Sala System</title>
    <link rel="stylesheet" href="../../styles/dashboard/adminDashboard.css?v=<?= filemtime('../../styles/dashboard/adminDashboard.css')?>">
</head>
<body>
    <div>
        <?php include('../../components/sidebar.php')?>
    </div>

    <section>
       <div class="section">
            <h2>POINT OF SALES SYSTEM</h2>
            <div id="date">00: 00: 00</div>
       </div>

       <div class="cards">
        <div>
            <span>Total Products</span>
            <span><?=htmlspecialchars($products['total_products'] ?? 0)?></span>
        </div>
        <div>
            <span>Low Stock Products</span>
            <span><?=htmlspecialchars($products['low_stock'] ?? 0)?></span>
        </div>
        <div>
            <span>Total Sales</span>
            <span>0</span>
        </div>
       </div>
       
    </section>

    <script src="../../js/auth/time.js"></script>
</body>
</html>