<style>
    .div {
        background-color: var(--jay, #ffffff);
        display: flex;
        max-width: 463px;
        padding-bottom: 80px;
        flex-direction: column;
        align-items: center;
        font-size: 20px;
        color: var(--jay, #fff);
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

    .navlinks img {
        width: auto;
        height: auto;
    }

    .img {
        aspect-ratio: 2.78;
        object-fit: auto;
        /* object-position: center; */
        width: 150px;
        height: 60px;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        margin-top: 10px;
        max-width: 100%;
    }

    .frame1 {
        justify-content: center;
        align-items: center;
        text-align: center;
        display: flex;
        margin: 10px;

    }

    .frame2 {
        margin: 10px;
        justify-content: center;
        align-items: start;
        /* background-color:#a1bbf0; */
        display: flex;
        width: relative;
        flex-direction: column;
        padding: 10px;
        box-shadow: 0px 8px 16px 0px rgba(10, 147, 158, 0.24);
    }

    @media (max-width: 991px) {
        .div {
            max-width: 100%;
            padding: 0 20px;
        }
    }
</style>
<div class="div">
    <div class="div-2">Payment Details</div>
    <div class="div-3">
        <div class="div-4">BANKS</div>

        <div class="frame1">
            <div class="frame2">
                <?php
                // Function to generate image HTML
                require_once('../../config.php');
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $qry = $conn->query("SELECT * from `accounts_payable` where ap_id = '{$_GET['id']}' ");
                    if ($qry->num_rows > 0) {
                        foreach ($qry->fetch_assoc() as $k => $v) {
                            $$k = stripslashes($v);
                        }
                    }
                }

                function generateImageHTML($imageName, $imagePath, $banksID, $ap_id)
                {
                    return '<img loading="lazy" src="' . htmlspecialchars($imagePath . $imageName) . '" class="img data-banks" data-banksid="' . htmlspecialchars($banksID) . '" data-apid="' . htmlspecialchars($ap_id) . '" />';
                }

                $imagePath = "./Payment/images/"; // Updated path to your images folder
                $sql = "SELECT BanksID, BanksName, ImageLink FROM banks";
                $result = $conn->query($sql);

                if ($result) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $imageName = $row["ImageLink"];
                        $banksID = $row["BanksID"];
                        echo generateImageHTML($imageName, $imagePath, $banksID, isset($ap_id) ? $ap_id : '');
                    }
                } else {
                    echo "Error fetching banks.";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.data-banks').click(function() {
            var banksID = $(this).data('banksid');
            var ap_id = $(this).data('apid'); // Get the ap_id
            uni_modal_view("<i class='fa fa-plus'></i> Data Banks", "Payment/databanks.php?id=" + banksID + "&ap_id=" + ap_id); // Append po_id to the URL
        });
        // Ensure DataTables is loaded only if needed
        if ($('.table').length) {
            $('.table th,.table td').addClass('px-1 py-0 align-middle');
            $('.table').dataTable();
        }
    });
</script>