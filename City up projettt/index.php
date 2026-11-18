<?php
declare(strict_types=1);
session_start();require __DIR__.'/app/helpers.php';
require __DIR__.'/app/Controllers/Controller.php';require __DIR__.'/app/Controllers/HomeController.php';
require __DIR__.'/app/Models/Review.php';require __DIR__.'/app/Controllers/ReviewController.php';
$routes=require __DIR__.'/app/routes.php';$page=(string)($_GET['page']??'home');
if(!isset($routes[$page])){http_response_code(404);echo '404 | Page not found';exit;}
if(in_array($page,['review-save','review-delete','review-moderate','target-add'],true)&&$_SERVER['REQUEST_METHOD']!=='POST'){
 http_response_code(405);header('Allow: POST');exit('Method not allowed');
}
[$class,$method]=$routes[$page];(new $class())->$method();
