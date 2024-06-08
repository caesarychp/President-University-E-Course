<style>
    table td,
    table th {
        padding: 3px !important;
    }
</style>
<?php
// Define current date
$current_date = date("Y-m-d");

// Update the status of invoices to "Overdue" where due date has passed
$update_query = "UPDATE `accounts_payable` SET `status` = 'Overdue' WHERE `due_date` < '$current_date' AND `status` = 'Open'";
$conn->query($update_query);

// Calculate first day of the current month
$date_start = date("Y-m-01");

// Calculate last day of the current month
$date_end = date("Y-m-t");

// Query data with defined $date_start and $date_end
$qry = $conn->query("SELECT a.*, p.po_no, v.vendor_name 
                     FROM `accounts_payable` a 
                     LEFT JOIN `purchase_order` p ON a.po_id = p.po_id 
                     LEFT JOIN `vendor` v ON p.vendor_id = v.vendor_id 
                     WHERE a.`invoice_date` BETWEEN '{$date_start}' AND '{$date_end}' 
                     ORDER BY a.`invoice_date` ASC");
?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h5 class="card-title">Accounts Payable Report</h5>
    </div>
    <div class="card-body">
        <form id="filter-form">
            <div class="row align-items-end">
                <div class="form-group col-md-3">
                    <label for="date_start">Date Start</label>
                    <input type="date" class="form-control form-control-sm" name="date_start" value="<?php echo date("Y-m-d", strtotime($date_start)) ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="date_end">Date End</label>
                    <input type="date" class="form-control form-control-sm" name="date_end" value="<?php echo date("Y-m-d", strtotime($date_end)) ?>">
                </div>
                <div class="form-group col-md-1">
                    <button type="submit" class="btn btn-flat btn-block btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-success btn-sm" type="button" id="printBTN"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
        </form>
        <hr>
        <div id="printable">
            <div>
                <h4 class="text-center m-0"><?php echo $_settings->info('name') ?></h4>
                <h3 class="text-center m-0"><b>Accounts Payable Report</b></h3>
                <hr style="width:15%">
                <p class="text-center m-0">Date Between <b><?php echo date("M d, Y", strtotime($date_start)) ?> and <?php echo date("M d, Y", strtotime($date_end)) ?></b></p>
                <hr>
            </div>
            <table class="table table-bordered">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr class="bg-gray-light">
                        <th class="text-center">#</th>
                        <th class="text-center">Vendor</th>
                        <th class="text-center">Purchase Order</th>
                        <th class="text-center">Invoice Number</th>
                        <th class="text-center">Invoice Date</th>
                        <th class="text-center">Due Date</th>
                        <th class="text-center">Amount Due</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    $total = 0;
                    // Loop through query results
                    while ($row = $qry->fetch_assoc()) :
                        $total += $row['amount_due'];
                    ?>
                        <tr>
                            <td class="text-center align-middle"><?php echo $i++ ?></td>
                            <td class="text-center align-middle"><?php echo $row['vendor_name'] ?></td>
                            <td class="text-center align-middle"><?php echo "PO" . $row['po_no'] ?></td>
                            <td class="text-center align-middle"><?php echo $row['invoice_number'] ?></td>
                            <td class="text-center align-middle"><?php echo date("M d, Y", strtotime($row['invoice_date'])) ?></td>
                            <td class="text-center align-middle"><?php echo date("M d, Y", strtotime($row['due_date'])) ?></td>
                            <td class="text-center align-middle">Rp <?php echo number_format($row['amount_due'], 0) ?></td>
                            <td class="text-center align-middle"><?php echo $row['status'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if ($qry->num_rows <= 0) : ?>
                        <tr>
                            <td class="text-center" colspan="9">No Data...</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right px-3" colspan="7"><b>Total</b></td>
                        <td class="text-right"><b><?php echo number_format($total, 2) ?></b></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#filter-form').submit(function(e) {
            e.preventDefault();
            var date_start = $('[name="date_start"]').val();
            var date_end = $('[name="date_end"]').val();
            window.location.href = "./?page=reports/account_payable&date_start=" + date_start + "&date_end=" + date_end;
        });

        $('#printBTN').click(function() {
            var rep = $('#printable').clone();
            var ns = $('head').clone();
            start_loader();
            rep.prepend(ns);
            var nw = window.document.open('', '_blank', 'width=900,height=600');
            nw.document.write(rep.html());
            nw.document.close();
            setTimeout(function() {
                nw.print();
                setTimeout(function() {
                    nw.close();
                    end_loader();
                }, 500);
            }, 500);
        });
    });
</script>