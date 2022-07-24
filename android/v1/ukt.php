<?php

require_once '../includes/DBOperations.php';
$response = array();
$item = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['npm'])) {

        $db = new DBOperations();
        $ukt = $db->ukt($_POST['npm']);

        while ($data = mysqli_fetch_array($ukt)) {
            $item[] = array(
                'Jenjang' => $data["Jenjang"],
                'Nama_Prodi' => $data["Nama_Prodi"],
                'UKT' => $data["UKT"],
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