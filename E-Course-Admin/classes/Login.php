<?php
require_once '../config.php';

class Login extends DBConnection
{
	private $settings;

	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
		ini_set('display_errors', 1);
	}

	// public function login()
	// {
	// 	extract($_POST);

	// 	// Use prepared statements to prevent SQL injection
	// 	$stmt = $this->conn->prepare("SELECT * FROM employees WHERE email = ? AND password = ?");
	// 	$stmt->bind_param("ss", $email, $password);
	// 	$stmt->execute();
	// 	$result = $stmt->get_result();

	// 	if ($result->num_rows > 0) {
	// 		$user = $result->fetch_assoc();

	// 		// Set user data in session
	// 		foreach ($user as $key => $value) {
	// 			if (!is_numeric($key) && $key !== 'password') {
	// 				$this->settings->set_userdata($key, $value);
	// 			}
	// 		}

	// 		$this->settings->set_userdata('login_type', 1);
	// 		return json_encode(array('status' => 'success'));
	// 	} else {
	// 		return json_encode(array('status' => 'incorrect'));
	// 	}
	// }

	public function login(){
		extract($_POST);

		$qry = $this->conn->query("SELECT * from employees where email = '$email' and password = '$password' ");
		if($qry->num_rows > 0){
			foreach($qry->fetch_array() as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}

			}
			$this->settings->set_userdata('login_type',1);
		return json_encode(array('status'=>'success'));
		}else{
		return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT * from employees where email = '$email' and password = '$password' "));
		}
	}
	
	public function logout()
	{
		if ($this->settings->sess_des()) {
			redirect('admin/login.php');
		}
	}
}

$action = isset($_GET['f']) ? strtolower($_GET['f']) : 'none';
$auth = new Login();

switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	default:
		echo "<h1>Access Denied</h1> <a href='" . base_url . "'>Go Back.</a>";
		break;
}
