<?php
/**
 * API functions
 * Author : Eric See
 * 2/12/2016
 */
 
namespace wheytv\api;

function formatCheckPasswordMessage($email, $user)
{
	return '{"message": "ok", "email":"'.$email.'", "first-name":"'.$user['first-name'].'", "last-name":"'.$user['last-name'].'", "result":"'.$user.'"}';
}

function formatGetUserMessage($user)
{
	echo '{"message": "ok", "user":'.$user.'}';
}
?>