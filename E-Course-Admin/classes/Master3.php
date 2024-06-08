<?php
require_once('../config.php');
class Master extends DBConnection
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
	function capture_err()
	{
		if (!$this->conn->error)
			return false;
		else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_supplier()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				$v = addslashes(trim($v));
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `vendor` where `vendor_name` = '{$name}' " . (!empty($id) ? " and vendor_id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Supplier already exist.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `vendor` set {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `vendor` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Supplier successfully saved.");
			else
				$this->settings->set_flashdata('success', "Supplier successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_supplier()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `supplier_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Supplier successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_item()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (isset($_POST['description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `description`='" . addslashes(htmlentities($description)) . "' ";
		}
		$check = $this->conn->query("SELECT * FROM `item_list` where `name` = '{$name}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Item Name already exist.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `item_list` set {$data} ";
		} else {
			$sql = "UPDATE `item_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New item successfully saved.");
			else
				$this->settings->set_flashdata('success', "item successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_item()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `item_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "item successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function search_items()
	{
		extract($_POST);
		$qry = $this->conn->query("SELECT * FROM item_list where `name` LIKE '%{$q}%'");
		$data = array();
		while ($row = $qry->fetch_assoc()) {
			$data[] = array("label" => $row['name'], "id" => $row['id'], "description" => $row['description']);
		}
		return json_encode($data);
	}

	function save_po()
	{
		extract($_POST);
		$data = "";

		// Debug: Log form data
		error_log("Form Data: " . print_r($_POST, true));

		// Prepare the data for SQL query
		$fields = array();
		$values = array();
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('po_id', 'item_id', 'vendor_id', 'material_id', 'quantity', 'price', 'status')) && !is_array($v)) {
				$fields[] = $k;
				$values[] = $this->conn->real_escape_string(trim($v));
			}
		}

		// Construct SQL query based on whether it's an INSERT or UPDATE operation
		if (empty($id)) {
			$sql = "INSERT INTO `purchase_order` (`" . implode('`, `', $fields) . "`, `date_created`) VALUES ('" . implode("', '", $values) . "', CURRENT_TIMESTAMP)";
		} else {
			$update_data = array();
			foreach ($fields as $index => $field) {
				$update_data[] = "`{$field}`='{$values[$index]}'";
			}
			$sql = "UPDATE `purchase_order` SET " . implode(', ', $update_data) . " WHERE po_id = '{$id}'";
		}

		// Debug: Log SQL query
		error_log("SQL Query: " . $sql);

		// Execute the SQL query
		$save = $this->conn->query($sql);

		// Check if the query executed successfully
		if ($save) {
			// If successful, set success status and handle insertion/updation of order items
			$resp['status'] = 'success';
			$order_id = empty($id) ? $this->conn->insert_id : $id;
			$resp['id'] = $order_id;

			// Set flash message for success
			if (empty($id)) {
				$this->settings->set_flashdata('success', "Purchase Order successfully saved.");
			} else {
				$this->settings->set_flashdata('success', "Purchase Order successfully updated.");
			}
		} else {
			// Set error message if query execution failed
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . " [{$sql}]";
			// Debug: Log error message
			error_log("SQL Error: " . $this->conn->error . " [{$sql}]");
		}

		// Return JSON response
		echo json_encode($resp);
	}





	function delete_po()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `purchase_order` where po_id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Purchase Order successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function get_price()
	{
		extract($_POST);
		$qry = $this->conn->query("SELECT * FROM price_list where unit_id = '{$unit_id}'");
		$this->capture_err();
		if ($qry->num_rows > 0) {
			$res = $qry->fetch_array();
			switch ($rent_type) {
				case '1':
					$resp['price'] = $res['monthly'];
					break;
				case '2':
					$resp['price'] = $res['quarterly'];
					break;
				case '3':
					$resp['price'] = $res['annually'];
					break;
			}
		} else {
			$resp['price'] = "0";
		}
		return json_encode($resp);
	}
	function save_rent()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_array($_POST[$k])) {
				if (!empty($data)) $data .= ",";
				$v = addslashes($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		switch ($rent_type) {
			case 1:
				$data .= ", `date_end`='" . date("Y-m-d", strtotime($date_rented . ' +1 month')) . "' ";
				break;

			case 2:
				$data .= ", `date_end`='" . date("Y-m-d", strtotime($date_rented . ' +3 month')) . "' ";
				break;
			case 3:
				$data .= ", `date_end`='" . date("Y-m-d", strtotime($date_rented . ' +1 year')) . "' ";
				break;
			default:
				# code...
				break;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `rent_list` set {$data} ";
		} else {
			$sql = "UPDATE `rent_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Rent successfully saved.");
			else
				$this->settings->set_flashdata('success', "Rent successfully updated.");
			$this->settings->conn->query("UPDATE `unit_list` set `status` = '{$status}' where id = '{$unit_id}'");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_rent()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `rent_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Rent successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_img()
	{
		extract($_POST);
		if (is_file($path)) {
			if (unlink($path)) {
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete ' . $path;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown ' . $path . ' path';
		}
		return json_encode($resp);
	}
	function renew_rent()
	{
		extract($_POST);
		$qry = $this->conn->query("SELECT * FROM `rent_list` where id ='{$id}'");
		$res = $qry->fetch_array();
		switch ($res['rent_type']) {
			case 1:
				$date_end = " `date_end`='" . date("Y-m-d", strtotime($res['date_end'] . ' +1 month')) . "' ";
				break;
			case 2:
				$date_end = " `date_end`='" . date("Y-m-d", strtotime($res['date_end'] . ' +3 month')) . "' ";
				break;
			case 3:
				$date_end = " `date_end`='" . date("Y-m-d", strtotime($res['date_end'] . ' +1 year')) . "' ";
				break;
			default:
				# code...
				break;
		}
		$update = $this->conn->query("UPDATE `rent_list` set {$date_end}, date_rented = date_end where id = '{$id}' ");
		if ($update) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Rent successfully renewed.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_supplier':
		echo $Master->save_supplier();
		break;
	case 'delete_supplier':
		echo $Master->delete_supplier();
		break;
	case 'save_item':
		echo $Master->save_item();
		break;
	case 'delete_item':
		echo $Master->delete_item();
		break;
	case 'search_items':
		echo $Master->search_items();
		break;
	case 'save_po':
		echo $Master->save_po();
		break;
	case 'delete_po':
		echo $Master->delete_po();
		break;
	case 'get_price':
		echo $Master->get_price();
		break;
	case 'save_rent':
		echo $Master->save_rent();
		break;
	case 'delete_rent':
		echo $Master->delete_rent();
		break;
	case 'renew_rent':
		echo $Master->renew_rent();
		break;

	default:
		// echo $sysset->index();
		break;
}
