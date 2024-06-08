<?php
require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `banks`");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
}
?>

<style>
    .div {
        background-color: var(--jay, #ffffff);
        display: flex;
        max-width: 465px;
        height: 600px;
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
        width: 400px;
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

<div class="div">
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bank = $_POST['banks'];
        $cardNumber = $_POST['card-number'];
        $expiredDate = $_POST['expired-date'];
        $cvv = $_POST['cvv'];
        $cardOwner = $_POST['card-owner'];

        // Validasi data
        $errors = [];
        if (empty($bank) || empty($cardNumber) || empty($expiredDate) || empty($cvv) || empty($cardOwner)) {
            $errors[] = "Semua data wajib diisi!";
        }

        $bank = $conn->real_escape_string($bank);
        $cardNumber = $conn->real_escape_string($cardNumber);
        $expiredDate = $conn->real_escape_string($expiredDate);
        $cvv = $conn->real_escape_string($cvv);
        $cardOwner = $conn->real_escape_string($cardOwner);


        if (empty($errors)) {
            $sql = "INSERT INTO databanks (ImageLink, CardNumber, ExpiredDate, CVV, CardOwner) 
                    VALUES ('$bank', '$cardNumber', '$expiredDate', '$cvv', '$cardOwner')";

            if ($conn->query($sql) === TRUE) {
                // Redirect to invoicesbanks.php after saving data to the database
                header("Location: payments/invoicesbanks.php?ImageLink=$bank");
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        }
    }
    ?>

    <div class="div-2">Payment Details</div>
    <div class="div-3">
        <div class="popup" id="popup">
            <div>
                <div class="div-4">BANKS</div>
                <?php

                // Check if bank is set and it's a valid image
                if (isset($_GET['banks'])) {
                    $imageName = $_GET['banks'];
                    $fullImagePath = "../dist/images/" . $imageName;

                    // Check if the image exists
                    if (file_exists($fullImagePath)) {
                        echo '<img loading="lazy" srcset="' . $fullImagePath . '" class="img" />';
                    } else {
                        echo "Image not found.";
                    }
                } else {
                    echo "Bank not selected.";
                }
                ?>

                <form method="post" action="">
                    <input type="hidden" name="banks" id="banks" value="<?php echo isset($_GET['banks']) ? $_GET['banks'] : ''; ?>">

                    <div class="div-5">Card Number</div>
                    <input class="div-6" type="text" id="card-number" name="card-number" placeholder="Card Number" required></input>
                    <div class="div-7">
                        <div class="div-8">
                            <div class="div-9">Expired Date</div>
                            <input class="div-10" type="text" id="expired-date" name="expired-date" placeholder="MM/DD" required></input>
                        </div>
                        <div class="div-11">
                            <div class="div-12">CVV</div>
                            <input class="div-13" type="text" id="cvv" name="cvv" placeholder="CVV" required></input>
                        </div>
                    </div>
                    <div class="div-14">Card Owner</div>
                    <input class="div-15" type="text" id="card-owner" name="card-owner" placeholder="Card Owner" required></input>

                    </div>
                        <!-- <div class="div-17"> -->
                        <button type="submit" class="div-16">PAY</button>
                    </div>
                </form>
            </div>
        </div>
</div>
</div>

</body>

</html>