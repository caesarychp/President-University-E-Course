<?php
require_once('../../config.php');

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $receive_id = $_GET['id'];
    $qry = $conn->query("SELECT * FROM `receive_goods` WHERE receive_id = '$receive_id'");
    if ($qry->num_rows > 0) {
        $receive_goods = $qry->fetch_assoc();
    } else {
        // Jika ID tidak ditemukan, redirect atau tampilkan pesan kesalahan
        header("Location: index.php");
        exit();
    }
} else {
    // Jika ID tidak valid, redirect atau tampilkan pesan kesalahan
    header("Location: index.php");
    exit();
}
?>

<style>
    /* Gunakan style sesuai kebutuhan */
    span.select2-selection.select2-selection--single {
        border-radius: 0;
        padding: 0.25rem 0.5rem;
        padding-top: 0.25rem;
        padding-right: 0.5rem;
        padding-bottom: 0.25rem;
        padding-left: 0.5rem;
        height: auto;
    }
</style>

<form action="" id="receive-goods-form">
    <input type="hidden" name="receive_id" value="<?php echo $receive_id; ?>">
    <div class="container-fluid">
        <div class="form-group">
            <label for="employee" class="control-label">PIC Employee)</label>
            <select name="employee" id="employee" class="form-control rounded-0" required>
                <?php
                $employee_qry = $conn->query("SELECT employee_id, name FROM `employees` WHERE job_position_id = 3");
                while ($row = $employee_qry->fetch_assoc()) {
                    $selected = isset($Pic) && $Pic == $row['employee_id'] ? 'selected' : '';
                    echo "<option value='{$row['employee_id']}' {$selected}>{$row['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="form-control rounded-0" required>
                <option value="0" <?php echo $receive_goods['status'] == 0 ? "selected" : ""; ?>>Delivery</option>
                <option value="1" <?php echo $receive_goods['status'] == 1 ? "selected" : ""; ?>>Received</option>
                <option value="2" <?php echo $receive_goods['status'] == 2 ? "selected" : ""; ?>>Late Delivery</option>
            </select>
        </div>
    </div>
</form>

<script>
    $(function() {
        $('#receive-goods-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=update_receive_goods_status",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.reload();
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>')
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                    } else {
                        alert_toast("An error occurred", 'error');
                        console.log(resp);
                    }
                    end_loader()
                }
            })
        })
    })
</script>