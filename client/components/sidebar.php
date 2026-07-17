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
            <i class="fa-sold fa-user"></i>
            <span>Admin name</span>
        </div>
        <div class="list">
            <nav>
                <a class="sidebar-a"> <i class="fa-solid fa-user"></i> View Products</a>
                <a class="sidebar-a" href="../admin/addProduct.php">Add Products</a>
                <a class="sidebar-a" >View Low Stock</a>
                <a class="sidebar-a">View Sales</a>
                <a class="sidebar-a">Manage Users</a>
                <a class="sidebar-a">Profile</a>
            </nav>
        </div>

       
            <button class="logout-btn" id="btn">Logout</button>
       
    </aside>
    
    <script src="/POS/client/js/auth/logout.js"></script>
    </body>

    </html>