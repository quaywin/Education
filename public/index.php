<?php

require '../vendor/autoload.php';

// use Illuminate\Database\Capsule\Manager as Capsule;

// $capsule = new Capsule;

// $capsule->addConnection([
//     'driver'    => 'sqlite',
//     // 'host'      => 'localhost',
//     'database'  => 'database.sqlite',
//     'username'  => '',
//     'password'  => '',
//     'charset'   => 'utf8',
//     'collation' => 'utf8_unicode_ci',
//     'prefix'    => '',
// ]);

// // Set the event dispatcher used by Eloquent models... (optional)
// use Illuminate\Events\Dispatcher;
// use Illuminate\Container\Container;
// $capsule->setEventDispatcher(new Dispatcher(new Container));

// // Make this Capsule instance available globally via static methods... (optional)
// $capsule->setAsGlobal();

// // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
// $capsule->bootEloquent();
date_default_timezone_set('Asia/Ho_Chi_Minh');
$app = new \Slim\Slim(array(
    'cookies.encrypt' => true,
    'cookies.lifetime' => '2 days'
));
// $db = new PDO('sqlite:db.sqlite3');
$app->config(array(
    'debug' => false,
    'templates.path' => './views'
));
if (!isset($_SESSION)) {
    session_cache_limiter(false);
    // echo "abc";
    session_start();
    // $_SESSION["loggedin"] = false;
}
class AuthMiddleware extends \Slim\Middleware {

    public function call() {
        $res = $this->app->response();
        $app = $this->app;
        if(!isset($_SESSION['loggedin'])){
            $app->deleteCookie('loggedin');
        }else if(!isset($_COOKIE['loggedin'])){
            $app->setCookie('loggedin',$_SESSION['loggedin']);
        }
        if ($this->checkRequest($app->request()->getPathInfo())){
            if(!isset($_SESSION['loggedin']) || !isset($_COOKIE['loggedin'])){
                $app->render('home/404.html');
            }else{
                if($_SESSION['loggedin'] == $app->getCookie('loggedin')){
                    $this->next->call();  
                }else{
                    $app->render('home/404.html');
                }
                
            }
        }else{
            $this->next->call();
        }        
        // $app->lastModified(time());
        // $app->expires('+30 seconds');
    }
    function checkRequest($path){
        $listUrl = array(
            "/account/login",
            "/account/signup",
            "/home",
            "/",
            "/account/checkSession"
            );
        foreach ($listUrl as $key => $value) {
            if($path==$value){
                return false;
            }
        }
        return true;
    }
}
$app->add(new \AuthMiddleware());

$app->get('/', function() use ($app) {
    if(isset($_SESSION['loggedin'])){
        if($_SESSION['type']==1){
            $app->render('student_index.html');
        }
        if($_SESSION['type']==2){
            $app->render('admin_index.html');
        }
        // $app->render('student_index.html');
    }else{
        $app->render('index.html');
    }
    
});

spl_autoload_register('class_autoloader');
// END POINT: /employees/
include_once "controllers/account.php";
include_once "controllers/admin.php";
include_once "controllers/home.php";


$app->run();
function returnResult($action, $success = true, $id = 0)
{
    echo json_encode([
        'action' => $action,
        'success' => $success,
        'id' => intval($id),
    ]);
}
function class_autoloader($class_name) {
    $fname = strtolower($class_name);

    $possible_locations = array(
        'models/' . $fname . '.php',
        'controllers/' . $fname . '.php',
    );

    foreach ($possible_locations as $loc) {
        if (file_exists($loc)) {
            require_once $loc;
            return TRUE;
        }
    }

    throw new Exception("Class $class_name wasn't found.");
}