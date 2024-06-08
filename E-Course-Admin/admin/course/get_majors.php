<?php
// Include your database connection file here
// include 'connection.php';

if(isset($_POST['faculty_id'])){
    $faculty_id = $_POST['faculty_id'];
    
    // Fetch majors based on faculty_id
    $major_qry = $conn->query("SELECT * FROM `major` WHERE `faculty_id` = '$faculty_id' ORDER BY `major_name` ASC");
    
    $output = '<option value="" disabled selected>Select Major</option>';
    
    while ($row = $major_qry->fetch_assoc()) {
        $output .= '<option value="'.$row['major_id'].'">'.$row['major_name'].'</option>';
    }
    
    echo $output;
}
