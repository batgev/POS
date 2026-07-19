<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
    <link rel="stylesheet" href="../../styles/sidebar/sidebar.css?v=<?= filemtime('../../styles/sidebar/sidebar.css')?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

    <body>
        
    <aside>
        <div class="top-text">
            <i class="fa-solid fa-user-circle"></i>
            <span>Admin name</span>
        </div>
        <div class="list">
            <nav>
                <a class="sidebar-a" href="../admin/viewProducts.php"> <i class="fa-solid fa-cart-shopping"></i> View Products</a>
                <a class="sidebar-a" href="../admin/addProduct.php"><i class="fa-solid fa-cart-shopping"></i> Add Products</a>
                <a class="sidebar-a" href="../admin/lowStock.php"><i class="fa-solid fa-exclamation-triangle "></i> View Low Stock</a>
                <a class="sidebar-a" href="../admin/viewSales.php"><i class="fa-solid fa-chart-bar"></i> View Sales</a>
                <a class="sidebar-a" href="../admin/manageUsers.php"><i class="fa-solid fa-user-cog"></i> Manage Users</a>
                <a class="sidebar-a" href="../admin/profile.php"><i class=" fa-solid fa-user-shield"></i> Profile</a>
            </nav>
        </div>

       
            <button class="logout-btn" id="btn">Logout</button>
       
    </aside>
    
    <script src="/POS/client/js/auth/logout.js"></script>
    </body>

    </html>