<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Employee of Sales Department</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="15%">
                        <col width="20%">
                        <col width="20%">
                        <col width="15%">
                        <col width="15%">

                    </colgroup>
                    <thead>
                        <tr class="bg-navy disabled">
                            <th>#</th>
                            <th>Name</th>
                            <th>Position</th>
                            </th>
                            <th>Total Amount Sales</th>
                            <th>Target Amount Sales</th>
                            <th>Completion</th>
                            <th>*Bonus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT e.name, jp.title as position, COUNT(so.OrderID) as total_sales, st.target_sales
                    FROM sales_orders so
                    JOIN employees e ON so.employee_id = e.employee_id
                    JOIN jobpositions jp ON e.job_position_id = jp.job_position_id
                    JOIN sales_target st ON e.employee_id = st.employee
                    GROUP BY e.employee_id
                    ORDER BY total_sales DESC");
                        while ($row = $qry->fetch_assoc()) {
                            $completion = ($row['total_sales'] / $row['target_sales']) * 100;
                            $bonus = 'Rp 0.00';
                            if ($completion >= 90) {
                                $bonus = 'Rp 1,000,000.00';
                            } elseif ($completion >= 70) {
                                $bonus = 'Rp 750,000.00';
                            } elseif ($completion >= 40) {
                                $bonus = 'Rp 500,000.00';
                            } elseif ($completion >= 30) {
                                $bonus = 'Rp 250,000.00';
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td class=""><?php echo $row['name'] ?></td>
                                <td class=""><?php echo $row['position'] ?></td>
                                <td class=""><?php echo $row['total_sales'] ?></td>
                                <td class=""><?php echo $row['target_sales'] ?></td>
                                <td class=""><?php echo number_format($completion, 2) ?>%</td>
                                <td class=""><?php echo $bonus ?></td>
                            </tr>
                        <?php } ?>



                    </tbody>

                </table>
                <br>
                <div class="card">
                    <div class="card-header bg-info">
                        <h6 class="card-title"><b>*Bonus:</b></h6>
                    </div>
                    <div class="card-body">
                        <p><b>Completion Range 100%-90%</b> = <b> Rp 1,000,000</b></p>
                        <p><b>Completion Range 89%-70%</b> = <b> Rp 750,000</b></p>
                        <p><b>Completion Range 69%-40%</b> = <b> Rp 500,000</b></p>
                        <p><b>Completion Range 39%-30%</b> = <b> Rp 250,000</b></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.delete_data').click(function() {
            _conf("Are you sure to delete this purchase order permanently?", "delete_purchase_order", [$(this).attr('data-id')])
        })

        $('.table th,.table td').addClass('px-1 py-0 align-middle')
        $('.table').dataTable();
    })

    function delete_purchase_order($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_po",
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