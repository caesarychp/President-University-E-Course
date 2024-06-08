<?php
require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `ewallet`");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
}
?>
<style>
    .div {
        /* background-color: var(--jay, #ffffff);
        display: flex;
        max-width: 465px;
        height: 600px;
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
        color: #000;
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
    <div class="div-4">E-WALLET</div>
  

    <div class="frame1">
    <div class="frame2">
       <?php
            $imagePath = "../dist/images/";
            // Function to generate image HTML
            function getImageHTML($imageName)
            {
                global $imagePath;
                return '<a href="./payment/dataewallet.php?ewallet=' . $imageName . '"><img loading="lazy" srcset="' . $imagePath . $imageName . '" class="img" /></a>';

                // $fullImagePath = $imagePath . $imageName; // Concatenate directory path with filename
                // return '<img loading="lazy" srcset="' . $fullImagePath . '" class="img" />';
            }
            $sql = "SELECT EwalletID, EwalletName, ImageLink FROM ewallet";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $imageName = $row["ImageLink"];
                    echo getImageHTML($imageName);
                }
            } else {
                echo "0 results";
            }

    ?>
        </div>
        </div>
    </div>
