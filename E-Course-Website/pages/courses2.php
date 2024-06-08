<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    <title>Document</title>
</head>

<body class="flex">
    <?php
    // Include the database connection file
    include_once 'conn.php';
    
    // Define other variables
    $logoPath = "../assets/images/logo.png";
    $myCourses = "My courses";
    
    // Query to fetch weeks from the database
    $sql = "SELECT w.week_id, w.week_name, c.course_id, m.major_name, c.course_name
            FROM week w
            JOIN course c ON w.course_id = c.course_id
            JOIN major m ON c.major_id = m.major_id";
    $result = $conn->query($sql);
    
    // Initialize an empty array to store weeks
    $weeks = [];
    
    if ($result->num_rows > 0) {
      // Fetch data from each row and add it to the $weeks array
      while ($row = $result->fetch_assoc()) {
        $weeks[] = [
          "week_id" => $row['week_id'],
          "week_name" => $row['week_name'],
          "major_name" => $row['major_name'],
          "course_name" => $row['course_name'],
          "url" => "http://localhost:8080/eBusiness/website/pages/courses.php?week_id=" . $row['week_id']
        ];
      }
    }
    
    // If there are no weeks fetched, display a message or take appropriate action
    if (empty($weeks)) {
      echo "No weeks found.";
      // Handle the scenario where no weeks are found, redirect to an error page, or take appropriate action.
      exit(); // Terminate further execution of the script
    }
    
    // Get the URL of the first week to be displayed by default
    $default_week_url = $weeks[0]['url'];
    
    // Define other items
    $otherItems = [
      ["icon" => "bi bi-chat-left-text-fill", "text" => "Mentor Chat", "link" => "mentor.php"],
      ["icon" => "bi bi-bookmark-fill", "text" => "Certificate", "link" => "certificate.php"]
    ];
    
    $majorName = $weeks[0]['major_name'];
    $courseName = $weeks[0]['course_name'];
    ?>
    
    <!-- Component: Sidebar -->
    <div class="flex h-screen">
      <div class="flex-none w-60 bg-gray-700 text-white p-4 flex flex-col">
        <!-- Sidebar Header -->
        <div class="text-gray-100 text-xl">
          <div class="p-2.5 mt- flex items-center">
            <!-- Logo -->
            <img src="<?php echo $logoPath; ?>" class="px-2 py-1 rounded-md"></img>
            <!-- majorName -->
            <h1 class="font-bold text-gray-200 text-[15px] ml-3 text-center">
              <?php echo $majorName; ?>
            </h1>
          </div>
          <!-- Introduction Section -->
          <h1 class="text-center font-bold text-gray-200 text-[15px] ml-3">
            <?php echo $courseName; ?>
          </h1>
          <!-- Divider -->
          <div class="my-2 bg-gray-600 h-[1px]"></div>
        </div>
        <!-- Sidebar Content -->
        <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white" onclick="dropdown()">
          <!-- Icon -->
          <i class="bi bi-book-fill"></i>
          <!-- Text -->
          <div class="flex justify-between w-full items-center">
            <span class="text-[15px] ml-4 text-gray-200 font-bold"><?php echo $myCourses; ?></span>
            <!-- Arrow Icon -->
            <span class="text-sm rotate-180" id="arrow">
              <i class="bi bi-chevron-down"></i>
            </span>
          </div>
        </div>
        <!-- Dropdown Menu -->
        <div class=" mt-2 text-sm text-gray-200 overflow-x-auto whitespace-nowrap font-bold flex flex-wrap " id="submenu">
          <!-- Menu Items -->
          <?php foreach ($weeks as $week) : ?>
            <a href="<?php echo $week['url']; ?>" class="inline-block p-2 <?php echo ($week['url'] === $default_week_url) ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 text-gray-200'; ?> rounded-md"><?php echo $week['week_name']; ?></a>
          <?php endforeach; ?>
        </div>
        <!-- Other Sidebar Items -->
        <?php foreach ($otherItems as $item) : ?>
          <a href="<?php echo $item['link']; ?>" class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
            <i class="<?php echo $item['icon']; ?>"></i>
            <span class="text-[15px] ml-4 text-gray-200 font-bold"><?php echo $item['text']; ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    
    ?>

    <div class="flex-1 bg-white p-10">
        <?php
        include_once 'conn.php'; // Include the database connection file

        // Set the default week ID to 1 if not provided in the URL
        // $default_week_id = 1;

        // Check if the week_id parameter is provided in the URL, otherwise use the default week ID
        $week_id = isset($_GET['week_id']) ? intval($_GET['week_id']) : 1; // Assuming default week ID is 1 if not provided

        // Sanitize and validate user input to prevent SQL injection
        $week_id = $conn->real_escape_string($week_id);

        // Query to fetch content for the specified week from the database
        $sql = "SELECT w.week_id, w.week_name, t.topic_id, t.topic_name, s.summary_title, v.video_title, q.quiz_name
        FROM week w
        LEFT JOIN topic t ON w.week_id = t.week_id
        LEFT JOIN summary s ON t.topic_id = s.topic_id
        LEFT JOIN video v ON t.topic_id = v.topic_id
        LEFT JOIN quiz q ON t.topic_id = q.topic_id
        WHERE w.week_id = $week_id";

        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result) {
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    // Output topic and associated resources
                    echo "<div class='p-2.5 mt-3 flex items-center px-4 duration-300 cursor-pointer border border-black hover:bg-gray-700 text-black' onclick='dropdown2({$row['week_id']})'>
                    <div class='flex justify-start items-start'>
                        <span class='text-sm text-black mr-3' id='arrow2{$row['topic_id']}'>
                            <i class='bi bi-chevron-right'></i>
                        </span>
                        <span class='text-sm font-bold'>{$row['topic_name']}</span>
                    </div>
                </div>";

                    if ($row['video_title'] || $row['summary_title'] || $row['quiz_name']) {
                        echo "<div class='text-sm text-black font-bold text-start hidden' id='submenu2{$row['week_id']}'>"; // Open submenu div with inline style to hide it

                        // Output Video link if available
                        if ($row['video_title']) {
                            echo "<a href='http://localhost:8080/eBusiness/website/pages/videoPlayer.php?week_id={$week_id}' class='cursor-pointer p-2 hover:bg-blue-600 bg-white border border-black flex items-center justify-between relative'>
                            <div>
                                <i class='bi bi-play-circle-fill text-black mr-2'></i>
                                <span>{$row['video_title']}</span>
                            </div>
                            <span class='absolute top-0 left-0 right-0 h-1 bg-gradient-to-b from-transparent via-white to-white'></span>
                        </a>";
                        }

                        // Output Summary link if available
                        if ($row['summary_title']) {
                            echo "<a href='http://localhost:8080/eBusiness/website/pages/summary.php?week_id={$week_id}' class='cursor-pointer p-2 hover:bg-blue-600 bg-white border border-black flex items-center justify-between relative'>
                            <div>
                                <i class='bi bi-file-earmark-text-fill text-black mr-2'></i>
                                <span>{$row['summary_title']}</span>
                            </div>
                            <span class='absolute top-0 left-0 right-0 h-1 bg-gradient-to-b from-transparent via-white to-white'></span>
                        </a>";
                        }

                        // Output Quiz link if available
                        if ($row['quiz_name']) {
                            echo "<a href='#' class='cursor-pointer p-2 hover:bg-blue-600 bg-white border border-black flex items-center justify-between relative'>
                            <div>
                                <i class='bi bi-file-earmark-text-fill text-black mr-2'></i>
                                <span>{$row['quiz_name']}</span>
                            </div>
                            <span class='absolute top-0 left-0 right-0 h-1 bg-gradient-to-b from-transparent via-white to-white'></span>
                        </a>";
                        }

                        echo "</div>"; // Close submenu div
                    }
                }
            } else {
                echo "No content available for the selected week";
            }
        } else {
            echo "Error: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
        ?>

    </div>

    <script src="./js/index.js"></script>
</body>

</html>