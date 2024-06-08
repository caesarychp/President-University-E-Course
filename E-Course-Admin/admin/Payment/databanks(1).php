<?php
require_once('../../config.php');

// Check if 'banks' ID is provided and valid
if (isset($_GET['banks']) && is_numeric($_GET['banks']) && $_GET['banks'] > 0) {
    $bankID = $_GET['banks'];

    // Sanitize input to prevent SQL injection
    $bankID = $conn->real_escape_string($bankID);

    // Fetch data from databanks table based on BanksID
    $sql = "SELECT * FROM databanks WHERE BanksID = $bankID";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                $cardNumber = $row["CardNumber"];
                $expiredDate = $row["ExpiredDate"];
                $cvv = $row["CVV"];
                $cardOwner = $row["CardOwner"];

                // Display card details
                echo "<div class='div'>";
                echo "<div class='div-2'>Payment Details</div>";
                echo "<div class='div-3'>";
                echo "<div class='div-4'>BANKS</div>";

                echo "<p>Card Number: $cardNumber</p>";
                echo "<p>Expired Date: $expiredDate</p>";
                echo "<p>CVV: $cvv</p>";
                echo "<p>Card Owner: $cardOwner</p>";

                // Form for additional card details
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='banks' id='banks' value='" . htmlspecialchars($bankID) . "'>";

                echo "<div class='div-5'>Card Number</div>";
                echo "<input class='div-6' type='text' id='card-number' name='card-number' placeholder='Card Number' required>";

                echo "<div class='div-7'>";
                echo "<div class='div-8'>";
                echo "<div class='div-9'>Expired Date</div>";
                echo "<input class='div-10' type='text' id='expired-date' name='expired-date' placeholder='MM/DD' required>";
                echo "</div>";
                echo "<div class='div-11'>";
                echo "<div class='div-12'>CVV</div>";
                echo "<input class='div-13' type='text' id='cvv' name='cvv' placeholder='CVV' required>";
                echo "</div>";
                echo "</div>";
                echo "<div class='div-14'>Card Owner</div>";
                echo "<input class='div-15' type='text' id='card-owner' name='card-owner' placeholder='Card Owner' required>";

                echo "<div class='div-17'>";
                echo "<button type='submit' class='div-16'>PAY</button>";
                echo "</div>";
                echo "</form>";

                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No data found for this bank.";
        }
    } else {
        echo "Error fetching bank data: " . $conn->error;
    }
} else {
    echo "Invalid bank ID.";
}
?>

<!-- JS script -->
<script>
    // Add your JavaScript code here
</script>