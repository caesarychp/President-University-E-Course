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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Selection</title>
    <script>
        function selectBank(banksID) {
            window.location.href = "databanks.php?DatabanksID=" + banksID;
        }
    </script>
    <style>
        .popup {
            width: 465px;
            height: 600px;
            background: #fff;
            border-radius: 5px;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.1);
            text-align: center;
            padding: 0 30px 30px;
            color: var(--jay, #fff);
            visibility: hidden;
            transition: transform 0.4s, top 0.4s;
            box-shadow: #000;
        }
        .open-popup {
            visibility: visible;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(1);
            display: block;
        }

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
</head>

<body>
    <div class="div">
        <div class="div-2">Payment Details</div>
        <div class="div-3">
            <div class="div-4" id="banks">BANKS</div>


        </div>
    </div>


    <div class="frame1">
        <!-- <div class="frame2"> -->
        <div id="container">
            <!-- <div id="popup" class="popup"> -->
                <?php
                $imagePath = "../dist/images/";
                // Function to generate image HTML

                function getImageHTML($imageName, $banksID)
                {
                    global $imagePath;
                    return '<a href="./payment/databanks.php?banksID=' . $banksID . '"><img loading="lazy" srcset="' . $imagePath . $imageName . '" onclick="imglink(this.href)" class="img"/></a>';
                }
                $sql = "SELECT BanksID, BanksName, ImageLink FROM banks";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $imageName = $row["ImageLink"];
                        $banksID = $row["BanksID"];
                        echo getImageHTML($imageName, $banksID);
                    }
                } else {
                    echo "0 results";
                }

                ?>
        
        </div>
    </div>
</body>

<script>
     let images = document.querySelectorAll('.img');
    images.forEach(function(image) {
        image.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default action of clicking a link
            imglink(event.target.parentNode.href); // Pass the href attribute of the clicked link to the imglink function
        });
    });

    function DataBanks() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                popup.innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "./payment/databanks.php", true);
        xhttp.send();
    }

    function imglink(href) {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("banks").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", href, true); // Load the href passed from the clicked link
        xhttp.send();
    }
</script>