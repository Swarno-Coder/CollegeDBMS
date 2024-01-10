<?php
// Check login credentials (for simplicity, hardcoding username and password)
$correctUsername = 'admin';
$correctPassword = 'password89';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $correctUsername && $password === $correctPassword) {
        // Authentication successful
        $_SESSION['username'] = $username;
        $_SESSION['logined']=true;
        session_start();
        header('Location: main.php');
        exit();
    } else {
        // Authentication failed
        $_GET["error"] = "<p color='red'>Invalid username or password</p>";
    }
}
?>

