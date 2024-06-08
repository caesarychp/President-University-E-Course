<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $qry = $conn->query("SELECT * FROM `purchase_order` WHERE po_id = '$id'");
    if ($qry) {
        if ($qry->num_rows > 0) {
            $result = $qry->fetch_assoc();
            foreach ($result as $k => $v) {
                $$k = $v;
            }
        }
    } else {
        // Handle query error
        echo "Error: " . $conn->error;
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

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    [name="tax_percentage"],
    [name="discount_percentage"] {
        width: 5vw;
    }
</style>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update Purchase Order Details" : "New Purchase Order" ?></h3>
    </div>
    <div class="card-body">
        <form action="" id="po-form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="row">
                <!-- Vendor -->
                <div class="col-md-6 form-group">
                    <label for="vendor_id">vendor</label>
                    <select name="vendor_id" id="vendor_id" class="custom-select custom-select-sm rounded-0 select2">
                        <option value="" disabled <?php echo !isset($vendor_id) ? "selected" : '' ?>></option>
                        <?php
                        $vendor_qry = $conn->query("SELECT * FROM `vendor` WHERE `status` = 1 ORDER BY `vendor_name` ASC");
                        while ($row = $vendor_qry->fetch_assoc()) :
                        ?>
                            <option value="<?php echo $row['vendor_id'] ?>" <?php echo isset($vendor_id) && $vendor_id == $row['vendor_id'] ? 'selected' : '' ?>><?php echo $row['vendor_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <!-- Purchase Order Number -->
                <div class="col-md-6 form-group">
                    <label for="po_no">PO # <span class="po_err_msg text-danger"></span></label>
                    <input type="text" class="form-control form-control-sm rounded-0" id="po_no" name="po_no" value="<?php echo isset($po_no) ? $po_no : '' ?>">
                    <?php if (isset($po_no) && !empty($po_no)) : ?>
                        <!-- If po_no has a value, display it -->
                        <small><i>PO Number: <?php echo $po_no; ?></i></small>
                    <?php else : ?>
                        <!-- If po_no is empty, display a message -->
                        <small><i>Leave this blank to Automatically Generate upon saving.</i></small>
                    <?php endif; ?>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="item-list">
                        <colgroup>
                            <col width="5%">
                            <col width="30%">
                            <col width="30%">
                            <col width="5%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr class="bg-navy disabled">
                                <th class="px-1 py-1 text-center"></th>
                                <th class="px-1 py-1 text-center">Material Name</th>
                                <th class="px-1 py-1 text-center">Description</th>
                                <th class="px-1 py-1 text-center">Quantity</th>
                                <th class="px-1 py-1 text-center">Price</th>
                                <th class="px-1 py-1 text-center">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($id)) {
                                $order_items_qry = $conn->query("SELECT o.material_id, m.material_name, m.description, o.quantity, o.price FROM `purchase_order` o INNER JOIN `material` m ON o.material_id = m.material_id WHERE o.po_id = '$id'");
                                echo $conn->error;
                                while ($row = $order_items_qry->fetch_assoc()) :
                            ?>
                                    <tr class="po-item" data-id="">
                                        <td class="align-middle p-1 text-center">
                                            <button class="btn btn-sm btn-danger py-0" type="button" onclick="rem_item($(this))"><i class="fa fa-times"></i></button>
                                        </td>
                                        <td class="align-middle p-1">
                                            <input type="hidden" name="material_id[]" value="<?php echo $row['material_id'] ?>">
                                            <input type="text" class="text-center w-100 border-0 material_id" value="<?php echo $row['material_name'] ?>" required />
                                        </td>
                                        <td class="align-middle p-1 item-description"><?php echo $row['description'] ?></td>
                                        <td class="align-middle p-0 text-center">
                                            <input type="number" class="text-center w-100 border-0" step="any" name="qty[]" value="<?php echo $row['quantity']; ?>" />
                                        </td>
                                        <td class="align-middle p-1">
                                            <input type="number" step="any" class="text-right w-100 border-0" name="unit_price[]" value="<?php echo $row['price']; ?>" />
                                        </td>
                                        <td class="align-middle p-1 text-right total-price"><?php echo number_format($row['quantity'] * $row['price']); ?></td>
                                    </tr>
                            <?php endwhile;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-lightblue">
                            <tr>
                                <th class="p-1 text-right" colspan="6"><span><button class="btn btn btn-sm btn-flat btn-primary py-0 mx-1" type="button" id="add_row">Add Row</button></span> Sub Total</th>
                            </tr>
                            <tr>
                                <th class="p-1 text-right" colspan="5">Total</th>
                                <th class="p-1 text-right" id="total">0</th>
                            </tr>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="notes" class="control-label">Notes</label>
                            <textarea name="notes" id="notes" cols="10" rows="4" class="form-control rounded-0"><?php echo isset($notes) ? $notes : '' ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="control-label">Status</label>
                            <select name="status" id="status" class="form-control form-control-sm rounded-0">
                                <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Pending</option>
                                <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Approved</option>
                                <option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>Denied</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="po-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=purchase_orders">Cancel</a>
    </div>
</div>
<table class="d-none" id="item-clone">
    <tr class="po-item" data-id="">
        <td class="align-middle p-1 text-center">
            <button class="btn btn-sm btn-danger py-0" type="button" onclick="rem_item($(this))"><i class="fa fa-times"></i></button>
        </td>
        <td class="align-middle p-1 text-center">
            <input type="hidden" name="material_id[]">
            <input type="text" class="text-center w-100 border-0 material_id" required />
        </td>
        <td class="align-middle p-1 item-description"></td>
        <td class="align-middle p-1 text-center">
            <input type="number" class="text-center w-100 border-0" step="any" name="qty[]">
        </td>
        <td class="align-middle p-1 text-center">
            <input type="number" step="any" class="text-right w-100 border-0" name="unit_price[]">
        </td>
        <td class="align-middle p-1 text-right total-price">0</td>
    </tr>
</table>
<script>
    function rem_item(_this) {
        console.log(_this); // Log the value of _this to the console
        _this.closest('tr').remove();
    }


    function calculate() {
        var _total = 0;
        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });

        $('.po-item').each(function() {
            var qty = $(this).find("[name='qty[]']").val();
            var price = $(this).find("[name='unit_price[]']").val();
            var row_total = 0;
            if (qty > 0 && price > 0) {
                row_total = parseFloat(qty) * parseFloat(price);
            }
            $(this).find('.total-price').text(formatter.format(row_total));
            _total += row_total;
        });

        $('#total').text(formatter.format(_total));
    }

    function _autocomplete(_item) {
        _item.find('.material_id').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: _base_url_ + "classes/Master.php?f=search_items",
                    method: 'POST',
                    data: {
                        q: request.term
                    },
                    dataType: 'json',
                    error: err => {
                        console.log(err)
                    },
                    success: function(resp) {
                        response(resp)
                    }
                })
            },
            select: function(event, ui) {
                console.log(ui); // Log the entire ui object
                _item.find('input[name="material_id[]"]').val(ui.item.id);
                _item.find('.item-description').text(ui.item.description);
            }

        })
    }
    $(document).ready(function() {
        $('#add_row').click(function() {
            var tr = $('#item-clone tr').clone()
            $('#item-list tbody').append(tr)
            _autocomplete(tr)
            tr.find('[name="qty[]"],[name="unit_price[]"]').on('input keypress', function(e) {
                calculate()
            })
        })
        if ($('#item-list .po-item').length > 0) {
            $('#item-list .po-item').each(function() {
                var tr = $(this)
                _autocomplete(tr)
                tr.find('[name="qty[]"],[name="unit_price[]"]').on('input keypress', function(e) {
                    calculate()
                })
                tr.find('[name="qty[]"],[name="unit_price[]"]').trigger('keypress')
            })
        } else {
            $('#add_row').trigger('click')
        }
        $('.select2').select2({
            placeholder: "Please Select here",
            width: "relative"
        })
        $('#po-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            $('[name="po_no"]').removeClass('border-danger')
            if ($('#item-list .po-item').length <= 0) {
                alert_toast(" Please add atleast 1 item on the list.", 'warning')
                return false;
            }
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_po",
                // url: "http://localhost:8080/admin_dashboard/classes/Master.php?f=save_po",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("An error occured1", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./?page=purchase_orders/view_po&id=" + resp.id;
                    } else if ((resp.status == 'failed' || resp.status == 'po_failed') && !!resp.msg) {
                        var el = $('<div>')
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                        end_loader()
                    } else {
                        alert_toast("An error occured2", 'error');
                        end_loader();
                        console.log(resp)
                    }
                }
            })
        })


    })
</script>