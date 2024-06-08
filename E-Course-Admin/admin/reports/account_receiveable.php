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

$qry = $conn->query(
    "SELECT
    ar.ReceivableID as receiveid,
    ar.InvoiceID as invoiceid,
    ar.OrderID as orderid,
    ar.Amount as amount,
    ar.Status as status,
    i.TransactionDate AS InvoiceTransactionDate,
    po.MembershipPlanID as paymentid,
    m.plan_name as membershipname
FROM
    accountable_receivable ar
INNER JOIN
    invoices i ON ar.InvoiceID = i.InvoiceID
INNER JOIN
    sales_orders po ON ar.OrderID = po.OrderID
INNER JOIN
    membershipplans m ON po.MembershipPlanID = m.PlanID"
);

?>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h5 class="card-title">Accounts Receivable Report</h5>
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
                <h3 class="text-center m-0"><b>Accounts Receivable Report</b></h3>
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
                    <col width="20%">
                    <col width="20%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <tr class="bg-gray-light">
                        <th class="text-center">#</th>
                        <th class="text-center">Order ID</th>
                        <th class="text-center">Invoice ID</th>
                        <th class="text-center">Membership Plan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Transaction Date</th>
                        <th class="text-center">Amount Due</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    $total = 0;
                    // Loop through query results
                    while ($row = $qry->fetch_assoc()) :
                        $total += $row['amount'];
                    ?>
                        <tr>
                            <td class="text-center align-middle"><?php echo $i++ ?></td>
                            <td class="text-center align-middle"><?php echo "SO" . $row['orderid'] ?></td>
                            <td class="text-center align-middle"><?php echo "INV-" . $row['invoiceid'] ?></td>
                            <td class="text-center align-middle"><?php echo $row['membershipname'] ?></td>
                            <td class="text-center align-middle"><?php echo $row['status'] ?></td>
                            <td class="text-center align-middle"><?php echo date("M d, Y", strtotime($row['InvoiceTransactionDate'])) ?></td>
                            <td class="text-center align-middle">Rp <?php echo number_format($row['amount'], 0) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if ($qry->num_rows <= 0) : ?>
                        <tr>
                            <td class="text-center" colspan="7">No Data...</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right px-3" colspan="6"><b>Total</b></td>
                        <td class="text-center"><b><?php echo number_format($total, 2) ?></b></td>
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