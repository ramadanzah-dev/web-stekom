<?php
define('BASE_PATH', __DIR__);
require BASE_PATH . '/app/Core/helpers.php';
require BASE_PATH . '/app/Core/Database.php';
require BASE_PATH . '/app/Models/Pengaturan.php';
$GLOBALS['app_config'] = require BASE_PATH . '/config/config.php';
$GLOBALS['app_config']['site'] = (new \App\Models\Pengaturan())->apply($GLOBALS['app_config']['site']);
echo "Marquee: " . config('site_marquee') . "\n";
echo "Oprec Aktif: " . config('oprec_aktif') . "\n";
?>