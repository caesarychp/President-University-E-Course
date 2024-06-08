<?php
require_once('../config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <link rel="stylesheet" href="./css/databanks.css">

</head>

<body>
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

        if (empty($errors)) {
            $sql = "INSERT INTO databanks (ImageLink, CardNumber, ExpiredDate, CVV, CardOwner) 
                VALUES ('$bank', '$cardNumber', '$expiredDate', '$cvv', '$cardOwner')";

            if ($conn->query($sql) === TRUE) {
                // Redirect to invoicesbanks.php after saving data to the database
                header("Location: invoicesbanks.php?ImageLink=$bank");
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
        <div>
            <div>
                <div class="div-4">BANKS</div>
                <?php

                // Check if bank is set and it's a valid image
                if (isset($_GET['banks'])) {
                    $imageName = $_GET['banks'];
                    $fullImagePath = "./images/" . $imageName;

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