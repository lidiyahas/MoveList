<?php
session_start();
require '../config/db.php';
require '../config/google.php';

// kalau ada code dari Google (callback)
if(isset($_GET['code'])){

    // ambil token
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    // cek error token
    if(isset($token['error'])){
        echo "Login Google gagal!";
        exit;
    }

    $client->setAccessToken($token);

    // ambil data user
    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get();
    $name = $userInfo->name;

    $email = $userInfo->email;

    // cek user di MongoDB
    $user = $users->findOne(["email" => $email]);

    // kalau belum ada → insert
    if(!$user){
        $users->insertOne([
            "username" => $name,
            "email" => $email,
            "google" => true
        ]);
    }

    // set session
    $_SESSION['user'] = $email;
    $_SESSION['username'] = $name;

    // redirect ke dashboard
    header("Location: ../watchlist/index.php");
    exit;

} else {

    // arahkan ke Google login
    $login_url = $client->createAuthUrl();
    header("Location: $login_url");
    exit;
}
?>