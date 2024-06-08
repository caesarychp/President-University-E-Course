<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>

<style>
    .btn-pay {
        padding: 10px 30px;
        background: #fff;
        color: #fff;
        background: #6c757d;
        border: 0;
        outline: none;
        cursor: pointer;
        font-size: 12px;
        font: bold;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        font-weight: 80;
        border-radius: 10px;
    }


    .popup {
        width: 465px;
        height: 600px;
        border-radius: 5px;
        position: fixed;
        top: 0;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.1);
        text-align: center;
        padding: 0 30px 30px;
        color: var(--jay, #fff);
        visibility: hidden;
        transition: transform 0.4s, top 0.4s;
    }

    .open-popup {
        visibility: visible;
        position: fixed;
        background-color: rgba(0, 0, 0, .8);
        width: 100%;
        height: 100%;
        top: 50%;
        left: 50%;
        justify-content: center;
        display: flex;
        align-items: center;
        transform: translate(-50%, -50%) scale(1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, .2);
    }

    .div {
        background-color: var(--jay, #ffffff);
        display: flex;
        max-width: 470px;
        left: 50%;
        padding-bottom: 22px;
        flex-direction: column;
        font-size: 20px;
        justify-content: center;
        position: center;
    }

    .div-2 {
        font-family: Roboto Slab, sans-serif;
        align-items: start;
        background-color: #293352;
        width: 100%;
        color: var(--puis-president-ac-id-12633333740234375-x-5413333129882812-default-nero,
                var(--jay, #fff));
        font-weight: 400;
        line-height: 120%;
        text-align: center;
        padding: 25px 25px;
    }

    .div-3 {
        display: flex;
        margin-top: 25px;
        width: 100%;
        flex-direction: column;
        color: #000;
        font-weight: 300;
        padding: 0 44px;
    }

    .div-4 {
        justify-content: center;
        background-color: #dcdcdc;
        align-self: center;
        white-space: nowrap;
        text-align: center;
        text-transform: uppercase;
        padding: 18px 51px;
        font: 700 24px/100% Merriweather Sans, -apple-system, Roboto, Helvetica,
            sans-serif;
    }


    .div-5 {
        font-family: Roboto, sans-serif;
        margin-top: 30px;
    }

    .div-6 {
        border-radius: 4px;
        background-color: rgba(196, 196, 196, 0.5);
        margin-top: 16px;
        width: 400px;
        max-width: 100%;
        height: 61px;
        text-align: center;
    }

    .div-7 {
        display: flex;
        margin-top: 10px;
        gap: 20px;
        justify-content: space-between;
    }

    .div-8 {
        display: flex;
        flex-direction: column;
    }

    .div-9 {
        font-family: Roboto, sans-serif;
    }

    .div-10 {
        border-radius: 4px;
        background-color: rgba(196, 196, 196, 0.5);
        margin-top: 10px;
        height: 60px;
        width: 200px;
        text-align: center;
    }

    .div-11 {
        display: flex;
        flex-direction: column;
        white-space: nowrap;
    }

    .div-12 {
        font-family: Roboto, sans-serif;
    }

    .div-13 {
        border-radius: 4px;
        background-color: rgba(196, 196, 196, 0.5);
        height: 60px;
        margin: 10px 0 0 -3px;
        width: 135px;
        text-align: center;
    }

    .div-14 {
        font-family: Roboto, sans-serif;
        margin-top: 12px;
    }

    .div-15 {
        border-radius: 4px;
        background-color: rgba(196, 196, 196, 0.5);
        margin-top: 16px;
        width: 374px;
        max-width: 100%;
        height: 59px;
        text-align: center;
    }

    .div-16 {
        font-family: Roboto Slab, sans-serif;
        background-color: #293352;
        align-self: center;
        margin-top: 19px;
        border-radius: 10px;
        width: 174px;
        max-width: 100%;
        align-items: center;
        position: center;
        color: var(--jay, #fff);
        font-weight: 400;
        white-space: nowrap;
        text-align: center;
        line-height: 120%;
        justify-content: center;
        padding: 22px 60px;
    }

    .div-17 {
        justify-content: center;
    }

    #text{
        text-align: center;
        font: bold;
        font-family: Merriweather Sans, -apple-system, Roboto, Helvetica,sans-serif;
        font-size: 25px;
        font-style: normal;
        margin: center;
        padding: 10px;
    }
</style>
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
                        <col width="15%">

                    </colgroup>
                    <thead>
                        <tr class="bg-navy disabled">
                            <th>#</th>
                            <th>Date Created</th>
                            <th>Order_Id</th>
                            <th>Vendor</th>
                            <th>Material Name</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT 
                                                po.*, 
                                                v.vendor_name AS vname, 
                                                pi.vendor_id,
                                                pi.material_id,
                                                pi.quantity,
                                                pi.price,
                                                i.material_name,
                                                SUM(pi.quantity * pi.price) AS total_amount
                                            FROM 
                                                `purchase_order` po 
                                            INNER JOIN 
                                                `vendor` v ON po.vendor_id = v.vendor_id 
                                            INNER JOIN 
                                                `purchase_order` pi ON po.po_id = pi.po_id 
                                            INNER JOIN 
                                                `material` i ON pi.material_id = i.material_id 
                                            GROUP BY 
                                                po_id 
                                            ORDER BY 
                                            po.po_id ASC");
                        while ($row = $qry->fetch_assoc()) :
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td class=""><?php echo date("M d,Y H:i", strtotime($row['date_created'])); ?></td>
                                <td class=""><?php echo "PO" . $row['po_no'] ?></td>
                                <td class=""><?php echo $row['vname'] ?></td>
                                <td class=""><?php echo $row['material_name'] ?></td>
                                <td class=""><?php echo number_format($row['total_amount']) ?></td>
                                <td>
                                    <div class="card-tools">
                                        <a href="javascript:void(0)">

                                            <?php
                                            switch ($row['status']) {
                                                case '1':
                                                    echo '<span class="badge badge-success">Open</span>';
                                                    break;
                                                case '2':
                                                    echo '<span class="badge badge-danger">Close</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge badge-secondary">Overdue</span>';
                                                    break;
                                            }
                                            ?></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="container">
                                        <button type="submit" class="btn-pay" onclick="openPopup()">PAY</button>



                                        <div class="popup" id="popup">
                                            <div class="div">
                                                <div class="div-2">Payment Details</div>
                                                <div class="div-3">
                                                    <div class="div-4">BANKS</div>

                                                    <form method="post" action="">
                                                        <div class="div-5">Card Number</div>
                                                        <div class="div-6" id="text" name="card-number">012345678</div>
                                                        <div class="div-7">
                                                            <div class="div-8">
                                                                <div class="div-9">Expired Date</div>
                                                                <div class="div-10"  id="text" name="expired-date" >17/10</div>
                                                            </div>
                                                            <div class="div-11">
                                                                <div class="div-12">CVV</div>
                                                                <div class="div-13"id="text" name="cvv" >317</div>
                                                            </div>
                                                        </div>
                                                        <div class="div-14">Card Owner</div>
                                                        <div class="div-15" id="text" name="card-owner">02197482129293</div>

                                                </div>
                                                <!-- <div class="div-17"> -->
                                                <button class="div-16" onclick="payton()">PAY</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
            </div>
        </div>

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
    let popup = document.getElementById("popup");
    function openPopup() {
         popup.classList.add("open-popup");
    }

    function payton() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                popup.innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "invoicesbanks.php?po_id=", true);
        xhttp.send();
    }

</script>