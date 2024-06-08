<?php
include "conn.php";

// Query to retrieve video details
$sql = "SELECT * FROM video";
$result = $conn->query($sql);

// Check if query was successful
if ($result->num_rows > 0) {
    // Fetch data from the first row
    $row = $result->fetch_assoc();

    // Assign fetched data to variables
    $videoTitle = $row['video_title'];
    // $viewsCount = $row['views_count'];
    $uploadDate = $row['upload_date'];
    $videoDescription = $row['description'];
    // $videoLink = $row['video_link'];

    // Sample dynamic video segments array
    // $videoSegments = array(
    //     array("time" => 0, "title" => "Introduction", "thumbnail" => "../assets/images/1.png"),
    //     array("time" => 15, "title" => "Topic 1", "thumbnail" => "../assets/images/2.jpg"),
    //     array("time" => 30, "title" => "Topic 2", "thumbnail" => "../assets/images/3.jpg")
    // );

    // Function to format view count with commas
    function formatViews($views)
    {
        return number_format($views);
    }

    // Function to format date
    function formatDate($date)
    {
        return date("F j, Y", strtotime($date));
    }

    // Sample rating variables
    $likes = 500;
    $dislikes = 100;

    // Sample comments array
    $comments = array(
        array("user" => "John", "comment" => "Great video!"),
        array("user" => "Alice", "comment" => "I learned a lot from this."),
        array("user" => "Bob", "comment" => "Could be better.")
    );
} else {
    echo "0 results";
}
?>

<html lang="en">

<head>
    <!-- Metadata -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Stylesheets -->
    <link href="../pages/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.css">
    <link href="../node_modules/video.js/dist/video-js.css" rel="stylesheet">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Title -->
    <title>Document</title>
</head>

<body class="flex">

    <?php
    // Include sidebar content
    include 'sidebar2.php'; ?>

    <div class="flex-1 w-screen">
        <div class="container mx-auto px-4 flex mt-10">
            <div class=" w-full"> <!-- Adjusted max-w-screen-xl -->
                <div class="flex">
                    <div class="w-full mr-8">
                        <!-- Video Player -->
                        <video id="my-video" class="video-js vjs-big-play-centered w-full" controls preload="auto" poster="">
                            <source src="<?php echo $videoLink; ?>" type="video/mp4">
                        </video>
                        <!-- Video Information -->
                        <div class="flex items-center justify-between mt-4">
                            <div>
                                <h2 class="text-xl"><?php echo $videoTitle; ?></h2>
                                <div class="flex items-center mt-2">
                                    <!-- <span class="text-gray-600 mr-3"><?php echo formatViews($viewsCount); ?> views</span> -->
                                    <span class="text-gray-600"><?php echo formatDate($uploadDate); ?></span>
                                </div>
                            </div>
                            <!-- Video Rating -->
                            <div class="flex items-end mt-5 mr-5">
                                <form method="post" action="">
                                    <button type="submit" name="like" class="mr-2">
                                        <i class="fas fa-thumbs-up"></i> <?php echo $likes; ?>
                                    </button>
                                    <button type="submit" name="dislike">
                                        <i class="fas fa-thumbs-down"></i> <?php echo $dislikes; ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <hr class="my-4 border-gray-300"> <!-- Add a line here -->
                        <!-- Video Description -->
                        <p class="text-gray-600"><?php echo $videoDescription; ?></p>
                    </div>

                    <!-- Video Segments -->
                    <ul class="bg-black w-80 rounded-md justify-center items-center mt-0 ml-auto"> <!-- Adjusted margin to ml-auto -->
                        <li class="mb-2 mt-2 bg-gray">
                            <div class="text-center">
                                <h1 class="text-white hover:text-gray-200">Segment</h1>
                            </div>
                        </li>
                        <?php foreach ($videoSegments as $segment) : ?>
                            <li class="flex items-center justify-between mb-2 mt-2 ml-2">
                                <div class="flex items-center">
                                    <img src="<?php echo $segment['thumbnail']; ?>" alt="<?php echo $segment['title']; ?> Thumbnail" class="w-24 h-12 rounded-md mr-3">
                                    <button onclick="seekToTime(<?php echo $segment['time']; ?>)" class="text-white hover:text-gray-200 text-sm"><?php echo $segment['title']; ?> (<?php echo gmdate("i:s", $segment['time']); ?>)</button>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php include 'navbar.php'; ?>
    </div>

    <!-- Bottom Navigation -->

    <!-- JavaScript -->
    <script src="/node_modules/video.js/dist/video.min.js"></script>
    <script src="./js/index.js"></script>
    <script>
        function seekToTime(time) {
            var player = videojs('my-video');
            player.currentTime(time);
        }
    </script>
</body>

</html>