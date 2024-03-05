<?php 
define("HOST","localhost");
define('USER', 'root');
define('PASS', '');
define('DB_NAME', 'mysso');

try {
    $mysql = new mysqli(
        HOST,
        USER,
        PASS,
        DB_NAME
    );
    /**
     * setting caracter set default nya
     */
    $mysql->set_charset('utf8mb4');
} catch (mysqli_sql_exception $th) {
    die( $th->getMessage() );
}