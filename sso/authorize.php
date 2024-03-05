<?php session_start();
require __DIR__ . "../../core/app_core.php";

//validasi app_id
$app_id = strip_tags($_GET['app_id'] ?? null);
$redirect = $_GET['redirect'] ?? false;
if (!$app_id && !$redirect) {
    die("Unknown app id");
}
//cek aplikasi id 
$checkApp = $mysql->query("SELECT * FROM applications WHERE app_id='{$app_id}' LIMIT 1");
if ($checkApp->num_rows <= 0) {
    die('Aplikasi tidak terdaftar di sistem SSO! Sabar ya ngabs');
}

if (isset($_SESSION['auth_code'])) {
    $url = http_build_query([
        'code' => $_SESSION['auth_code']
    ]);
    header('location:' . $redirect .'?'. $url);
    exit;
}

$appInfo = $checkApp->fetch_object();

$redirectHost = parse_url($redirect)['host'];
$appUrl = parse_url($appInfo->url)['host'];
if ($redirectHost !== $appUrl) {
    die('Aplikasi tidak terdaftar di sistem SSO! Sabar ya ngabs');
}

if (!isset($_SESSION['urls'])) {
    $_SESSION['urls'] = $_SERVER['REQUEST_URI'];
}


if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    require __DIR__ . '/autorize_process.php';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSO Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 3px;
        }

        .form-group button {
            background-color: #007bff;
            color: #fff;
            width: 100%;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .copyright {
            font-size: small;
            text-align: center;
            color: gray;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login ke aplikasi</h2>
        <p class="infoalert">
            untuk melanjutkan ke aplikasi <a href=""><?= $appInfo->nama ?></a> silahkan masukan kredensial anda
        </p>
        <form method="POST" id="loginForm">
            <?php if (isset($_SESSION['error'])) {
            ?>

            <div
                style="color: red; margin-bottom:20px; font-size: 14px; margin-top: 5px; background-color: #ffebee; border: 1px solid #e57373; border-radius: 5px; padding: 10px;">
                <span style="margin-right: 5px;"><i class="fas fa-exclamation-circle"></i></span>
                <?= $_SESSION['error'] ?? '';
                    unset($_SESSION['error']) ?>
            </div>

            <?php
            } ?>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
                <p class='copyright'>
                    Developed By Dadan Hidayat
                </p>
            </div>
        </form>
    </div>
</body>

</html>