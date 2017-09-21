<?php
/**
 * Access Token Class
 * Author : Eric See
 * 16/12/2016
 */
namespace wheytv\accesstoken;

class AccessToken_Utils { 
	protected static $_instance = null;
	
	//call this method to get instance
	public static function getInstance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	//constructor
	function __construct() 
    { 
       //print "__construct Session Utils".PHP_EOL; 
    }
	
	//protected to prevent clonning 
	protected function __clone(){
	}

	//destructor
	function __destruct() {
       //print "__destruct Session Utils".PHP_EOL;
    }
	
	//Generate Access Token
	function generateAccessToken()
	{
		return uniqid('wheytv_');
	}
	
	//insert token with expiry into redis
	function insertAccessTokenIntoRedis($token, $expiry=10)
	{
		
	}
}
?>