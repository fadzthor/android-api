<?php

require_once '../includes/DBOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD']== 'POST'){
	if(isset($_POST['username']) and
			isset($_POST['password']) and
				isset($_POST['email']) 
){
	$db = new DBOperations();

	$result = $db->createUser( $_POST['username'],
								$_POST['password'],
								$_POST['email']);

	if($result == 1){
		$response['error'] = false;
		$response['message'] = "Register User Sukses";
	}elseif ($result == 2) {
		$response['error'] = true;
		$response['message'] = "Ada yang error, Coba lagi";
	}elseif ($result == 0){
		$response['error'] = true;
		$response['message'] = "Anda sudah Registrasi, silahkan Registrasi dengan npm atau email yang lain";
	}


	}else{
		$response['error'] = true;
		$response['message'] = "file yang harus diisi salah";
	}
	}else{
		$response['error'] = true;
		$response['message'] = "Permintaan tidak valid";
	
	}
	echo json_encode($response);