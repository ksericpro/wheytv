<?php
    include_once '../common/curl_request.php';
	if(isset($_POST['useremail']) && !empty($_POST)){
	  $url=generateAPIURL("user/checkpassword");
	  $email = $_POST['useremail'];
	  $password = $_POST['userpassword'];
	  $data = array(
		"email"=>$email,
		"password"=>$password
	  );
	  $str_data = json_encode($data);
	  $result = executeCurl($url, 'POST', $str_data);
	  $fetch = json_decode($result);
	  if($fetch->result==1){
			session_start();
			$_SESSION['firstname'] = $fetch->firstname;
			$_SESSION['lastname'] = $fetch->lastname;
			$_SESSION['displayname'] = $fetch->displayname;
	   }
	   echo $result;
	}
?>