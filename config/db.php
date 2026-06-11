<?php
require __DIR__ . '/../vendor/autoload.php';

$client = new MongoDB\Client("mongodb+srv://maulidid25_db_user:yukibaik1@cluster0.z7k68sq.mongodb.net/");

$db = $client->watchlist_db;
$users = $db->users;
$watchlist = $db->watchlist;
?>