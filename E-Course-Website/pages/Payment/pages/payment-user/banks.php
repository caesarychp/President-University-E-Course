<?php
require_once('../config.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banks Payments</title>
    <link rel="stylesheet" href="./css/banks.css">
</head>

<body>

    <div class="div">
        <div class="card-container">
            <div class="div-2">Payment Details</div>
         
            <div class="div-3">
                <div class="div-4">BANKS</div>
           


            <div class="frame1">
                <div class="frame2">
                    <?php
                    $imagePath = "./images/";
                    // Function to generate image HTML
                    function getImageHTML($imageName)
                    {
                        global $imagePath;
                        return '<a href="databanks.php?banks=' . $imageName . '"><img loading="lazy" srcset="' . $imagePath . $imageName . '" class="img" /></a>';

                        // $fullImagePath = $imagePath . $imageName; // Concatenate directory path with filename
                        // return '<img loading="lazy" srcset="' . $fullImagePath . '" class="img" />';
                    }
                    $sql = "SELECT BanksID, BanksName, ImageLink FROM banks";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
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
        </div>