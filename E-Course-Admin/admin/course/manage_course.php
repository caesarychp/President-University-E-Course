<?php
$course_id = isset($_GET['id']) ? $_GET['id'] : 0;
$course_data = array(); // Initialize an empty array to hold the course data
if ($course_id > 0) {
    $qry = $conn->query("SELECT * FROM `course` WHERE `course_id` = '{$course_id}' ");
    if ($qry->num_rows > 0) {
        $course_data = $qry->fetch_assoc(); // Fetch the course data
    }
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title">New Course</h3>
    </div>
    <div class="card-body">
        <form action="save_course.php" id="course-form" method="post" enctype="multipart/form-data">
            <div class="row">
                <!-- Course Name -->
                <div class="col-md-6 form-group">
                    <label for="course_name">Course Name</label>
                    <input type="text" class="form-control form-control-sm" id="course_name" name="course_name" required>
                </div>
                <!-- Faculty Name -->
                <div class="col-md-6 form-group">
                    <label for="faculty_id">Faculty</label>
                    <select name="faculty_id" id="faculty_id" class="custom-select custom-select-sm">
                        <option value="" disabled selected>Select Faculty</option>
                        <?php
                        $faculty_qry = $conn->query("SELECT * FROM `faculty` ORDER BY `faculty_name` ASC");
                        while ($row = $faculty_qry->fetch_assoc()) :
                        ?>
                            <option value="<?php echo $row['faculty_id'] ?>"><?php echo $row['faculty_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <!-- Major Name -->
                <div class="col-md-6 form-group" id="major_container">
                    <label for="major_id">Major</label>
                    <select name="major_id" id="major_id" class="custom-select custom-select-sm">
                        <option value="" disabled selected>Select Major</option>
                        <?php
                        $major_qry = $conn->query("SELECT * FROM `major` ORDER BY `major_name` ASC");
                        while ($row = $major_qry->fetch_assoc()) :
                        ?>
                            <option class="major_option" data-faculty="<?php echo $row['faculty_id'] ?>" value="<?php echo $row['major_id'] ?>"><?php echo $row['major_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label for="material_id">Material</label>
                    <select name="material_id" id="material_id" class="custom-select custom-select-sm">
                        <option value="" disabled selected>Select Material</option>
                        <?php
                        $material_qry = $conn->query("SELECT * FROM `material` ORDER BY `material_name` ASC");
                        while ($row = $material_qry->fetch_assoc()) :
                        ?>
                            <option value="<?php echo $row['material_id'] ?>"><?php echo $row['material_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <!-- Price -->
                <div class="col-md-6 form-group">
                    <label for="price">Price</label>
                    <select name="price" id="price" class="custom-select custom-select-sm" required>
                        <option value="" disabled selected>Select Price</option>
                        <?php
                        // Lakukan query ke database untuk mendapatkan nilai enum dari kolom price
                        $price_qry = $conn->query("SHOW COLUMNS FROM course WHERE Field = 'price'");
                        $price_enum = $price_qry->fetch_assoc()['Type'];
                        preg_match("/^enum\(\'(.*)\'\)$/", $price_enum, $matches);
                        $options = explode("','", $matches[1]);
                        // Buat opsi dropdown dari nilai-nilai enum
                        foreach ($options as $option) {
                            echo "<option value=\"$option\">$option</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- Difficulty -->
                <div class="col-md-6 form-group">
                    <label for="difficulty">Difficulty</label>
                    <select name="difficulty" id="difficulty" class="custom-select custom-select-sm" required>
                        <option value="" disabled selected>Select Difficulty</option>
                        <?php
                        // Lakukan query ke database untuk mendapatkan nilai enum dari kolom difficulty
                        $difficulty_qry = $conn->query("SHOW COLUMNS FROM course WHERE Field = 'difficulty'");
                        $difficulty_enum = $difficulty_qry->fetch_assoc()['Type'];
                        preg_match("/^enum\(\'(.*)\'\)$/", $difficulty_enum, $matches);
                        $options = explode("','", $matches[1]);
                        // Buat opsi dropdown dari nilai-nilai enum
                        foreach ($options as $option) {
                            echo "<option value=\"$option\">$option</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <!-- Duration -->
                <div class="col-md-6 form-group">
                    <label for="duration">Duration</label>
                    <input type="text" class="form-control form-control-sm" id="duration" name="duration" required>
                </div>
                <!-- Start Date -->
                <div class="col-md-6 form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" class="form-control form-control-sm" id="start_date" name="start_date" required>
                </div>
            </div>
            <div class="row">
                <!-- Time -->
                <div class="col-md-6 form-group">
                    <label for="time">Time</label>
                    <input type="text" class="form-control form-control-sm" id="time" name="time" required>
                </div>
                <!-- Image -->
                <div class="col-md-6 form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file form-control-sm" id="image" name="image" accept="image/*" required>
                </div>
            </div>
            <div class="row">
                <!-- Description -->
                <div class="col-md-6 form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="5" class="form-control form-control-sm" required></textarea>
                </div>
                <!-- Language -->
                <div class="col-md-6 form-group">
                    <label for="language">Language</label>
                    <input type="text" class="form-control form-control-sm" id="language" name="language" required>
                </div>
            </div>
            <div class="row">
                <!-- Objective -->
                <div class="col-md-6 form-group">
                    <label for="objective">Objective</label>
                    <textarea name="objective" id="objective" cols="30" rows="5" class="form-control form-control-sm" required></textarea>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="course-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=course">Cancel</a>
    </div>

</div>
<script>
    $(function() {
        $('#course-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_course",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: function(err) {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./?page=course/"
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                    } else {
                        alert_toast("An error occurred", 'error');
                        console.log(resp);
                    }
                    end_loader();
                }
            });
        });
    });
</script>