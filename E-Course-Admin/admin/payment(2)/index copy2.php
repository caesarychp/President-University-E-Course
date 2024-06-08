<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>

<style>
    .btn-pay {
        padding: 10px 30px;
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

    .popup{
        width: 465px;
        height: 600px;
        background: #fff;
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
        background-color: rgba (0,0,0, .8);
    }

    .open-popup {
        visibility: visible;
        position:absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(1);
        box-shadow: 0 20px 40px rgba(0,0,0, .2);
    }

    .div {
        /* background-color: var(--jay, #ffffff);
        display: flex;
        justify-content: center;
        max-width:100%;
        padding-bottom: 80px;
        flex-direction: column;
        align-items: center; */
        font-size: 20px;
        font-weight: 400;
        line-height: 120%;

    }

    .div-2 {
        font-family: Roboto Slab, sans-serif;
        align-items: start;
        background-color: #293352;
        align-self: stretch;
        width: 100%;
        color: var(--puis-president-ac-id-12633333740234375-x-5413333129882812-default-nero,
                var(--jay, #fff));
        justify-content: center;
        padding: 25px 25px;
    }

    .div-3 {
        margin-top: 70px;
        justify-content: center;
        align-items: center;
        text-align: center;

    }

    .div-4 {
        align-items: center;
        text-align: center;
        align-self: center;
        justify-content: center;
        border-radius: 8px;
        box-shadow: 0px 8px 16px 0px rgba(10, 147, 158, 0.24);
        background-color: #a51c30;
        margin-top: 20px;
        width: 300px;
        color: var(--myskill_id_e-learning_1440x810_default-Nero, #fff);
        padding: 12px 60px 13px;
        font: 700 15px/150% Public Sans, -apple-system, Roboto, Helvetica,
            sans-serif;
    }

    @media (max-width: 991px) {
        .div-14 {
            padding: 0 20px;
            margin-top: 40px;
        }
    }

    .div-4 {
        font-family: Merriweather Sans, sans-serif;
        flex-grow: 1;
        flex-basis: auto;
        margin: auto 0;
    }

    .div-5 {
        background-color: #a51c30;
        display: flex;
        margin-top: 45px;
        width: 100%;
        max-width: 320px;
        align-items: flex-start;
        gap: 20px;
        white-space: nowrap;
        text-align: center;
        text-transform: uppercase;
        padding: 20px 18px;
    }

    .div-6 {
        font-family: Merriweather Sans, sans-serif;
        flex-grow: 1;
        flex-basis: auto;
        margin: auto 0;
    }

    .img {
        aspect-ratio: 1;
        object-fit: auto;
        object-position: center;
        width: 50px;
        border-radius: 1px;
        align-self: start;
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

                                                <!-- images banks -->
                                                <div class="div-3">
                                                    <button class="div-4" onclick="Banks()">BANKS</button>
                                                </div>

                                                <!-- images ewallet -->
                                                <div class="div-3">
                                                    <button class="div-4" onclick="Ewallet()">E-WALLET</button>
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

    function Banks() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                popup.innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "./payment/banks.php", true);
        xhttp.send();
    }

    function Ewallet() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                popup.innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "./payment/ewallet.php", true);
        xhttp.send();
    }

    // let content = document.createElement('iframe');
    //     content.src = 'payment/banks.php';
    //     content.style.width = '465px';
    //     content.style.height = '600px';
    //     popup.innerHTML = '';
    //     popup.appendChild(content);

    //  // Open bank.php in a new popup within the existing popup
    //  let bankPopup = window.open("payment/banks.php", "bankPopup", "width=465,height=600");
    //     // Focus the new popup
    //     bankPopup.focus();



    // // Open bank.php in a new popup within the existing popup
    // let bankPopup = window.open("payment/banks.php", "bankPopup", "width=465,height=600");
    //         // Focus the new popup
    //         bankPopup.focus();

    // function Banks() {
    //     window.location.href = "payment/banks.php";
    // }

    // function Ewallet() {
    //     window.location.href = "ewallet.php";
    // }


    // // Redirect to paymentdetails.php after a delay
    // setTimeout(function() {
    //     window.location.href = "payment/paymentdetails.php";
    // }, 1000); // You can adjust the delay time (in milliseconds) as needed


    // $(document).ready(function(){
    // 	$('#status_pay').click(function(){
    // 		uni_modal("<i class='fa fa-plus'></i>","payment/paymentdetails.php")
    // 	})
    // 	$('.table th,.table td').addClass('px-1 py-0 align-middle')
    // 	$('.table').dataTable();
    // })
</script>