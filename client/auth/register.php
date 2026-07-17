<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration | Point Of Sale System</title>
   
</head>
<body>
    <form>
        <div class="headings">
           <h3> Point Of Sale System</h3>
           <span>Add Admin</span>
        </div>
       <div class="input-container">
        <div class="input-layout">
            <label for="username">Username</label>
            <input type="text" id="username"   placeholder="eg. Kofi Adams">
        </div>
        <div class="input-layout">
            <label for="password">Password</label>
            <input type="password" id="password"  placeholder="********" minlength="8" maxlength="64">
        </div>
       </div>
        <button id="login-btn">Sign Up</button>
     </form>
     <script src="../js/auth/registeration.js?v=<?= filemtime('../js/auth/registeration.js')?>"></script>
</body>
</html>