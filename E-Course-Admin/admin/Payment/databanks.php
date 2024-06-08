<style>
    .div {
        background-color: var(--jay, #ffffff);
        display: flex;
        max-width: 463px;
        padding-bottom: 22px;
        flex-direction: column;
        font-size: 20px;
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
        justify-content: center;
        padding: 24px 29px;
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

    .img {
        aspect-ratio: 2.78;
        object-fit: auto;
        object-position: center;
        width: 188px;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        margin-top: 45px;
        max-width: 100%;
    }

    .div-5 {
        font-family: Roboto, sans-serif;
        margin-top: 12px;
    }

    .div-6 {
        border-radius: 4px;
        background-color: rgba(196, 196, 196, 0.5);
        margin-top: 16px;
        width: 374px;
        max-width: 100%;
        height: 61px;
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
        margin: 14px 0 0 -3px;
        width: 200px;
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
</style>
<?php
require_once('../../config.php');

$imageLink = '';
$imagePath = "./Payment/images/"; // Updated path to your images folder

$ap_id = isset($_GET['ap_id']) ? $_GET['ap_id'] : ''; // Retrieve ap_id from URL parameters

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT d.*, b.ImageLink FROM `databanks` d JOIN `banks` b ON d.BanksID = b.BanksID WHERE d.DatabankID = '{$_GET['id']}' ");
    if ($qry) {
        if ($qry->num_rows > 0) {
            $result = $qry->fetch_assoc();
            foreach ($result as $k => $v) {
                $$k = stripslashes($v);
            }
            $imageLink = $imagePath . $result['ImageLink'];
        } else {
            // Handle no results found
            echo "No data found.";
        }
    } else {
        // Handle query error
        echo "Query failed: " . $conn->error;
    }
}
?>

<div class="div">
    <div class="div-2">Payment Details</div>
    <div class="div-3">
        <div class="div-4">BANKS</div>
        <?php if ($imageLink) : ?>
            <img src="<?php echo $imageLink; ?>" alt="Bank Image" class="img">
        <?php endif; ?>
        <form action="" id="item-form">
            <input type="hidden" name="banks" id="databankid" value="<?php echo isset($DatabankID) ? $DatabankID : '' ?>">
            <div class="div-5">Card Number</div>
            <input class="div-6" type="text" name="CardNumber" placeholder="Card Number" value="<?php echo isset($CardNumber) ? $CardNumber : "" ?>" required>
            <div class="div-7">
                <div class="div-8">
                    <div class="div-9">Expired Date</div>
                    <input class="div-10" type="text" name="ExpiredDate" placeholder="MM/YY" value="<?php echo isset($ExpiredDate) ? $ExpiredDate : "" ?>" required>
                </div>
                <div class="div-11">
                    <div class="div-12">CVV</div>
                    <input class="div-13" type="text" name="CVV" placeholder="CVV" value="<?php echo isset($CVV) ? $CVV : "" ?>" required>
                </div>
            </div>
            <div class="div-14">Card Owner</div>
            <input class="div-15" type="text" id="CardOwner" name="CardOwner" placeholder="Card Owner" value="<?php echo isset($CardOwner) ? $CardOwner : "" ?>" required>
            <div class="div-17">
                <button type="submit" class="div-16 invoicesbank" data-apid="<?php echo $ap_id; ?>">PAY</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.invoicesbank').click(function(event) {
            event.preventDefault(); // Prevent the default form submission
            var DatabankID = $(this).data('databankid');
            var ap_id = $(this).data('apid'); // Get the ap_id
            uni_modal_view("<i class='fa fa-plus'></i> Data Banks", "Payment/invoicesbanks.php?&id=" + ap_id); // Append ap_id to the URL
        });
        // Ensure DataTables is loaded only if needed
        if ($('.table').length) {
            $('.table th,.table td').addClass('px-1 py-0 align-middle');
            $('.table').dataTable();
        }
    });
</script>