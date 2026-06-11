<?php
require __DIR__ . '/../vendor/autoload.php';

$client = new Google_Client();
$client->setClientId("409213930432-gvdqa2bg1c53ne742g13o9sock9p2o7n.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/watchlist/auth/google_login.php");
$client->addScope("email");
$client->addScope("profile");
?>