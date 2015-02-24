<?php
$app->get('/home', function() use ($app) {
    $app->render('home/home.html');
});

$app->get('/home/404', function() use ($app) {
    $app->render('home/404.html');
});
$app->get('/home/session', function() use ($app) {
    // $app->render('home/404.html');
    echo $_SESSION['loggedin'];
});