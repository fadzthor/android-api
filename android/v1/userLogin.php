<?php

require_once '../includes/DBOperations.php';
$response = array();
if ($_SERVER['REQUEST_METHOD']=='POST') {
	if (isset($_POST['username']) and isset($_POST['password'])) {
		$db = new DBOperations();

		if ($db->userlogin($_POST['username'], $_POST['password'])) {
			$user = $db->getUserByUsername($_POST['username']);
			$response['error'] = false;
			$response['id'] = $user['id'];
			$response['email'] = $user['email'];
			$response['username'] = $user['username'];
		}else{
			$response['error'] = true;
			$response['message'] = "username dan password salah";
		}
	}else{
		$response['error'] = true;
		$response['message'] = "file yang harus diisi salah";
	}
}
echo json_encode($response);