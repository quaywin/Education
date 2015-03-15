<?php
$app->get('/account/login', function() use ($app) {
    $app->render('account/login.html');
});
$app->get('/account/signup', function() use ($app) {
    $app->render('account/signup.html');
});
$app->get('/account/profile', function() use ($app) {
    $app->render('account/profile.html');
});
$app->get('/account/auth', function() use ($app) {
    // $app->contentType('application/json');
    echo $app->request()->getPathInfo();
});
$app->post('/account/login', function () use($app) {
    // session_start();
    $app->contentType('application/json');
    // $username = $app->request->post('username');
    $data = json_decode($app->request()->getBody());
    $mObject = new Users();
    $results = $mObject->validSingIn($data->username,$data->password);
    if($results['status'] == true){
        $_SESSION["loggedin"] = $results['data'];
        $_SESSION["type"]= $results['type'];
        $app->setCookie('loggedin', $results['data']);
        // $_SESSION["id"] = $results[0];
    }
    echo json_encode($results);
});
$app->post('/account/signup', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Users();
    $username = $data->username;
    $password = $data->password;
    $firstname = $data->firstname;
    $lastname = $data->lastname;
    $repassword = $data->repassword;
    $valid = $mObject->validSignUp($firstname,$lastname,$username,$password,$repassword);
    if($valid==null){
        $results = $mObject->addNewUser($firstname,$lastname,$username,$password);
        $status = true? $results!=null:false;
        if($status == true){
            $_SESSION["loggedin"] = $results[0];
            $_SESSION["type"]= $results[2];
            $app->setCookie('loggedin', $results[0]);
        }
        $resultsArray=array(
            "status"=> $status
            );
        echo json_encode($resultsArray);
    }else{
        $resultsArray=array(
            "status"=> false,
            "valid"=>(object)$valid
            );
        echo json_encode($resultsArray);
    }
});

$app->post('/account/getTypeUser', function() use($app){
    $app->contentType('application/json');
    $resultsArray=array(
        "status"=> isset($_SESSION['type']),
        "data" => $_SESSION['type']
        );
    echo json_encode($resultsArray);
});
$app->post('/account/getUser', function() use($app){
    $app->contentType('application/json');
    $mObject = new Users();
    $results = $mObject->getUserById($_SESSION['loggedin']);
    $resultsArray=array(
        "status"=> true? $results!=null:false,
        "data" => $results
        );
    echo json_encode($resultsArray);
});
$app->post('/account/getAllUser', function() use($app){
    $app->contentType('application/json');
    $mObject = new Users();
    $results = $mObject->getAllUser();
    $resultsArray=array(
        "status"=> true? $results!=null:false,
        "data" => $results
        );
    echo json_encode($resultsArray);
});
$app->get('/account/logout', function() use($app){
    session_unset();
    session_destroy();
    $app->deleteCookie('loggedin');
    $app->response->redirect('/');
});
$app->post('/account/checkSession', function() use($app){
    $resultsArray=array(
        "status"=> isset($_SESSION['loggedin'])
        );
    echo json_encode($resultsArray);
});

?>
