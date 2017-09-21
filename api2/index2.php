<?php
//include_once("/opt/wheytvcms/mongodb/mongodb_fns.php");
include_once("api_fns.php");
require './vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Add Middleware
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

//Add CORS to response
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/ping', 'ping');
//$app->post('/user/checkpassword', 'userCheckPassword');
$app->post('/user/checkpassword', function ($request, $response, $args) {
    $json = $request->getBody();
	$data = json_decode($json, true); 
	$email = $data['email'];
	$password = $data['password'];
	
	$result = (int)wheytv\mongodb\checkUserPassword($email, $password);
	//echo '{"message": "ok", "email":"'.$email.'", "result":"'.$result.'"}';
	echo wheytv\api\formatCheckPasswordMessage($email, $result);
});

//$app->post('/user/load', 'getUser');
$app->post('/user/load', function ($request, $response, $args) {
    $request = \Slim\Slim::getInstance()->request();
	
	$json = $request->getBody();
	echo $json;
	$data = json_decode($json, true); 
	$email = $data['email'];
	
	$user = json_encode(wheytv\mongodb\getUser($email));
	//echo '{"message": "ok", "user":'.$user.'}';
	echo wheytv\api\formatGetUserMessage($user);
});

$app->run();

function ping()
{
	echo '{"message": "ok"}';
}

/*function getUsers() {
	$sql = "SELECT user_id,username,name,profile_pic FROM users ORDER BY user_id";
	//echo $sql;
	try {
		$db = getDB();
		$stmt = $db->query($sql);  
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"users": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getUserUpdates() {
	$sql = "SELECT A.user_id, A.username, A.name, A.profile_pic, B.update_id, B.user_update, B.created FROM users A, updates B WHERE A.user_id=B.user_id_fk  ORDER BY B.update_id DESC";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql); 
		$stmt->execute();		
		$updates = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"updates": ' . json_encode($updates) . '}';
		
	} catch(PDOException $e) {
	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getUserUpdate($update_id) {
	$sql = "SELECT A.user_id, A.username, A.name, A.profile_pic, B.update_id, B.user_update, B.created FROM users A, updates B WHERE A.user_id=B.user_id_fk AND B.update_id=:update_id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
        $stmt->bindParam("update_id", $update_id);		
		$stmt->execute();		
		$updates = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"updates": ' . json_encode($updates) . '}';
		
	} catch(PDOException $e) {
	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function insertUpdate() {
	
	//echo "insertUpdate";
	$request = \Slim\Slim::getInstance()->request();
	$update = json_decode($request->getBody());
	$sql = "INSERT INTO updates (user_update, user_id_fk, created, ip) VALUES (:user_update, :user_id, :created, :ip)";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("user_update", $update->user_update);
		$stmt->bindParam("user_id", $update->user_id);
		$time=time();
		$stmt->bindParam("created", $time);
		$ip=$_SERVER['REMOTE_ADDR'];
		$stmt->bindParam("ip", $ip);
		$stmt->execute();
		$update->id = $db->lastInsertId();
		$db = null;
		$update_id= $update->id;
		getUserUpdate($update_id);
	} catch(PDOException $e) {
		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function deleteUpdate($update_id) {
   
	$sql = "DELETE FROM updates WHERE update_id=:update_id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("update_id", $update_id);
		$stmt->execute();
		$db = null;
		echo true;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	
}

function getUserSearch($query) {
	$sql = "SELECT user_id,username,name,profile_pic FROM users WHERE UPPER(name) LIKE :query ORDER BY user_id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		$query = "%".$query."%";  
		$stmt->bindParam("query", $query);
		$stmt->execute();
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"users": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}*/
?>