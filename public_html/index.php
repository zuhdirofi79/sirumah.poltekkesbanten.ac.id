<?php
/** SI RUMAH BANTEN - public entrypoint for Hostinger sibling folder */
define('LARAVEL_START', microtime(true));
$base = dirname(__DIR__).'/laravel-sirumah-polkesten';
if (file_exists($maintenance = $base.'/storage/framework/maintenance.php')) require $maintenance;
require $base.'/vendor/autoload.php';
(require $base.'/bootstrap/app.php')->handleRequest(Illuminate\Http\Request::capture());
