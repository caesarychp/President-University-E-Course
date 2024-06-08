<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Employee of Procurement Department</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="30%">
                        <col width="30%">
                        <col width="20%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr class="bg-navy disabled">
                            <th>#</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Points</th>
                            <th>Bonus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT 
                                                e.employee_id,
                                                e.name,
                                                jp.title AS position,
                                                SUM(CASE 
                                                        WHEN rg.status = 1 THEN 1  -- Jika status Received, tambahkan 1 poin
                                                        WHEN rg.status = 2 THEN -1 -- Jika status Late Delivery, kurangi 1 poin
                                                        ELSE 0
                                                    END) AS points
                                            FROM 
                                                receive_goods rg
                                            LEFT JOIN 
                                                employees e ON rg.employee_id = e.employee_id
                                            LEFT JOIN 
                                                jobpositions jp ON e.job_position_id = jp.job_position_id
                                            WHERE
                                                e.job_position_id = 3
                                            GROUP BY 
                                                e.employee_id");

                        while ($row = $qry->fetch_assoc()) :
                            $points = $row['points'];
                            // Tentukan bonus berdasarkan poin
                            if ($points >= 10) {
                                $bonus = "Rp 2,000,000";
                            } elseif ($points >= 7) {
                                $bonus = "Rp 1,500,000";
                            } elseif ($points >= 5) {
                                $bonus = "Rp 1,000,000";
                            } elseif ($points >= 3) {
                                $bonus = "Rp 500,000";
                            } else {
                                $bonus = "Rp 0";
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['position'] ?></td>
                                <td><?php echo $points ?></td>
                                <td><?php echo $bonus ?></td>
                            </tr>
                        <?php endwhile; ?>

                            </tbody>
                        </table>
                        <br>
                        <div class="card">
                            <div class="card-header bg-info">
                                <h6 class="card-title"><b>*Bonus:</b></h6>
                            </div>
                            <div class="card-body">
                                <p><b>Points 10+</b> = <b>Rp 2,000,000</b></p>
                                <p><b>Points 7-9</b> = <b>Rp 1,500,000</b></p>
                                <p><b>Points 5-6</b> = <b>Rp 1,000,000</b></p>
                                <p><b>Points 3-4</b> = <b>Rp 500,000</b></p>
                                <p><b>Points less than 3</b> = <b>Rp 0</b></p>
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
