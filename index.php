<?php 
require 'vendor/autoload.php';

$app = new \Slim\Slim();
$twigView = new \Slim\Views\Twig();

$app->config(array(
	"debug" => true,
	"mode" => 'development',
	'view' => $twigView,
	'templates.path' => 'templates/website'
));
$app->setName("websiteSection");

$app->get('/', function () use($app) {
	$app->render('index.html');
});


$app->run();

?>