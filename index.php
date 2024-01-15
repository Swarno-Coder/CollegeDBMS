<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>College Database</title>
<style>
.loginbody {font-family: "Roboto";background-color: #573cfa;margin: 0;display: flex;align-items: center;justify-content: center;height: 100vh;}
.login-container {background-color: rgba(255, 255, 255, 0.25);padding: 20px;border-radius: 8px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);width: 325px;text-align: center;}
.login-container h1 {margin-top: 30px;margin-bottom: 20px;font-family: "Poppins";color: rgba(255, 255, 255, 0.95);}
.form-group {margin-bottom: 15px;}
.form-group label {display: block;font-weight: bold;margin-bottom: 5px;float: left;color :rgba(255, 255, 255, 0.9);}
.form-group input {width: 100%;padding: 8px;box-sizing: border-box;border: 1px solid #ccc;border-radius: 4px;}
.login-btn {background-color: #11e618d2;font-weight: bolder;color: #fff;width: 100%;padding: 10px;border: none;border-radius: 6px;cursor: pointer;}
.login-btn:hover {background-color: #45a049;}
</style>
</head>
<body class="loginbody">
    <div class="login-container">
        <h1>Login</h1>
        <form action="" method="post">
            <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required placeholder="Enter the username...">
            </div>
            <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required placeholder="Enter the password...">
            </div>
            <?php include "credentials.php";
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username'];
                $password = $_POST['password'];
                if ($username === $correctUsername && $password === $correctPassword) {
                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['logined'] = 'true';
                    header('Location: main.php');
                    exit();
                } else { echo "<p style='color:red;'>Invalid username or password</p>";}}?>
            <button type="submit" class="login-btn" name="login">Login</button>
        </form></div>
</body>
</html>
