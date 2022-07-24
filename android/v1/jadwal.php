<?php

require_once '../includes/DBOperations.php';
$response = array();
$item = array();

if ($_SERVER['REQUEST_METHOD']=='POST') {
	if (isset($_POST['npm']) and isset($_POST['hari'])) {

		$db = new DBOperations();

		$jadwal = $db->jadwal($_POST['npm'], $_POST['hari']);

		while ($data = mysqli_fetch_array($jadwal)) {
			$item[] = array(
				'Kd_Jadwal' => $data["Kd_Jadwal"],
				'Nama_Mtk' => $data["Nama_Mtk"],
				'Jml_Sks' => $data["Jml_Sks"],
				'Jam_Mulai' => $data["Jam_Mulai"],
				'Jam_selesai' => $data["Jam_selesai"],
				'Hari' => $data["Hari"],
				'Nama_Dosen' => $data["Nama_Dosen"],
			);
		}

		$response = array(
			'error' => false,
			'data' => $item
			);

	}else{
		$response['error'] = true;
		$response['message'] = "file yang harus diisi salah";
	}
}

echo json_encode($response);