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
        include_once "conn.php";
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
                    header("Location: invoices.php?invoice_id=$bank");
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
                    <!-- <form action="process_payment.php" method="post">  Form submits to process_payment.php -->
                    <!-- Hidden input field for selected bank -->
                    <!-- <input type="hidden" id="selectedBank" name="selected_bank"> -->
                    <!-- Hidden input field for the amount -->
                    <!-- <input type="hidden" id="amount" name="amount" value="</?php echo $price; ?>"> -->

                    <form action="process_payment.php" method="post">
                        <input type="hidden" id="selectedBank" name="selected_bank">
                        <input type="hidden" id="amount" name="amount" value="<?php echo htmlspecialchars($price, ENT_QUOTES, 'UTF-8'); ?>">

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


                        <img class="card-image" id="card-image" src="" alt="Bank Image" style="display: none;">

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

                        <!-- <div class="div-17"> -->
                        <!-- Display the amount and plan name -->
                        <div class="amount-label">Plan: <?php echo $planName; ?> (Total Amount: $<?php echo $price; ?>)</div>
                        <input type="submit" class="div-16" value="PAY"> <!-- Submit button -->
                    </form>
                </div>
                        
                <!-- </div>
            <div class="amount-label">Plan: </?php echo htmlspecialchars($planName, ENT_QUOTES, 'UTF-8'); ?> (Total Amount: $<?php echo htmlspecialchars($price, ENT_QUOTES, 'UTF-8'); ?>)</div>
            <button type="submit" class="div-16">PAY</button> -->
                </form>
            </div>
        </div>
    </div>
    </div>

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