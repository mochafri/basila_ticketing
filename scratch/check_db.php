<?php
require 'app/Config/Database.php';
$db = \Config\Database::connect();
$query = $db->query("SHOW COLUMNS FROM tikets LIKE 'level_kesulitan'");
$result = $query->getRow();
print_r($result);
