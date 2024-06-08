<?php
require_once('../config.php');
class Users extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function save_users()
	{
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
		} else {
			return 5; // Missing ID
		}

		extract($_POST);

		// Sanitize user input
		$name = $this->conn->real_escape_string($name);
		$email = $this->conn->real_escape_string($email);
		$phone = $this->conn->real_escape_string($phone);
		$address = $this->conn->real_escape_string($address);
		$job_position_id = isset($_POST['job_position_id']) ? intval($_POST['job_position_id']) : null;

		// Check if email already exists
		$chk = $this->conn->query("SELECT * FROM `employees` WHERE email = '{$email}' " . ($id > 0 ? " AND employee_id != '{$id}' " : ""))->num_rows;
		if ($chk > 0) {
			return 3; // Email already exists
		}

		// Prepare data for SQL query
		$data = "name = '{$name}', email = '{$email}', phone = '{$phone}', address = '{$address}'";
		if (!empty($password)) {
			$password = md5($password);
			$data .= ", password = '{$password}'";
		}
		if (!is_null($job_position_id)) {
			$data .= ", job_position_id = '{$job_position_id}'";
		}

		// Handle file upload
		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = 'uploads/' . strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../' . $fname);
			if ($move) {
				$data .= ", avatar = '{$fname}'";
				// Delete old avatar if exists
				if (!empty($id) && isset($_SESSION['userdata']['avatar']) && is_file('../' . $_SESSION['userdata']['avatar']) && $_SESSION['userdata']['id'] == $id) {
					unlink('../' . $_SESSION['userdata']['avatar']);
				}
			} else {
				return 6; // Error uploading file
			}
		}

		// Execute SQL query
		if (empty($id)) {
			$qry = $this->conn->query("INSERT INTO employees SET {$data}");
		} else {
			$qry = $this->conn->query("UPDATE employees SET {$data} WHERE employee_id = {$id}");
		}

		if ($qry) {
			if (empty($id)) {
				$this->settings->set_flashdata('success', 'User details successfully saved.');
			} else {
				$this->settings->set_flashdata('success', 'User details successfully updated.');
			}
			// Update session data
			foreach ($_POST as $k => $v) {
				if ($k != 'id') {
					$this->settings->set_userdata($k, $v);
				}
			}
			if (isset($fname) && isset($move)) {
				$this->settings->set_userdata('avatar', $fname);
			}
			return 1; // Success
		} else {
			if (empty($id)) {
				return 2; // Error saving user details
			} else {
				return 4; // Error updating user details
			}
		}
	}
	public function delete_users()
	{
		extract($_POST);
		$qry = $this->conn->query("DELETE FROM employees WHERE employee_id = $id");
		if ($qry) {
			$this->settings->set_flashdata('success', 'User Details successfully deleted.');
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
		}
		echo json_encode($resp);
	}


	public function save_fusers()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'password'))) {
				if (!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}

		if (!empty($password))
			$data .= ", `password` = '" . md5($password) . "' ";

		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = 'uploads/' . strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../' . $fname);
			if ($move) {
				$data .= " , avatar = '{$fname}' ";
				if (isset($_SESSION['userdata']['avatar']) && is_file('../' . $_SESSION['userdata']['avatar']))
					unlink('../' . $_SESSION['userdata']['avatar']);
			}
		}
		$sql = "UPDATE faculty set {$data} where id = $id";
		$save = $this->conn->query($sql);

		if ($save) {
			$this->settings->set_flashdata('success', 'User Details successfully updated.');
			foreach ($_POST as $k => $v) {
				if (!in_array($k, array('id', 'password'))) {
					if (!empty($data)) $data .= " , ";
					$this->settings->set_userdata($k, $v);
				}
			}
			if (isset($fname) && isset($move))
				$this->settings->set_userdata('avatar', $fname);
			return 1;
		} else {
			$resp['error'] = $sql;
			return json_encode($resp);
		}
	}

	public function save_susers()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'password'))) {
				if (!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}

		if (!empty($password))
			$data .= ", `password` = '" . md5($password) . "' ";

		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = 'uploads/' . strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], '../' . $fname);
			if ($move) {
				$data .= " , avatar = '{$fname}' ";
				if (isset($_SESSION['userdata']['avatar']) && is_file('../' . $_SESSION['userdata']['avatar']))
					unlink('../' . $_SESSION['userdata']['avatar']);
			}
		}
		$sql = "UPDATE students set {$data} where id = $id";
		$save = $this->conn->query($sql);

		if ($save) {
			$this->settings->set_flashdata('success', 'User Details successfully updated.');
			foreach ($_POST as $k => $v) {
				if (!in_array($k, array('id', 'password'))) {
					if (!empty($data)) $data .= " , ";
					$this->settings->set_userdata($k, $v);
				}
			}
			if (isset($fname) && isset($move))
				$this->settings->set_userdata('avatar', $fname);
			return 1;
		} else {
			$resp['error'] = $sql;
			return json_encode($resp);
		}
	}
}

$users = new users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $users->save_users();
		break;
	case 'fsave':
		echo $users->save_fusers();
		break;
	case 'ssave':
		echo $users->save_susers();
		break;
	case 'delete':
		echo $users->delete_users();
		break;
	default:
		// echo $sysset->index();
		break;
}
