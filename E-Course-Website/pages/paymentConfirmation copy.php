<?php
include_once "conn.php";

// Check if 'PlanID' parameter is set in the URL
if (isset($_GET['PlanID'])) {
    // 'PlanID' parameter is provided, retrieve its value
    $customPlanID = intval($_GET['PlanID']);

    // Prepare and execute the SQL query to fetch price and plan name based on the custom plan ID
    $sql = "SELECT plan_name, Price FROM membershipplans WHERE PlanID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customPlanID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $planName = htmlspecialchars($row['plan_name'], ENT_QUOTES, 'UTF-8');
        $price = $row['Price'];
    } else {
        $planName = "Plan Not Found";
        $price = 0;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // 'PlanID' parameter is not provided, handle this case
    $planName = "Plan ID not provided";
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
            <form action="process_payment.php" method="post">
                <input type="hidden" id="selectedBank" name="selected_bank">
                <input type="hidden" id="amount" name="amount" value="<?php echo htmlspecialchars($price, ENT_QUOTES, 'UTF-8'); ?>">

                <select class="card-select" onchange="updateImage(event)" name="methodID">
                    <option value="default">Select Bank</option>
                    <option value="bni">BNI</option>
                    <option value="bca">BCA</option>
                    <option value="bri">BRI</option>
                    <option value="bsi">BSI</option>
                    <option value="mandiri">Mandiri</option>
                    <option value="mandirisyariah">Mandiri Syariah</option>
                </select>

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
                <div class="amount-label">Plan: <?php echo htmlspecialchars($planName, ENT_QUOTES, 'UTF-8'); ?> (Total Amount: $<?php echo htmlspecialchars($price, ENT_QUOTES, 'UTF-8'); ?>)</div>
                <input type="submit" value="PAY">
            </form>
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
                cardImage.style.display = "block";
            } else {
                cardImage.style.display = "none";
            }
        }
    </script>
</body>

</html>