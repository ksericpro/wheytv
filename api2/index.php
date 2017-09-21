<?php
include_once("/opt/wheytvcms/mongodb/mongodb_fns.php");
//include_once("/opt/wheytvcms/redis/redis_fns.php");
require './vendor/autoload.php';
include_once("api_fns.php");
require('accesstoken_fns.php');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
//echo "index.php";
$app = new \Slim\App;

//Add Middleware
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

//Test Hello
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

//ping
$app->get('/ping', 'ping');
$app->get('/accesstoken', 'accesstoken');

//Add CORS to response
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

//check password
$app->post('/user/checkpassword', function ($request, $response, $args) {
    $json = $request->getBody();
	$data = json_decode($json, true); 
	$email = $data['email'];
	$password = $data['password'];
	
	$user = wheytv\mongodb\checkUserPassword($email, $password);
	//echo '{"message": "ok", "email":"'.$email.'", "result":"'.$result.'"}';
	//$result = "dsd";
	echo \wheytv\api\formatCheckPasswordMessage($email, $user);
});

//load user
$app->post('/user/load', function ($request, $response, $args) {
	$json = $request->getBody();
	//echo $json;
	$data = json_decode($json, true); 
	$email = $data['email'];
	
	$user = json_encode(wheytv\mongodb\getUser($email));
	//echo '{"message": "ok", "user":'.$user.'}';
	echo \wheytv\api\formatGetUserMessage($user);
});

//save user
$app->post('/user/save', function ($request, $response, $args) {
	$json = $request->getBody();
	//echo $json;
	$data = json_decode($json, true); 
	$email = $data['email'];
	$firstname = $data['firstname'];
	$lastname = $data['lastname'];
	$displayname = $data['displayname'];
	$task = $data['task'];
	$guildname = $data['guildname'];
	$profile_image = $data['profile_img'];
	$password = $data['password'];
	$facebook_login = $data['facebook_login'];
	
	//Query User using email
	$user = \wheytv\mongodb\getUser($email);
	
	//Create Document
	$document = array(
		"first-name" => $firstname , 
		"last-name" => $lastname, 
		"email" => $email, 
		"password" => $password, 
		"display-name" => $displayname,
		"facebook_login" => $facebook_login,
		"guildname"=>$guildname,
		"profile_image"=>$profile_image	
	);
		
	if ($user) {
		//Update User
		\wheytv\mongodb\updateUser($email, $document);
		echo '{"message":"found", "email":"'.$email.'", "task":"UPDATE"}';		
	}
	else {	
		//Insert User
		\wheytv\mongodb\insertUser($document);	
		echo '{"message":"found", "email":"'.$email.'", "task":"INSERT"}';	
	}
});

$app->run();

function ping()
{
	echo '{"message": "ok"}';
}

//Get AccessToken
function accesstoken()
{
	//$mgr = wheytv\accesstoken\AccessToken_Utils::getInstance();
	$token = \wheytv\accesstoken\generateAccessToken();
	//return $token;
	\wheytv\accesstoken\insertAccessTokenIntoRedis($token, 60);
	
	//isKeyExists($key)
	\wheytv\accesstoken\isAccessTokenValid('wheytv_5852e008dda8e');
	
	echo '{"session": "ok", "accesstoken":"'.$token.'"}';
}

?>