<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Point Of Sale System</title>
    <link rel="stylesheet" href="../styles/auth/login.css?v=<?= filemtime('../styles/auth/login.css')?>">
</head>
<body>
    <form method="post">
        <div class="headings">
           <h3> Point Of Sale System</h3>
           <span>Login to access dashboard</span>
        </div>
       <div class="input-container">
        <div class="input-layout">
            <label for="username">Username</label>
            <input type="text" id="username"  required placeholder="eg. Kofi Adams">
        </div>
        <div class="input-layout">
            <label for="password">Password</label>
            <input type="password" id="password" required placeholder="********" minlength="8" maxlength="64">
        </div>
       </div>
        <button id="login-btn">Sign In</button>
     </form>
     <script src="../js/auth/login.js?v=<?= filemtime('../js/auth/login.js')?>"></script>
</body>
</html>