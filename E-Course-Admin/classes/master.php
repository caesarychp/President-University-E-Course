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
	function save_vendor()
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
		$check = $this->conn->query("SELECT * FROM `vendor` where `vendor_name` = '{$vendor_name}' " . (!empty($id) ? " and vendor_id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "vendor already exists.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `vendor` SET {$data} "; // Corrected syntax
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `vendor` SET {$data} WHERE vendor_id = '{$id}' "; // Corrected syntax
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New vendor successfully saved.");
			else
				$this->settings->set_flashdata('success', "vendor successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error . " [{$sql}]"; // Corrected variable name
		}
		return json_encode($resp);
	}
	function delete_vendor()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `vendor` where vendor_id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "vendor successfully deleted.");
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
	function save_so()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='" . $this->conn->real_escape_string($v) . "' ";
			}
		}

		$check = $this->conn->query("SELECT * FROM `sales_orders` WHERE `OrderID` = '{$id}'")->num_rows;

		if ($this->capture_err()) {
			return $this->capture_err();
		}

		if ($check == 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Sales Order not found.";
			return json_encode($resp);
		}

		$sql = "UPDATE `sales_orders` SET {$data} WHERE `OrderID` = '{$id}'";

		$save = $this->conn->query($sql);

		if ($save) {
			$resp['status'] = 'success';
			$resp['msg'] = "Sales order successfully updated.";
			$this->settings->set_flashdata('success', "Sales order successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		return json_encode($resp);
	}
	function save_invoices()
	{
		extract($_POST);

		// Check if $id is set and is a positive integer
		if (!isset($id) || !is_numeric($id) || $id <= 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Invalid invoice ID.";
			return json_encode($resp);
		}

		// Get today's date
		$today = date('Y-m-d');

		// Update status to "closed" and set payment_date to today's date in the database
		$sql = "UPDATE `accounts_payable` SET `status`='closed', `payment_date`='{$today}' WHERE `ap_id`='{$id}'";
		$save = $this->conn->query($sql);

		// Check for errors
		if ($this->capture_err()) {
			return $this->capture_err();
		}

		if ($save) {
			$resp['status'] = 'success';
			$resp['msg'] = "Invoice status successfully updated.";
			$this->settings->set_flashdata('success', "Invoice status successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		return json_encode($resp);
	}

	function save_databanks()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='" . $this->conn->real_escape_string($v) . "' ";
			}
		}

		$check = $this->conn->query("SELECT * FROM `databanks` WHERE `DatabankID` = '{$id}'")->num_rows;

		if ($this->capture_err()) {
			return $this->capture_err();
		}

		if ($check == 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Sales Order not found.";
			return json_encode($resp);
		}

		$sql = "UPDATE `databanks` SET {$data} WHERE `DatabanksID` = '{$id}'";

		$save = $this->conn->query($sql);

		if ($save) {
			$resp['status'] = 'success';
			$resp['msg'] = "Sales order successfully updated.";
			$this->settings->set_flashdata('success', "Sales order successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		return json_encode($resp);
	}
	function save_course()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'image', 'UserID'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='" . $this->conn->real_escape_string($v) . "' ";
			}
		}

		if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
			$target_dir = "../uploads/course/"; // Directory where the image will be saved
			// Generate a unique filename to prevent overwriting existing files
			$image_name = uniqid() . '_' . basename($_FILES["image"]["name"]);
			$target_file = $target_dir . $image_name;
			// Check if the directory exists, if not create it
			if (!is_dir($target_dir)) {
				mkdir($target_dir, 0777, true);
			}
			if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
				// Save only the image name to the database
				$data .= ", `img`='" . $this->conn->real_escape_string($image_name) . "'";
			} else {
				$resp['status'] = 'failed';
				$resp['msg'] = "Image upload failed.";
				return json_encode($resp);
			}
		}

		if (!empty($id)) {
			$check = $this->conn->query("SELECT * FROM `course` WHERE `course_id` = '{$id}'")->num_rows;

			if ($this->capture_err()) {
				return $this->capture_err();
			}

			if ($check == 0) {
				$resp['status'] = 'failed';
				$resp['msg'] = "Course not found.";
				return json_encode($resp);
			}

			$sql = "UPDATE `course` SET {$data} WHERE `course_id` = '{$id}'";
		} else {
			$sql = "INSERT INTO `course` SET {$data}";
		}

		$save = $this->conn->query($sql);

		if ($save) {
			$resp['status'] = 'success';
			if (!empty($id)) {
				$resp['msg'] = "Course successfully updated.";
				$this->settings->set_flashdata('success', "Course successfully updated.");
			} else {
				$resp['msg'] = "Course successfully added.";
				$this->settings->set_flashdata('success', "Course successfully added.");
			}
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
	function delete_so()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `sales_orders` where OrderID = '{$id}'");
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
		$qry = $this->conn->query("SELECT * FROM material where `material_name` LIKE '%{$q}%'");
		$data = array();
		while ($row = $qry->fetch_assoc()) {
			$data[] = array("label" => $row['material_name'], "id" => $row['material_id'], "description" => $row['description']);
		}
		return json_encode($data);
	}
	function save_po()
	{
		extract($_POST);
		$data = "";

		// Construct data string for updating fields other than material_id
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'po_no')) && !is_array($_POST[$k])) {
				$v = addslashes(trim($v));
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}

		// Update material_id if present
		if (isset($_POST['material_id'])) {
			$material_ids = $_POST['material_id'];
			foreach ($material_ids as $key => $value) {
				$material_ids[$key] = addslashes(trim($value));
			}
			$material_ids = implode(",", $material_ids); // If you want to store as comma-separated values
			if (!empty($data)) $data .= ",";
			$data .= " `material_id`='{$material_ids}' ";
		}

		// Include quantity and price fields in the data
		if (isset($_POST['qty'])) {
			$qty = $_POST['qty'];
			foreach ($qty as $key => $value) {
				$qty[$key] = addslashes(trim($value));
			}
			$qty = implode(",", $qty); // If you want to store as comma-separated values
			if (!empty($data)) $data .= ",";
			$data .= " `quantity`='{$qty}' ";
		}

		if (isset($_POST['unit_price'])) {
			$unit_price = $_POST['unit_price'];
			foreach ($unit_price as $key => $value) {
				$unit_price[$key] = addslashes(trim($value));
			}
			$unit_price = implode(",", $unit_price); // If you want to store as comma-separated values
			if (!empty($data)) $data .= ",";
			$data .= " `price`='{$unit_price}' ";
		}

		// Validate and handle PO number
		if (!empty($po_no)) {
			// Check if PO number already exists
			$check = $this->conn->query("SELECT * FROM `purchase_order` WHERE `po_no` = '{$po_no}' " . ($id > 0 ? " AND po_id != '{$id}' " : ""))->num_rows;
			if ($this->capture_err())
				return $this->capture_err();
			if ($check > 0) {
				$resp['status'] = 'po_failed';
				$resp['msg'] = "Purchase Order Number already exists.";
				return json_encode($resp);
				exit;
			}
		} else {
			$resp['status'] = 'po_failed';
			$resp['msg'] = "Purchase Order Number is required. $po_no";
			return json_encode($resp);
			exit;
		}
		$data .= ", po_no = '{$po_no}' ";

		// Construct the SQL query
		if (empty($id)) {
			$sql = "INSERT INTO `purchase_order` SET {$data} ";
		} else {
			// Check if the notes field is set and add it to the data
			if (isset($notes)) {
				$notes = addslashes(trim($notes));
				if (!empty($data)) $data .= ",";
				$data .= " `notes`='{$notes}' ";
			}
			$sql = "UPDATE `purchase_order` SET {$data} WHERE po_id = '{$id}' ";
		}

		// Execute the SQL query
		$save = $this->conn->query($sql);
		$resp = array(); // Initialize response array

		if ($save) {
			// Get the last inserted ID if it's a new record
			$po_id = empty($id) ? $this->conn->insert_id : $id;

			// Check if the status is approved (status = 1)
			if ($status == 1) {
				// Insert into receive_goods table
				$order_date = date('Y-m-d'); // Assuming order date is today
				$due_date = date('Y-m-d', strtotime($order_date . ' +7 days')); // Calculate due date as 7 days after the order date
				$insert_receive = $this->conn->query("INSERT INTO `receive_goods` (`po_id`, `due_date`, `employee_id`, `status`) VALUES ('$po_id', '$due_date', '1', '0')");
				if (!$insert_receive) {
					// Handle insertion error
					$resp['status'] = 'failed';
					$resp['err'] = $this->conn->error . "[Insert into receive_goods]";
					echo json_encode($resp);
					return;
				}

				// Insert into accounts_payable table
				$insert_payable = $this->conn->query("
					INSERT INTO `accounts_payable` (`po_id`, `invoice_number`, `invoice_date`, `due_date`, `amount_due`, `status`)
					SELECT
						`po_id`,
						CONCAT('INV-', `po_no`),
						CURDATE(),
						DATE_ADD(CURDATE(), INTERVAL 30 DAY), -- Due date is 7 days from today
						`quantity` * `price`,
						'Open' -- Assuming the status of the payable account is 'Open' initially
					FROM
						`purchase_order`
					WHERE
						`status` = 1
						AND `po_id` = '$po_id'
				");
				if (!$insert_payable) {
					// Handle insertion error
					$resp['status'] = 'failed';
					$resp['err'] = $this->conn->error . "[Insert into accounts_payable]";
					echo json_encode($resp);
					return;
				}
			}

			$resp['status'] = 'success';
			$resp['id'] = $po_id;
			if (empty($id))
				$resp['message'] = "Purchase Order successfully saved.";
			else
				$resp['message'] = "Purchase Order successfully updated.";

			echo json_encode($resp); // Return response to AJAX request
		}
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

	function save_category()
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
		$check = $this->conn->query("SELECT * FROM `categories` where `category` = '{$category}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Category already exist.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `categories` set {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `categories` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Category successfully saved.");
			else
				$this->settings->set_flashdata('success', "Category successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_category()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `categories` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Category successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_balance($category_id)
	{
		$budget = $this->conn->query("SELECT SUM(amount) as total FROM `running_balance` where `balance_type` = 1 and `category_id` = '{$category_id}' ")->fetch_assoc()['total'];
		$expense = $this->conn->query("SELECT SUM(amount) as total FROM `running_balance` where `balance_type` = 2 and `category_id` = '{$category_id}' ")->fetch_assoc()['total'];
		$balance = $budget - $expense;
		$update  = $this->conn->query("UPDATE `categories_expenses` set `balance` = '{$balance}' where `id` = '{$category_id}' ");
		if ($update) {
			return true;
		} else {
			return $this->conn;
		}
	}
	function save_budget()
	{
		extract($_POST);
		$_POST['amount'] = str_replace(',', '', $_POST['amount']);
		$_POST['remarks'] = addslashes(htmlentities($_POST['remarks']));
		$data = "";
		foreach ($_POST as $k => $v) {
			if ($k == 'id')
				continue;
			if (!empty($data)) $data .= ",";
			$data .= " `{$k}`='{$v}' ";
		}
		if (!empty($data)) $data .= ",";
		$data .= " `user_id`='{$this->settings->userdata('id')}' ";
		if (empty($id)) {
			$sql = "INSERT INTO `running_balance` set $data";
		} else {
			$sql = "UPDATE `running_balance` set $data WHERE id ='{$id}'";
		}
		$save = $this->conn->query($sql);
		if ($save) {
			$update_balance = $this->update_balance($_POST['category_id']);

			if ($update_balance == 1) {
				$resp['status'] = 'success';
				$this->settings->set_flashdata('success', " Budget successfully saved.");
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = $update_balance;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn;
		}
		return json_encode($resp);
	}

	function delete_budget()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `running_balance` where id = '{$id}'");
		if ($del) {
			$update_balance = $this->update_balance($category_id);
			if ($update_balance == 1) {
				$resp['status'] = 'success';
				$this->settings->set_flashdata('success', "Budget successfully deleted.");
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = $update_balance;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_expense()
	{
		extract($_POST);
		$_POST['amount'] = str_replace(',', '', $_POST['amount']);
		$_POST['remarks'] = addslashes(htmlentities($_POST['remarks']));
		$_POST['remarks'] = addslashes(htmlentities($_POST['vendor_id']));
		$data = "";
		foreach ($_POST as $k => $v) {
			if ($k == 'id')
				continue;
			if (!empty($data)) $data .= ",";
			$data .= " `{$k}`='{$v}' ";
		}
		if (!empty($data)) $data .= ",";
		$data .= " `user_id`='{$this->settings->userdata('id')}' ";
		if (empty($id)) {
			$sql = "INSERT INTO `running_balance` set $data";
		} else {
			$sql = "UPDATE `running_balance` set $data WHERE id ='{$id}'";
		}
		$save = $this->conn->query($sql);
		if ($save) {
			$update_balance = $this->update_balance($_POST['category_id']);

			if ($update_balance == 1) {
				$resp['status'] = 'success';
				$this->settings->set_flashdata('success', " Expense successfully saved.");
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = $update_balance;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn;
		}
		return json_encode($resp);
	}

	function delete_expense()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `running_balance` where id = '{$id}'");
		if ($del) {
			$update_balance = $this->update_balance($category_id);
			if ($update_balance == 1) {
				$resp['status'] = 'success';
				$this->settings->set_flashdata('success', "Expense successfully deleted.");
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = $update_balance;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_receive_goods_status()
	{
		extract($_POST);
		$status = intval($status); // Pastikan status adalah integer
		// Pastikan status yang diberikan adalah 0, 1, atau 2
		if (!in_array($status, array(0, 1, 2))) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Invalid status.";
			return json_encode($resp);
			exit;
		}
		if ($status == 1) {
			$received_date = date('Y-m-d H:i:s'); // Get current date and time
			$update = $this->conn->query("UPDATE `receive_goods` SET `status` = '$status', `employee_id` = '$employee', `received_date` = '$received_date' WHERE `receive_id` = '$receive_id'");
		} else {
			$update = $this->conn->query("UPDATE `receive_goods` SET `status` = '$status', `employee_id` = '$employee' WHERE `receive_id` = '$receive_id'");
		}
		if ($update) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Receive goods status updated successfully.");
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
	case 'save_vendor':
		echo $Master->save_vendor();
		break;
	case 'delete_vendor':
		echo $Master->delete_vendor();
		break;
	case 'save_item':
		echo $Master->save_item();
	case 'save_so':
		echo $Master->save_so();
	case 'save_invoices':
		echo $Master->save_invoices();
	case 'save_course':
		echo $Master->save_course();
		break;
	case 'delete_item':
		echo $Master->delete_item();
		break;
	case 'delete_so':
		echo $Master->delete_so();
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
	case 'save_category':
		echo $Master->save_category();
		break;
	case 'delete_category':
		echo $Master->delete_category();
		break;
	case 'save_budget':
		echo $Master->save_budget();
		break;
	case 'delete_budget':
		echo $Master->delete_budget();
		break;
	case 'save_expense':
		echo $Master->save_expense();
		break;
	case 'delete_expense':
		echo $Master->delete_expense();
		break;
	case 'update_receive_goods_status':
		echo $Master->update_receive_goods_status();
		break;
	case 'save_databanks':
		echo $Master->save_databanks();
		break;

	default:
		// echo $sysset->index();
		break;
}
