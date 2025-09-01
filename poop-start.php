<?php
declare(strict_types=1);
namespace PoopData;

include __DIR__ . '/Vendor/AutoLoader.php';

ob_start();
new PoopStart();
ob_end_flush();