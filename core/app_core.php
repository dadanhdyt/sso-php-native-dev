<?php 
define('CORE_PATH', __DIR__.DIRECTORY_SEPARATOR);
define('BASE_PATH', dirname(CORE_PATH).DIRECTORY_SEPARATOR);
//load db connection
require CORE_PATH.'db_connection.php';
date_default_timezone_set("UTC");



// Membuat UUID baru
function create_uuid() {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // version 4
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant is 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}


function is_valid_uuid($uuid) {
    return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $uuid);
}