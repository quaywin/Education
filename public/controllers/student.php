<?php
$app->get('/student/changepassword', function() use ($app) {
    $app->render('student/change_password.html');
});
$app->get('/student/score', function() use ($app) {
    $app->render('student/score.html');
});
$app->post('/student/updatePassword', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Users();
    $results = $mObject->updatePassword($data->currentpassword,$data->newpassword,$data->confirmpassword,$_SESSION['loggedin']);
    $resultsArray=array(
            "status"=> $results,
            );
    echo json_encode($resultsArray);
});
$app->post('/student/getListScoreByUserId', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Score();
    $results = $mObject->getListScoreByUserId($data->page,$_SESSION['loggedin']);
    $count = $mObject->getCountListScoreByUserId($_SESSION['loggedin']);
    $pages = Model::getPages($count);
    $resultsArray=array(
            "data"=> $results,
            "count"=> $count,
            "pages"=> $pages,
            "pageSize" => Model::$pageSize
            );
    echo json_encode($resultsArray);
});
?>