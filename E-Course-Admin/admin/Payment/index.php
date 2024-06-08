<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Payments</h3>
        <!-- <div class="card-tools">
            <a href="?page=purchase_orders/manage_po" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
        </div> -->
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                        <col width="20%">
                        <col width="15%">
                        <col width="10%">
                        <col width="5%">
                    </colgroup>
                    <thead>
                        <tr class="bg-navy disabled">
                            <th class="text-center align-middle">#</th>
                            <th class="text-center align-middle">Date Created</th>
                            <th class="text-center align-middle">Order_Id</th>
                            <th class="text-center align-middle">Vendor</th>
                            <th class="text-center align-middle">Material Name</th>
                            <th class="text-center align-middle">Due Date</th>
                            <th class="text-center align-middle">Total Amount</th>
                            <th class="text-center align-middle">Status</th>
                            <th class="text-center align-middle">Pay</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        // Define current date
                        $current_date = date("Y-m-d");

                        // Update the status of invoices to "Overdue" where due date has passed
                        $update_query = "UPDATE `accounts_payable` SET `status` = 'Overdue' WHERE `due_date` < '$current_date' AND `status` = 'Open'";
                        $conn->query($update_query);

                        // Calculate first day of the current month
                        $date_start = date("Y-m-01");

                        // Calculate last day of the current month
                        $date_end = date("Y-m-t");
                        $qry = $conn->query("SELECT 
                                a.*, 
                                p.po_no, 
                                v.vendor_name,
                                m.material_name  -- Add material name column
                                    FROM 
                                        `accounts_payable` a 
                                    LEFT JOIN 
                                        `purchase_order` p ON a.po_id = p.po_id 
                                    LEFT JOIN 
                                        `vendor` v ON p.vendor_id = v.vendor_id 
                                    LEFT JOIN 
                                        `material` m ON p.material_id = m.material_id -- Join material table
                                    WHERE 
                                        a.`status` IN ('Open', 'Overdue')
                                        AND a.`invoice_date` BETWEEN '{$date_start}' AND '{$date_end}' 
                                    ORDER BY 
                                        a.`invoice_date` ASC;
                            
                            ");

                        while ($row = $qry->fetch_assoc()) :
                        ?>
                            <tr>
                                <td class="text-center align-middle"><?php echo $i++ ?></td>
                                <td class="text-center align-middle"><?php echo date("M d, Y", strtotime($row['invoice_date'])) ?></td>
                                <td class="text-center align-middle"><?php echo "PO" . $row['po_no'] ?></td>
                                <td class="text-center align-middle"><?php echo $row['vendor_name'] ?></td>
                                <td class="text-center align-middle"><?php echo $row['material_name'] ?></td>
                                <td class="text-center align-middle"><?php echo date("M d, Y", strtotime($row['due_date'])) ?></td>
                                <td class="text-center align-middle">Rp <?php echo number_format($row['amount_due'], 0) ?></td>
                                <td class="text-center align-middle"><?php echo $row['status'] ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm pay-btn" data-apid="<?php echo $row['ap_id']; ?>" data-pono="<?php echo $row['po_no']; ?>">Pay</button>
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
    $(document).ready(function() {
        $('.pay-btn').click(function() {
            var ap_id = $(this).data('apid');
            var po_no = $(this).data('pono');
            uni_modal_view("<i class='fa fa-plus'></i> Payment for AP #" + po_no, "Payment/paymentdetails.php?ap_id=" + ap_id + "");
        })
        $('.banks').click(function() {
            uni_modal_view("<i class='fa fa-plus'></i> Banks for PO #" + id, "Payment/banks.php?po_id=" + id);
        });
        $('.table th,.table td').addClass('px-1 py-0 align-middle');
        $('.table').dataTable();
    });
</script>