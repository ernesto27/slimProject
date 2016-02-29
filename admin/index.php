<?php 
require '../vendor/autoload.php';

$app = new \Slim\Slim();
$twigView = new \Slim\Views\Twig();

$app->config(array(
	"debug" => true,
	"mode" => 'development',
	'view' => $twigView,
	'templates.path' => '../templates/admin'
));
$app->setName("sectionAdmin");
$app->add(new Slim\Middleware\SessionCookie(array(
	'expires' => '2 days',
)));

$app->get('/', function () use($app) {
	$app->render('layout.html');
});

$app->get('/login', function () use($app) {
	$app->render('login.html');
});


$app->run();

?>