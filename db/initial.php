<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/db/db.php';

$database = new Db();
$db=$database->get_connected();
