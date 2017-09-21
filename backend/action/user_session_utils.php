<?php
	if(isset($_POST['mydata'])){
		$json = json_decode($_POST['mydata']); 
		$task = $json->task;
		//echo '{"Step2":"ok", "task":"'.$task.'"}';
		session_start();
		
		if($task=="LOGIN_STATUS")
		{
			//echo '{"task":"'.$_SESSION['firstname'].'"}';
			if(isset($_SESSION['firstname']))
			{
				//echo '{"task":"'.$_SESSION['firstname'].'"}';
				echo '{"result":"1", "task":"'.$task.'","firstname":"'.$_SESSION['firstname'].'","lastname":"'.$_SESSION['lastname'].'","displayname":"'.$_SESSION['displayname'].'"}';
			}
			else {
				echo '{"result":"0", "task":"'.$task.'"}';
			}
		}
		else if($task=="LOGOUT_CLEARSESSION")
		{
			session_unset();
			echo '{"result":"1", "task":"'.$task.'"}';
		}
		else if($task=="LOGIN_SETSESSION")
		{
			$firstname = $json->firstname;
			$lastname = $json->lastname;
			$displayname = $json->displayname;
			
			$_SESSION['firstname'] = $firstname;
			$_SESSION['lastname'] = $lastname;
			$_SESSION['displayname'] = $displayname;
			echo '{"result":"1", "task":"'.$task.'","firstname":"'.$_SESSION['firstname'].'","lastname":"'.$_SESSION['lastname'].'","displayname":"'.$_SESSION['displayname'].'"}';
			//echo '{"result":"1", "task":"'.$task.'"}';
		}
		//echo '{"result":"1", "task":"'.$task.'"}';
	}
	else
	{
		echo '{"result":"0", "result":"task unknown"}';
	}
?>