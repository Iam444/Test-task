<?php

$dev_mode = true;
$root_path = "/";
$app_path = __DIR__;

$admin_username = 'admin';
$admin_pass = '123';

if ($dev_mode == true) {
    $host = "localhost";
    $user = "root";
    $pass = "Logos2013";
    $dbname = "test";
    $charset = "utf8mb4";
    $type = "mysql";

} else
{
    $host = "127.0.0.1";
    $user = "Iam444";
    $pass = "Test4todo";
    $dbname = "iam444";
    $charset = "utf8";
    $type = "mysql";
}

require_once dirname($app_path) . '/vendor/autoload.php';

define("ROOT_PATH", $root_path);
define("APP_PATH", $app_path);

define("DATABASE_HOST", $host);
define("DATABASE_USER", $user);
define("DATABASE_PASSWORD", $pass);
define("DATABASE_NAME", $dbname);
define("DATABASE_CHARSET", $charset);
define("DATABASE_TYPE", $type);

define("ADMIN_NAME", $admin_username);
define("ADMIN_PASS", $admin_pass);
