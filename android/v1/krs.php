<?php

require_once '../includes/DBOperations.php';
$response = array();
$item = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['npm'])) {

        $db = new DBOperations();
        $krs = $db->krs($_POST['npm']);

        while ($data = mysqli_fetch_array($krs)) {
            $item[] = array(
                'Nama_Mtk' => $data["Nama_Mtk"],
                'Jml_Sks' => $data["Jml_Sks"],
                'Nama_Dosen' => $data["Nama_Dosen"],
            );
        }
        $response = array(
            'error' => false,
            'data' => $item
        );
    } else {
        $response['error'] = true;
        $response['message'] = "File yang harus diisi salah";
    }
}

echo json_encode($response);