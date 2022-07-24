<?php 
 
require_once '../includes/DBOperations.php'; 
$response = array(); 
$item = array(); 
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    if (isset($_POST['npm'])) { 
 
        $db = new DBOperations(); 
        $mahasiswa = $db->profilMhs($_POST['npm']); 
 
        while ($data = mysqli_fetch_array($mahasiswa)) { 
            $item[] = array( 
                'Nama_Mhs' => $data["Nama_Mhs"], 
                'Semester' => $data["Semester"], 
                'Nama_Prodi' => $data["Nama_Prodi"], 
                'Jenjang' => $data["Jenjang"], 
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