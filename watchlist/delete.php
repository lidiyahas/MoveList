<?php
require '../config/db.php';

$watchlist->deleteOne([
    "_id" => new MongoDB\BSON\ObjectId($_GET['id'])
]);

header("Location: index.php");