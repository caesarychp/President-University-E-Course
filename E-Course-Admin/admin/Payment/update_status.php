<?php
require_once('../../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST['ap_id']) && is_numeric($_POST['ap_id']) && $_POST['ap_id'] > 0) {
    $ap_id = (int)$_POST['ap_id'];
    
    // Update the status to 'Closed'
    $update_query = $conn->query("UPDATE `accounts_payable` SET `status` = 'Closed' WHERE `ap_id` = $ap_id");

    if ($update_query) {
      // You can echo a success message if needed
      echo "Status updated successfully.";
    } else {
      // Handle the error
      echo "Error updating status: " . $conn->error;
    }
  } else {
    echo "Invalid or missing ap_id parameter.";
  }
} else {
  echo "Invalid request method.";
}
