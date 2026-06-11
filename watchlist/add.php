<?php
session_start();
require '../config/db.php';

$data = [
    "user" => $_SESSION['user'],
    "title" => $_GET['title'],
    "imdbID" => $_GET['id'],
    "poster" => $_GET['poster']
];

$watchlist->insertOne($data);

header("Location: index.php");