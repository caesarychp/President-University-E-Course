<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Courses</h3>
        <div class="card-tools">
            <a href="?page=course/manage_course" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" style="width:150%; overflow-x:auto;">
                        <thead>
                            <tr class="bg-navy disabled">
                                <th class="text-center">#</th>
                                <th class="text-center">Course Name</th>
                                <th class="text-center">Faculty</th>
                                <th class="text-center">Major</th>
                                <th class="text-center" >Material</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Difficulty</th>
                                <th class="text-center">Duration</th>
                                <th class="text-center">Start Date</th>
                                <th class="text-center">Time</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Language</th>
                                <th class="text-center">Objective</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $qry = $conn->query("SELECT 
                                                    c.*, 
                                                    f.faculty_name AS faculty_name, 
                                                    m.major_name AS mname,
                                                    mt.material_name AS material_name
                                                FROM 
                                                    `course` c 
                                                INNER JOIN 
                                                    `faculty` f ON c.faculty_id = f.faculty_id
                                                INNER JOIN 
                                                    `major` m ON c.major_id = m.major_id
                                                INNER JOIN
                                                    `material` mt ON c.material_id = mt.material_id
                                                    ORDER BY course_id ASC");
                            while ($row = $qry->fetch_assoc()) :
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td class=""><?php echo $row['course_name'] ?></td>
                                    <td class=""><?php echo $row['faculty_name'] ?></td>
                                    <td class=""><?php echo $row['mname'] ?></td>
                                    <td class=""><?php echo $row['material_name'] ?></td>
                                    <td class=""><?php echo $row['price'] ?></td>
                                    <td class=""><?php echo $row['difficulty'] ?></td>
                                    <td class=""><?php echo $row['duration'] ?></td>
                                    <td class=""><?php echo $row['start_date'] ?></td>
                                    <td class=""><?php echo $row['time'] ?></td>
                                    <td class=""><img src="../uploads/course/<?php echo $row['img']; ?>" alt="Course Image" style="max-width: 100px;"></td>
                                    <td class=""><?php echo $row['description'] ?></td>
                                    <td class="text-center"><?php echo $row['language'] ?></td>
                                    <td class=""><?php echo $row['objective'] ?></td>
                                    <td align="center">
                                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            Action
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a class="dropdown-item" href="?page=course/view_course&id=<?php echo $row['course_id'] ?>"><span class="fa fa-eye text-primary"></span> View</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="?page=course/manage_course&id=<?php echo $row['course_id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['course_id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.delete_data').click(function() {
            _conf("Are you sure to delete this course permanently?", "delete_course", [$(this).attr('data-id')])
        })
        $('.table th,.table td').addClass('px-1 py-0 align-middle')
        $('.table').dataTable();
    })

    function delete_course($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_course",
            method: "POST",
            data: {
                id: $id
            },
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("An error occured.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occured.", 'error');
                    end_loader();
                }
            }
        })
    }
</script>
