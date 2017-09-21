<?php
/**
 * Access Token functions
 * Author : Eric See
 * 15/12/2016
 */
 
namespace wheytv\accesstoken;
include_once("/opt/wheytvcms/redis/redis_fns.php");
require_once("accesstoken_init.php");
//require_once("accesstokenutils_class.php");

//Generate Access Token
function generateAccessToken()
{
	return uniqid(TOKEN_PREFIX);
}

//insert into redis
function insertAccessTokenIntoRedis($token, $expiry=TOKEN_EXPIRY_TIME)
{
	\wheytv\redis\insertKeyWithExpiry($token, $expiry);
	
}

//check whether access token is valid
function isAccessTokenValid($token)
{
	$exists = \wheytv\redis\isKeyExists($token);
	echo $token.' '.$exists.PHP_EOL;
	return $exists;
}

?>