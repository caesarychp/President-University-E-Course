<?php
// Assuming you have established a database connection
include "conn.php";
// Custom plan ID
$customPlanID = 1; // Change this to your desired plan ID

// Fetch price and plan name based on the custom plan ID
$sql = "SELECT DurationMonths, Price FROM membershipplans WHERE PlanID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customPlanID);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $durationMonths = $row['DurationMonths'];
    $price = $row['Price'];
    $planName = $durationMonths . " Month" . ($durationMonths > 1 ? "s" : "");
} else {
    // Plan not found
    $planName = "Plan Not Found";
    $price = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <link rel="stylesheet" href="./css/paymentConfirmation.css">
</head>

<body>
    <h1>PAYMENT CONFIRMATION</h1>
    <div class="frame1">
        <div class="card-container">
            <form action="process_payment.php" method="post"> <!-- Form submits to process_payment.php -->
                <!-- Hidden input field for selected bank -->
                <input type="hidden" id="selectedBank" name="selected_bank">
                <!-- Hidden input field for the amount -->
                <input type="hidden" id="amount" name="amount" value="<?php echo $price; ?>">

                <!-- Bank selection dropdown -->
                <select class="card-select" onchange="updateImage(event)" name="methodID">
                    <option value="default">Select Bank</option>
                    <option value="bni">BNI</option>
                    <option value="bca">BCA</option>
                    <option value="bri">BRI</option>
                    <option value="bsi">BSI</option>
                    <option value="mandiri">Mandiri</option>
                    <option value="mandirisyariah">Mandiri Syariah</option>
                </select>

                <!-- Bank image -->
                <img class="card-image" id="card-image" src="" alt="Bank Image" style="display: none;">

                <label class="card-label" for="card-number">Nomor Kartu</label>
                <input class="card-input" type="text" id="card-number" name="card_number" placeholder="Nomor Kartu">
                <label class="card-label" for="card-holder">Nama Pemilik Kartu</label>
                <input class="card-input" type="text" id="card-holder" name="card_owner" placeholder="Nama">

                <div class="credit-card-inputs">
                    <div>
                        <label class="card-label" for="card-expiry">Tanggal Kadaluarsa</label>
                        <input class="card-input" type="date" id="expiration-date" name="expiration_date" placeholder="Tanggal Kadaluarsa" />
                    </div>
                    <div>
                        <label class="card-label" for="cvv">CVV</label>
                        <input class="card-input" type="text" id="cvv" name="cvv" placeholder="CVV" />
                    </div>
                </div>
                <!-- Display the amount and plan name -->
                <div class="amount-label">Plan: <?php echo $planName; ?> (Total Amount: $<?php echo $price; ?>)</div>
                <input type="submit" value="PAY"> <!-- Submit button -->
            </form>
        </div>

        <!-- Payment Confirmation Message -->
        <?php
        // if (isset($_GET['payment_status'])) {
        //     if ($_GET['payment_status'] == 'success') {
        //         echo '<p style="color: green;">Payment Successful!</p>';
        //         echo '<a href="invoice.php">Go to Invoices</a>';
        //     } else {
        //         echo '<p style="color: red;">Payment Failed!</p>';
        //     }
        // }
        ?>
    </div>
    </div>

    <footer>
        <div class="footer">
            <img loading="lazy" class="img" srcset="logoPU.png">
            <div class="div-15">President University</div>
            <div class="div-16">E-Course</div>
            <div class="div-17">Accessibility</div>
            <div class="div-18">Privacy Policy</div>
            <div class="div-19">Terms of Use</div>
            <div class="div-20">EEA Privacy Disclosures</div>
        </div>
    </footer>

    <script>
        function updateImage(event) {
            const selectedBank = event.target.value;
            let imageSrc = "";

            if (selectedBank === "bni") {
                imageSrc = "bni.png";
            } else if (selectedBank === "bca") {
                imageSrc = "bca.png";
            } else if (selectedBank === "bri") {
                imageSrc = "bri.png";
            } else if (selectedBank === "bsi") {
                imageSrc = "bsi.png";
            } else if (selectedBank === "mandiri") {
                imageSrc = "mandiri.png";
            } else if (selectedBank === "mandirisyariah") {
                imageSrc = "mandirisyariah.png";
            }

            const cardImage = document.getElementById("card-image");
            if (imageSrc !== "") {
                cardImage.src = "../assets/images/payment/" + imageSrc;
                cardImage.style.display = "block"; // Show the bank image
            } else {
                cardImage.style.display = "none"; // Hide the bank image if no bank is selected
            }
        }
    </script>
</body>

</html>