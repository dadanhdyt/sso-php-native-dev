<?php 
require __DIR__ . "../../core/app_core.php";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $code = $mysql->escape_string($data['code']);
    $client_id = $mysql->escape_string($data['client_id']);
    $secret_key = $mysql->escape_string($data['secret_key']);
    //validasi
}

?>