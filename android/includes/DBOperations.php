<?php 

	class DBOperations{
		private $con;

		function __construct(){
			require_once dirname(__FILE__).'/DBConnect.php';
			$db = new DBConnect();

			$this->con = $db->connect();
			
		}

		// CRUD -> C -> Create
		// function createUser($username, $pass, $email){
		public function createUser($username, $pass,$email){
			if ($this->isUserExist($username,$email)) {
				return 0;
		
			}else{
				$password = md5($pass);
				$stmt = $this->con->prepare("INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES (NULL,?,?,?);");
				$stmt->bind_param("sss", $username, $password, $email);

				if($stmt->execute()){
					return 1;
				}else{
					return 2;
				}

			}
		}

		private function isUserExist($username,$email){
			$stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? OR email =?");
			$stmt->bind_param("ss",$username,$email);
			$stmt->execute();
			$stmt-> store_result();
			return $stmt->num_rows > 0;
		}

		public function userlogin($username,$pass){
			$password = md5($pass);
			$stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? OR password =?");
			$stmt->bind_param("ss",$username,$password);
			$stmt->execute();
			$stmt-> store_result();
			return $stmt->num_rows > 0;
		}

		public function getUserByUsername($username){
			$stmt = $this->con->prepare("SELECT * FROM users WHERE username = ?");
			$stmt->bind_param("s",$username);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}

		public function jadwal($npm,$hari){

			$stmt = $this->con->prepare("SELECT a.Kd_Jadwal, b.Nama_Mtk, b.Jml_Sks, a.Jam_Mulai, a.Jam_selesai, a.Hari, c.Nama_Dosen FROM jadwal a LEFT JOIN matakuliah b on b.Kd_Mtk = a.Kd_Mtk LEFT JOIN dosen c ON c.Kd_Dosen = a.Kd_DosenPengampu LEFT JOIN krs d ON d.Kd_Jadwal = a.Kd_Jadwal WHERE a.Status = 'A' AND d.Npm = ? AND a.Hari = ? ORDER BY a.Hari DESC, a.Jam_Mulai DESC;");
			$stmt->bind_param("ss",$npm,$hari);
			$stmt->execute();
			return $stmt->get_result();
		}

		public function krs($npm) {
        $stmt = $this->con->prepare("SELECT a.Kode_Krs, b.Nama_Mtk, b.Jml_Sks,  c.Nama_Dosen 
        FROM krs a 
        LEFT JOIN matakuliah b on b.Kd_Mtk = a.Kd_Mtk 
        LEFT JOIN dosen c ON c.Kd_Dosen = a.Kd_DosenPengampu 
        WHERE a.Npm = ? ");
        $stmt->bind_param("s", $npm);
        $stmt->execute();
        return $stmt->get_result();
    	}

		public function profilMhs($npm) { 
        $stmt = $this->con->prepare("SELECT Nama_Mhs, Semester, Nama_Prodi, Jenjang  
        FROM mahasiswa a LEFT JOIN prodi b on b.Kd_Prodi = a.Kd_Prodi  
        WHERE a.Npm = ? AND a.Status = 'A' "); 
        $stmt->bind_param("s", $npm); 
        $stmt->execute(); 
        return $stmt->get_result(); 
    	}

    	public function ukt($npm) { 
        $stmt = $this->con->prepare("SELECT Jenjang, Nama_Prodi, UKT  
		FROM mahasiswa a 
		LEFT JOIN prodi b on b.Status = a.Status  
		WHERE a.Npm = ? AND a.Status = 'A' "); 
        $stmt->bind_param("s", $npm); 
        $stmt->execute(); 
        return $stmt->get_result(); 
    	}
}