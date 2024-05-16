<?php
header('Content-Type: application/json');
require "autoloader.php";
require "router.php";

Router::routes();

?>