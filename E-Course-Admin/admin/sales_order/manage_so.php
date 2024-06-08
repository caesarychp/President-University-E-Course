<?php
require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * FROM `sales_orders` WHERE OrderID = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
}
?>
<style>
    span.select2-selection.select2-selection--single {
        border-radius: 0;
        padding: 0.25rem 0.5rem;
        height: auto;
    }
</style>
<form action="" id="item-form">
    <input type="hidden" name="id" value="<?php echo isset($OrderID) ? $OrderID : '' ?>">
    <div class="container-fluid">
        <div class="form-group">
            <label for="pic" class="control-label">PIC Employee</label>
            <select name="employee_id" id="employee_id" class="form-control rounded-0" required>
                <?php
                $employee_qry = $conn->query("SELECT employee_id, name FROM `employees` WHERE job_position_id = 2");
                while ($row = $employee_qry->fetch_assoc()) {
                    $selected = isset($employee_id) && $employee_id == $row['employee_id'] ? 'selected' : '';
                    echo "<option value='{$row['employee_id']}' {$selected}>{$row['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="form-control rounded-0" required>
                <option value="Processing" <?php echo isset($Status) && $Status == "Processing" ? "selected" : "" ?>>Processing</option>
                <option value="Active" <?php echo isset($Status) && $Status == "Active" ? "selected" : "" ?>>Active</option>
                <option value="Cancelled" <?php echo isset($Status) && $Status == "Cancelled" ? "selected" : "" ?>>Cancelled</option>
            </select>
        </div>
    </div>
</form>


<script>
    
    $(function() {
        $('#item-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_so",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    var errorMessage = xhr.responseText.includes("<br>") ? xhr.responseText.split("<br />")[1].trim() : "An error occurred";
                    alert_toast(errorMessage, 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.reload();
                        window.location.href = "index.php";
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
