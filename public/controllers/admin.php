<?php
$app->post('/admin/getListClass', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Classes();
    $results = $mObject->getListClass($data->page);
    $count = $mObject->getCountListClass();
    $pages = Model::getPages($count);
    $resultsArray=array(
            "data"=> $results,
            "count"=> $count,
            "pages"=> $pages,
            "pageSize" => Model::$pageSize
            );
    echo json_encode($resultsArray);
});
$app->post('/admin/addNewClass', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Classes();
    $results = $mObject->addNewClass($data->name);
    $resultsArray=array(
            "status"=> $results,
            );
    echo json_encode($resultsArray);
});
$app->post('/admin/deleteClass', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Classes();
    $results = $mObject->deleteClass($data->id);
    $resultsArray=array(
            "status"=> $results,
            );
    echo json_encode($resultsArray);
});
$app->post('/admin/getListTeacher', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Teacher();
    $results = $mObject->getListTeacher($data->page);
    $count = $mObject->getCountListTeacher();
    $pages = Model::getPages($count);
    $resultsArray=array(
            "data"=> $results,
            "count"=> $count,
            "pages"=> $pages,
            "pageSize" => Model::$pageSize
            );
    echo json_encode($resultsArray);
});
$app->post('/admin/addNewTeacher', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Teacher();
    $results = $mObject->addNewTeacher($data->name);
    $resultsArray=array(
            "status"=> $results,
            );
    echo json_encode($resultsArray);
});
$app->post('/admin/deleteTeacher', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Teacher();
    $results = $mObject->deleteTeacher($data->id);
    $resultsArray=array(
            "status"=> $results,
            );
    echo json_encode($resultsArray);
});
$app->post('/admin/getListSubject', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Subject();
    $results = $mObject->getListSubject($data->page);
    $count = $mObject->getCountListSubject();
    $pages = Model::getPages($count);
    $resultsArray=array(
            "data"=> $results,
            "count"=> $count,
            "pages"=> $pages,
            "pageSize" => Model::$pageSize
            );
    echo json_encode($resultsArray);
});
$app->post('/admin/addNewSubject', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Subject();
    $results = $mObject->addNewSubject($data->name,$data->code);
    $resultsArray=array(
            "status"=> $results,
            );
    echo json_encode($resultsArray);
});
$app->post('/admin/deleteSubject', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Subject();
    $results = $mObject->deleteSubject($data->id);
    $resultsArray=array(
            "status"=> $results,
            );
    echo json_encode($resultsArray);
});
$app->post('/admin/getListRole', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Role();
    $results = $mObject->getListRole($data->page);
    $count = $mObject->getCountListRole();
    $pages = Model::getPages($count);
    $resultsArray=array(
            "data"=> $results,
            "count"=> $count,
            "pages"=> $pages,
            "pageSize" => Model::$pageSize
            );
    echo json_encode($resultsArray);
});
$app->post('/admin/getAllListTeacherSubjectClass', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $class = new Classes();
    $teacher = new Teacher();
    $subject = new Subject();
    $listClass = $class->getAllListClass();
    $listTeacher = $teacher->getAllListTeacher();
    $listSubject = $subject->getAllListSubject();
    $resultsArray=array(
            "class"=> $listClass,
            "subject"=> $listSubject,
            "teacher"=> $listTeacher,
            );
    echo json_encode($resultsArray);
});
$app->post('/admin/addNewRole', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Role();
    $results = $mObject->addNewRole($data->teacherid,$data->subjectid,$data->classid);
    $resultsArray=array(
            "status"=> $results,
            );
    echo json_encode($resultsArray);
});
$app->post('/admin/deleteRole', function () use($app) {
    $app->contentType('application/json');
    $data = json_decode($app->request()->getBody());
    $mObject = new Role();
    $results = $mObject->deleteRole($data->id);
    $resultsArray=array(
            "status"=> $results,
            );
    echo json_encode($resultsArray);
});

$app->get('/admin/student', function() use ($app) {
    $app->render('admin/student.html');
});
$app->get('/admin/subject', function() use ($app) {
    $app->render('admin/subject.html');
});
$app->get('/admin/class', function() use ($app) {
    $app->render('admin/class.html');
});
$app->get('/admin/teacher', function() use ($app) {
    $app->render('admin/teacher.html');
});
$app->get('/admin/role', function() use ($app) {
    $app->render('admin/role.html');
});
$app->get('/admin/score', function() use ($app) {
    $app->render('admin/score.html');
});
?>