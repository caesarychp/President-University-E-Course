<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
    </script>
<?php endif; ?>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Receive Goods</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="10%">
                        <col width="10%">
                        <col width="15%">
                        <col width="10%">
                        <col width="15%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                    </colgroup>
                    <thead>
                        <tr class="bg-navy disabled">
                            <th>#</th>
                            <th>Order Date</th>
                            <th>Received Goods ID</th>
                            <th>Purchase Order ID</th>
                            <th>Material ID</th>
                            <th>Recipient Name</th>
                            <th>Due Date</th>
                            <th>Received Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;

                        $qry = $conn->query("SELECT 
                        rg.receive_id, 
                        po.po_id, 
                        po.po_no, 
                        po.material_id, 
                        po.date_created AS order_date, 
                        rg.employee_id, 
                        e.name AS recipient_name, 
                        rg.due_date, 
                        rg.received_date, 
                        rg.status 
                            FROM 
                                `receive_goods` rg 
                            JOIN 
                                `purchase_order` po ON rg.po_id = po.po_id 
                            LEFT JOIN 
                                `employees` e ON rg.employee_id = e.employee_id 
                            WHERE 
                                po.status = 1 
                            ORDER BY 
                                po.date_created ASC;
                    
                             ");

                        while ($row = $qry->fetch_assoc()) :
                            if ($row['status'] == 0 && strtotime($row['due_date']) < strtotime(date('Y-m-d'))) {
                                $conn->query("UPDATE receive_goods SET status = 2 WHERE receive_id = '" . $row['receive_id'] . "'");
                            }
                            // ...

                            // 1. Mengatur due_date saat receive_id baru dimasukkan
                            // ...
                            // Set due_date menjadi seminggu setelah date_created dari purchase_order
                            $due_date = date('Y-m-d', strtotime($row['order_date'] . ' +1 week'));
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $row['order_date']; ?></td>
                                <td><?php echo $row['receive_id']; ?></td>
                                <td><?php echo "PO" . $row['po_no']; ?></td>
                                <td><?php echo $row['material_id']; ?></td>
                                <td><?php echo $row['recipient_name']; ?></td>
                                <td><?php echo $row['due_date']; ?></td>
                                <td><?php echo $row['received_date']; ?></td>
                                <td class="text-center">
                                    <?php if ($row['status'] == 0) : ?>
                                        <span class="badge badge-info">Delivery</span>
                                    <?php elseif ($row['status'] == 1) : ?>
                                        <span class="badge badge-success">Received</span>
                                    <?php elseif ($row['status'] == 2) : ?>
                                        <span class="badge badge-warning">Late Delivery</span>
                                    <?php endif; ?>
                                </td>
                                <td align="center">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon py-0" data-toggle="dropdown">
                                        Action
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['receive_id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                        <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['receive_id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
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

<script>
    // Function to handle updating status via AJAX
    function updateStatus(receive_id, status) {
        $.ajax({
            url: 'manage_rg.php', // File to handle the update
            method: 'POST',
            data: {
                receive_id: receive_id,
                status: status
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert_toast('Status updated successfully.', 'success');
                    // Reload the page to reflect changes
                    location.reload();
                } else {
                    alert_toast('Failed to update status.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert_toast('An error occurred. Please try again.', 'error');
            }
        });
    }

    $(document).ready(function() {
        // Attach event listener to dropdown for status change
        $('#status').change(function() {
            var receive_id = $(this).data('receive-id');
            var status = $(this).val();
            updateStatus(receive_id, status);
        });
    });

    $(document).ready(function() {
        $('.delete_data').click(function() {
            _conf("Are you sure to delete this Supplier permanently?", "delete_supplier", [$(this).attr('data-id')])
        })

        $('.view_data').click(function() {
            uni_modal("<i class='fa fa-info-circle'></i> Supplier's Details", "received_goods/manage_rg.php?id=" + $(this).attr('data-id'), "")
        })

        $('.table th,.table td').addClass('px-1 py-0 align-middle')
        $('.table').dataTable();
    })

    function delete_supplier($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_supplier",
            method: "POST",
            data: {
                id: $id.toString()
            },
            dataType: "json",
            error: function(err) {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>