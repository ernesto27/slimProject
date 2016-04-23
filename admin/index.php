<?php 
require '../vendor/autoload.php';

use Illuminate\Filesystem\Filesystem;
use Illuminate\Container\Container;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory;

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


// Laravel validation
$loader = new FileLoader(new Filesystem, '../lang');
$translator = new Translator($loader, 'en');
$validation = new Factory($translator, new Container);

$validation->extend('string_accents', function($attribute, $value, $parameters, $validator) {
    return preg_match('/^([A-Za-záéíóúàèìòù\s]+)$/', $value);
});


// Controllers
require_once '../controllers/admin/UserController.php';
$userController = new UserController($app);

$app->get('/', function () use($app) {
	$app->render('layout.html');
});

$app->get('/login', function () use($app) {
	$app->render('login.html');
});

$app->get('/form', function () use($app) {
	$app->render('form.html');
});

$app->post('/form', function () use($app, $userController, $validation) {
	$login = $userController->login($app->request->post(), $validation);
	// check valid form data
	if($login["status"] == "error"){
		$app->render("form.html", array("errors" => $login["errors"]));
		return;
	}
	// Check db error
	if($login["status"] == "errorDB"){
		$app->flashNow('messsage', 'Error on saved!');
	}else{
		$app->flashNow('messsage', 'Saved success!');
	}

	$app->render("form.html", array("errors" => null));
});


$app->run();

?>