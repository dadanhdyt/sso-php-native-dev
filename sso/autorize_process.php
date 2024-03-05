<?php 

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$return = $_SESSION['urls'];
[$username,$password] = [
    $mysql->escape_string($username),
    $mysql->escape_string($password)
];

$check = $mysql->query("SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1");
if($check->num_rows > 0) {
    $callback = $_GET['redirect'];
    $_SESSION['auth_code'] = create_uuid();
    header('location:'.$callback."?code=".$_SESSION['auth_code']);
} else {
    $_SESSION['error'] = "Username atau password salah!"; 
    header('location:'.$return);
    die();
}