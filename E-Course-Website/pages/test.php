<?php
// Define dropdown options
$dropdownOptions = array(
    array(
        "name" => "Video",
        "link" => "http://localhost:8080/eBusiness/webiste/pages/videoPlayer.php"
    ),
    array(
        "name" => "Summary",
        "link" => "http://localhost:8080/eBusiness/webiste/pages/summary.php"
    ),
    array(
        "name" => "Quiz",
        "link" => "#"
    )
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include Bootstrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="flex">

    <?php
    // Include sidebar content
    include 'sidebar.php'; ?>

    <div class="flex-1 bg-white p-10">
        <!-- Dropdown -->
        <div class="p-2.5 mt-3 flex items-center px-4 duration-300 cursor-pointer border border-black hover:bg-gray-700 text-black" onclick="dropdown2()">
            <!-- Icon and Topic 1 -->
            <div class="flex justify-start items-start">
                <span class="text-sm text-black mr-3" id="arrow2">
                    <i class="bi bi-chevron-right "></i>
                </span>
                <span class="text-sm font-bold">Topic 1</span>
            </div>
        </div>
        <!-- Submenu -->
        <div class="text-sm text-black font-bold text-start hidden" id="submenu2">
            <?php foreach ($dropdownOptions as $option) { ?>
                <div class="topic-header cursor-pointer" x-on:click="toggleTopic('topic1-content')">
                    <h3 class="text-xl font-semibold">Topic 1 - Introduction to Information System</h3>
                    <span class="status bg-green-600 text-white px-2 py-1 rounded-full text-lg">Finished</span>
                </div>
                <div id="topic1-content" class="topic-content">
                    <a href="video1.html" class="topic-item flex justify-between py-4 px-6 border-b border-gray-300 text-gray-700 transition-colors duration-300 ease-in-out hover:bg-gray-100">
                        <span>Video</span>
                        <span class="brief-info">Importance of Information Systems in modern organizations</span>
                        <span class="status bg-green-600 text-white px-2 py-1 rounded-full text-lg">Finished</span>
                    </a>
                    <a href="summary1.html" class="topic-item flex justify-between py-4 px-6 border-b border-gray-300 text-gray-700 transition-colors duration-300 ease-in-out hover:bg-gray-100">
                        <span>Summary</span>
                        <span class="brief-info">Summary Introduction to Information System</span>
                        <span class="status bg-green-600 text-white px-2 py-1 rounded-full text-lg">Finished</span>
                    </a>
                    <a href="./Quiz.html" class="topic-item flex justify-between py-4 px-6 border-b border-gray-300 text-gray-700 transition-colors duration-300 ease-in-out hover:bg-gray-100">
                        <span>Quiz</span>
                        <span class="brief-info">Basic Quiz of Information System</span>
                        <span class="status bg-green-600 text-white px-2 py-1 rounded-full text-lg">Finished</span>
                    </a>
                </div>
            <?php } ?>
        </div>

        <script src="./js/script1.js"></script>
        <script src="./js/index.js"></script>

</body>

</html>