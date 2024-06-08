<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = $_POST['course_name'];
    $faculty_id = $_POST['faculty_id'];
    $major_id = $_POST['major_id'];
    $material_id = $_POST['material_id'];
    $price = $_POST['price'];
    $difficulty = $_POST['difficulty'];
    $duration = $_POST['duration'];
    $start_date = $_POST['start_date'];
    $time = $_POST['time'];
    $description = $_POST['description'];
    $language = $_POST['language'];
    $user_id = $_POST['user_id'];
    $objective = $_POST['objective'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $img = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $img = null;
    }

    $stmt = $conn->prepare("INSERT INTO course (course_name, faculty_id, major_id, material_id, price, difficulty, duration, start_date, time, description, language, UserID, objective, img) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siissssssssiss", $course_name, $faculty_id, $major_id, $material_id, $price, $difficulty, $duration, $start_date, $time, $description, $language, $user_id, $objective, $img);

    if ($stmt->execute()) {
        echo "New course saved successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
