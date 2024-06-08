<?php
require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `material` where material_id = '{$_GET['id']}' ");
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
        padding-top: 0.25rem;
        padding-right: 0.5rem;
        padding-bottom: 0.25rem;
        padding-left: 0.5rem;
        height: auto;
    }
</style>
<form action="" id="item-form">
    <input type="hidden" name="id" value="<?php echo isset($material_id) ? $material_id : '' ?>">
    <div class="container-fluid">
        <div class="form-group">
            <label for="name" class="control-label">Material Name</label>
            <input type="text" name="material_name" id="material_name" class="form-control rounded-0" value="<?php echo isset($material_name) ? $material_name : "" ?>" required>
        </div>
        <div class="form-group">
            <label for="description" class="control-label">Description</label>
            <textarea rows="3" name="description" id="description" class="form-control rounded-0" required><?php echo isset($description) ? $description : "" ?></textarea>
        </div>
        <div class="form-group">
            <label for="category" class="control-label">Category</label>
            <select name="category_id" id="category_id" class="form-control rounded-0" required>
                <?php
                // Fetch categories from the database and populate the dropdown
                $category_qry = $conn->query("SELECT * FROM `category_material`");
                while ($row = $category_qry->fetch_assoc()) {
                    $selected = isset($category_id) && $category_id == $row['category_id'] ? 'selected' : '';
                    echo "<option value='{$row['category_id']}' {$selected}>{$row['category_name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="form-control rounded-0" required>
                <option value="1" <?php echo isset($status) && $status == "1" ? "selected" : "" ?>>Active</option>
                <option value="0" <?php echo isset($status) && $status == "0" ? "selected" : "" ?>>Inactive</option>
            </select>
        </div>
    </div>
</form>

<script>
    $(function() {
        $('#item-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_item",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("An error occured", 'error');
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
                        alert_toast("An error occured", 'error');
                        console.log(resp)
                    }
                    end_loader()
                }
            })
        })
    })
</script>