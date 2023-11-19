<?php 

date_default_timezone_set("America/Guatemala");

use Dotenv\Dotenv;
use Model\ActiveRecord;
use Model\Connection;

require __DIR__ . '/../vendor/autoload.php';

// Añadir Dotenv
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

require 'functions.php';

$db = Connection::getInstance()->getDB();
ActiveRecord::setDB($db);