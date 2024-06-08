<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Method</title>
    <link rel="stylesheet" href="./css/method.css">
    <link rel="stylesheet" href="./css/homepage.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="brand">
            <img src="../assets/images/homepage/logo.png" alt="">
        </div>
        <!-- Navigation links -->
        <ul class="navlinks">
            <li><a href="#">Home</a></li>
            <li><a href="http://localhost:8080/eBusiness/webiste/pages/filter2.php">Courses</a></li>
            <li><a href="#">Lectures</a></li>
            <li><a href="#">Get Pro</a></li>
            <li><a href="#">Sign in</a></li>
        </ul>
    </nav>
    <h1 class="method">PAYMENT METHOD</h1>
    <div class="frame1">
        <div class="frame2">
            <?php
            include_once "conn.php";
            $imagePath = "../assets/images/";
            // Function to generate image HTML
            function getImageHTML($imageName)
            {
                global $imagePath;
                $fullImagePath = $imagePath . $imageName; // Concatenate directory path with filename
                return '<img loading="lazy" srcset="' . $fullImagePath . '" class="img" />';
            }

            // Fetch payment categories from the database
            $sqlCategories = "SELECT CategoryID, CategoryName FROM payment_category";
            $resultCategories = $conn->query($sqlCategories);

            // Check if there are payment categories
            if ($resultCategories->num_rows > 0) {
                // Loop through each category
                while ($category = $resultCategories->fetch_assoc()) {
                    $categoryId = $category['CategoryID'];
                    $categoryName = $category['CategoryName'];

                    // Fetch payment methods for the current category
                    $sqlMethods = "SELECT MethodID, MethodName, ImageLink FROM payment_methods WHERE CategoryID = $categoryId";
                    $resultMethods = $conn->query($sqlMethods);

                    // Display category name
                    echo '<div class="div-4">' . $categoryName . '</div>';
                    echo '<div class="div-5">';
                    echo '<div class="image">';

                    // Check if there are payment methods for the category
                    if ($resultMethods->num_rows > 0) {
                        // Loop through each payment method
                        while ($method = $resultMethods->fetch_assoc()) {
                            $methodID = $method['MethodID'];
                            $imageName = $method["ImageLink"];
                            echo '<a href="paymentConfirmation.php?method_id=' . $methodID . '">';
                            echo getImageHTML($imageName);
                            echo '</a>';
                        }
                    } else {
                        echo "No payment methods found for this category";
                    }

                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No payment categories found";
            }
            ?>

        </div>
    </div>

    <footer>
        <div class="footer">
            <?php
            // Display footer logo
            echo '<img loading="lazy" class="img" srcset="' . $imagePath . 'logoPU.png" />';
            ?>
            <div class="div-15">President University</div>
            <div class="div-16">E-Course</div>
            <div class="div-17">Accessibility</div>
            <div class="div-18">Privacy Policy</div>
            <div class="div-19">Terms of Use</div>
            <div class="div-20">EEA Privacy Disclosures</div>
        </div>
    </footer>
</body>

</html>
