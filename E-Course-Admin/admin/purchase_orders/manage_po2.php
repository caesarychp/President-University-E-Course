<?php
// Error Handling: Enable error reporting and display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if 'id' parameter is set and greater than 0
if (isset($_GET['id']) && $_GET['id'] > 0) {
    // Query to fetch purchase order details based on 'po_id'
    $qry = $conn->query("SELECT * FROM `purchase_order` WHERE po_id = '{$_GET['id']}'");
    // Check if query executed successfully
    if (!$qry) {
        echo "Error: " . $conn->error;
    } else {
        // Fetch data from query result
        if ($qry->num_rows > 0) {
            foreach ($qry->fetch_assoc() as $k => $v) {
                $$k = $v;
            }
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
        <h3 class="card-title"><?php echo isset($po_id) ? "Update Purchase Order Details" : "New Purchase Order" ?> </h3>
    </div>
    <div class="card-body">
        <form action="" id="po-form">
            <input type="hidden" name="id" value="<?php echo isset($po_id) ? $po_id : '' ?>">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="vendor_id">Vendor</label>
                    <select name="vendor_id" id="vendor_id" class="custom-select custom-select-sm rounded-0 select2">
                        <option value="" disabled <?php echo !isset($vendor_id) ? "selected" : '' ?>></option>
                        <?php
                        $vendor_qry = $conn->query("SELECT * FROM `vendor` ORDER BY `vendor_name` ASC");
                        while ($row = $vendor_qry->fetch_assoc()) :
                        ?>
                            <option value="<?php echo $row['vendor_id'] ?>" <?php echo isset($vendor_id) && $vendor_id == $row['vendor_id'] ? 'selected' : '' ?> <?php echo $row['status'] == 0 ? 'disabled' : '' ?>><?php echo $row['vendor_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <!-- <div class="col-md-6 form-group">
                    <label for="po_no">PO # <span class="po_err_msg text-danger"></span></label>
                    <input type="text" class="form-control form-control-sm rounded-0" id="po_no" name="po_no" value="<?php echo isset($po_no) ? $po_no : '' ?>">
                    <small><i>Leave this blank to Automatically Generate upon saving.</i></small>
                </div> -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="item-list">
                        <colgroup>
                            <col width="5%">
                            <col width="15%">
                            <col width="30%">
                            <col width="20%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr class="bg-navy disabled">
                                <th class="px-1 py-1 text-center"></th>
                                <th class="px-1 py-1 text-center">Material Id</th>
                                <th class="px-1 py-1 text-center">Material Name</th>
                                <th class="px-1 py-1 text-center">Quantity</th>
                                <th class="px-1 py-1 text-center">Price</th>
                                <th class="px-1 py-1 text-center">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($po_id)) :
                                $order_items_qry = $conn->query("SELECT 
                                    o.material_id,
                                    m.material_name,
                                    o.quantity,
                                    o.price
                                FROM 
                                    `purchase_order` o 
                                INNER JOIN 
                                    `material` m ON o.material_id = m.material_id 
                                WHERE 
                                    o.`po_id` = '$po_id'");
                                echo $conn->error;
                                while ($row = $order_items_qry->fetch_assoc()) :
                            ?>

                                    <tr class="po-item" data-id="">

                                        <input type="hidden" name="po_id" value="<?php echo $po_id; ?>">
                                        <td class="align-middle p-1 text-center">
                                            <button class="btn btn-sm btn-danger py-0" type="button" onclick="rem_item($(this))"><i class="fa fa-times"></i></button>
                                        </td>
                                        <td class="align-middle p-1 text-center">
                                            <input type="text" class="text-center w-100 border-0" name="material_id[]" value="<?php echo $row['material_id'] ?>" />
                                        </td>
                                        <td class="align-middle p-1 text-center">
                                            <input type="text" class="text-center w-100 border-0" name="material_name[]" value="<?php echo $row['material_name'] ?>" />
                                        </td>
                                        <td class="align-middle p-1 text-center">
                                            <input type="number" class="text-center w-100 border-0" step="any" name="quantity[]" value="<?php echo $row['quantity'] ?>" />
                                        </td>
                                        <td class="align-middle p-1 text-center">
                                            <input type="number" step="any" class="text-right w-100 border-0" name="price[]" value="<?php echo $row['price'] ?>" />
                                        </td>
                                        <td class="align-middle p-1 text-right total-price"><?php echo number_format($row['quantity'] * $row['price']) ?></td>
                                    </tr>
                            <?php endwhile;
                            endif; ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-lightblue">
                            <tr>
                                <th class="p-1 text-right" colspan="6"><span><button class="btn btn btn-sm btn-flat btn-primary py-0 mx-1" type="button" id="add_row">Add Row</button></th>
                                <!-- <th class="p-1 text-right" id="sub_total">0</th> -->
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
            <input type="text" class="text-center w-100 border-0" name="material_id[]">
        </td>
        <td class="align-middle p-1 text-center">
            <input type="hidden" name="material_id[]" value="<?php echo $row['material_id'] ?>">
            <input type="text" class="text-center w-100 border-0" name="material_name[]">
        </td>
        <td class="align-middle p-1 text-center">
            <input type="number" class="text-center w-100 border-0" step="any" name="quantity[]">
        </td>
        <td class="align-middle p-1 text-center">
            <input type="number" step="any" class="text-right w-100 border-0" name="price[]">
        </td>
        <td class="align-middle p-1 text-right total-price">0</td>
    </tr>
</table>
<script>
    function rem_item(_this) {
        _this.closest('tr').remove();
        calculate();
    }

    function calculate() {
        var _total = 0;
        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });

        $('.po-item').each(function() {
            var qty = $(this).find("[name='quantity[]']").val();
            var price = $(this).find("[name='price[]']").val();
            var row_total = 0;
            if (qty > 0 && price > 0) {
                row_total = parseFloat(qty) * parseFloat(price);
            }
            $(this).find('.total-price').text(formatter.format(row_total)); // Use formatter.format() to format the number as IDR
            _total += row_total;
        });

        $('#sub_total').text(formatter.format(_total)); // Format and display sub-total in IDR
        $('#total').text(formatter.format(_total)); // Format and display total in IDR
    }



    function _autocomplete(_item) {
        _item.find('.material_id').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: _base_url_ + "classes/Master.php?f=search_materials",
                    method: 'POST',
                    data: {
                        q: request.term
                    },
                    dataType: 'json',
                    error: function(err) {
                        console.log(err);
                    },
                    success: function(resp) {
                        response(resp);
                    }
                });
            },
            select: function(event, ui) {
                _item.find('input[name="material_id[]"]').val(ui.item.material_id);
                _item.find('.material-description').text(ui.item.description);
            }
        });
    }

    $(document).ready(function() {
        $('#add_row').click(function() {
            var tr = $('#item-clone tr').clone();
            $('#item-list tbody').append(tr);
            _autocomplete(tr);
            tr.find('[name="quantity[]"], [name="price[]"]').on('input keypress', function(e) {
                calculate();
            });
            $('#item-list tfoot').find('[name="discount_percentage"], [name="tax_percentage"]').on('input keypress', function(e) {
                calculate();
            });
        });
        if ($('#item-list .po-item').length > 0) {
            $('#item-list .po-item').each(function() {
                var tr = $(this);
                _autocomplete(tr);
                tr.find('[name="quantity[]"], [name="price[]"]').on('input keypress', function(e) {
                    calculate();
                });
                tr.find('[name="quantity[]"], [name="price[]"]').trigger('keypress');
            });
        } else {
            $('#add_row').trigger('click');
        }
        $('.select2').select2({
            placeholder: "Please Select here",
            width: "relative"
        });
        $('#po-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            $('[name="po_id"]').removeClass('border-danger');
            $('[name="po_id"]').prop('disabled', true);

            if ($('#item-list .po-item').length <= 0) {
                alert_toast("Please add at least 1 item on the list.", 'warning');
                return false;
            }

            start_loader();

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_po",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: function(xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                    console.log(errorMessage);
                    alert_toast("An error occurred: " + errorMessage, 'error');
                    end_loader();
                },
                success: function(resp) {
                    console.log(resp); // Add this line to inspect the response data
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./?page=purchase_order/view_po&po_id=" + resp.id;
                        // location.href = "./?page=purchase_orders/view_po&id=" + 1;
                    } else if ((resp.status == 'failed' || resp.status == 'po_failed') && !!resp.msg) {
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body").animate({
                            scrollTop: 0
                        }, "fast");
                        if (resp.status == 'po_failed') {
                            $('[name="po_no"]').addClass('border-danger').focus();
                        }
                    } else {
                        alert_toast("An error occurred", 'error');
                        console.log(resp);
                    }
                }

            });
        });
    });
    <?php
    // Script untuk mengubah status pesanan pembelian menjadi "Approved"
    // dan menambahkan entri baru ke dalam tabel receive_goods
    if (isset($_POST['approve_order'])) {
        $po_id = $_POST['po_id'];

        // Logika untuk memperbarui status pesanan pembelian menjadi "Approved"
        $update_query = "UPDATE purchase_order SET status = 1 WHERE po_id = $po_id";
        $conn->query($update_query);

        // Mengambil informasi pesanan pembelian yang disetujui
        $order_query = "SELECT po_id, material_id, NOW() AS receive_date FROM purchase_order WHERE po_id = $po_id";
        $order_result = $conn->query($order_query);
        $order_data = $order_result->fetch_assoc();

        // Menambahkan entri baru ke dalam tabel receive_goods
        $insert_query = "INSERT INTO receive_goods (po_id, receive_date, status) VALUES ('" . $order_data['po_id'] . "', '" . $order_data['receive_date'] . "', 1)";
        $conn->query($insert_query);

        // Pesan sukses atau gagal, atau alihkan pengguna ke halaman lain
    }
    ?>
</script>