<?php

require_once __DIR__ . '/vendor/autoload.php';

define('SALT', '1fJxj0yZigmMNCAq');
define('DEBUG', false);
define('VALID_TIME_TOKEN', 2);

/* ------------------------------------------------- *\
    Request
\* ------------------------------------------------- */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = strtolower($_SERVER["REQUEST_METHOD"]);


/* ------------------------------------------------- *\
    Helpers
\* ------------------------------------------------- */

function view($path, array $data, $status='200 Ok')
{
    $fileName = __DIR__.'/ressources/views/'. str_replace('.', '/', $path). '.php';

    if(!file_exists($fileName)) die(sprintf('this file doesn\'t exists %S', $fileName));

    header("HTTP/1.1 $status");
    header('Content-type: text/html; charset=UTF-8');

    extract($data);
    include $fileName;
}

function url($path='', $params='') {
    if(!empty($params)) $params="/$params";
    return 'http://localhost:8000/'.$path.$params;
}
// url('product', 1);

function token()
{
    $token = md5(date('Y-m-d h:i:00') . SALT);
    return '<input type="hidden" name="_token" value="' . $token . '">';
}
function checked_token($token)
{
    if (!empty($token)) {
        foreach (range(0, VALID_TIME_TOKEN) as $v) {
            if (($token == md5(date('Y-m-d h:i:00', time() - $v * 60) . SALT))) {
                return true;
            }
        }
        return false;
    }
    throw new RuntimeException('no _token checked');
}


/* ------------------------------------------------- *\
    Connect Database
\* ------------------------------------------------- */

\Connect::set([
    'dsn' => 'mysql:host=localhost;dbname=db_starwars',
    'username' => 'root',
    'password' => ''
]);

/* ------------------------------------------------- *\
    Controllers
\* ------------------------------------------------- */

use Controllers\FrontController;

/* ------------------------------------------------- *\
    Router
\* ------------------------------------------------- */

if($method=='get')
{
    switch($uri)
    {
        case "/":

           //echo "page d'accueil";

           $frontController = new FrontController();
           $frontController->index();

           break;


        // /casque/1 ou laser/2 ou laser/1 ...
        case preg_match('/product\/([1-9][0_9]*)/', $uri, $m) == 1:

            $front = new Controllers\FrontController();
            $front->show($m[1]);

            break;

        case "/cart":

            $frontController = new FrontController();
            $frontController->showCart();
            break;

        case preg_match('/\/category\/([1-9][0-9]*)/', $uri, $m) == 1:

            $frontController = new Controllers\FrontController;
            $frontController->showCategory($m[1]);

            break;

        default:
            $message = 'Not Found !';
            view('front.404', compact('message'), '404 Not Found');

    }
}

if($method=='post'){
    switch($uri){
        case '/command' :

            $frontController = new FrontController();
            $frontController->command();

            break;

        case '/store' :

            $frontController = new FrontController();
            $frontController->store();

            break;
    }
}