<?php
// Define variables
$logoPath = "../assets/images/logo.png";
$title = "Information System";
$introduction = "Introduction Information System";
$courseTitle = "My courses";
$weeks = [
  ["name" => "Week 1", "url" => "http://localhost:8080/eBusiness/webiste/pages/courses.php"],
  ["name" => "Week 2", "url" => "http://localhost:8080/eBusiness/webiste/pages/courses.php"],
  ["name" => "Week 3", "url" => "http://localhost:8080/eBusiness/webiste/pages/courses.php"],
  ["name" => "Week 4", "url" => "http://localhost:8080/eBusiness/webiste/pages/courses.php"]
  // ["name" => "Week 5", "url" => "week5.php"]
];
$otherItems = [
  ["icon" => "bi bi-chat-left-text-fill", "text" => "Mentor Chat", "link" => "mentor.php"],
  ["icon" => "bi bi-bookmark-fill", "text" => "Certificate", "link" => "certificate.php"]
];
?>

<!-- Component: Sidebar -->
<div style="display: flex; height: 100vh;">
  <div style="flex: none; width: 60px; background-color: #4a5568; color: #fff; padding: 1rem; display: flex; flex-direction: column;">
    <!-- Sidebar Header -->
    <div style="color: #fff; font-size: 1.25rem; padding: 0.625rem 0; display: flex; align-items: center;">
      <!-- Logo -->
      <img src="<?php echo $logoPath; ?>" style="padding: 0.25rem 0.5rem; border-radius: 0.375rem;"></img>
      <!-- Title -->
      <h1 style="font-weight: bold; color: #cbd5e0; font-size: 0.9375rem; margin-left: 0.75rem; text-align: center;">
        <?php echo $title; ?>
      </h1>
    </div>
    <!-- Introduction Section -->
    <h1 style="text-align: center; font-weight: bold; color: #cbd5e0; font-size: 0.9375rem; margin-left: 0.75rem;">
      <?php echo $introduction; ?>
    </h1>
    <!-- Divider -->
    <div style="margin-top: 0.5rem; background-color: #4a5568; height: 1px;"></div>
    <!-- Sidebar Content -->
    <div style="padding: 0.625rem; margin-top: 0.375rem; display: flex; align-items: center; border-radius: 0.375rem; transition-duration: 0.3s; cursor: pointer; background-color: #4299e1; color: #fff;" onclick="dropdown()">
      <!-- Icon -->
      <i class="bi bi-book-fill"></i>
      <!-- Text -->
      <div style="flex: 1; display: flex; justify-content: space-between; align-items: center; margin-left: 0.25rem;">
        <span style="font-size: 0.9375rem; margin-left: 0.625rem; color: #cbd5e0; font-weight: bold;"><?php echo $courseTitle; ?></span>
        <!-- Arrow Icon -->
        <span style="font-size: 0.75rem; transform: rotate(180deg);">
          <i class="bi bi-chevron-down"></i>
        </span>
      </div>
    </div>
    <!-- Dropdown Menu -->
    <div style="margin-top: 0.25rem; font-size: 0.875rem; color: #cbd5e0; overflow-x: auto; white-space: nowrap; font-weight: bold; display: flex; flex-wrap: wrap;" id="submenu">
      <!-- Menu Items -->
      <?php foreach ($weeks as $week) : ?>
        <a href="<?php echo $week['url']; ?>" style="display: inline-block; padding: 0.5rem; background-color: #4299e1; border-radius: 0.375rem;" class=""><?php echo $week['name']; ?></a>
      <?php endforeach; ?>
    </div>
    <!-- Other Sidebar Items -->
    <?php foreach ($otherItems as $item) : ?>
      <a href="<?php echo $item['link']; ?>" style="padding: 0.75rem; margin-top: 0.375rem; display: flex; align-items: center; border-radius: 0.375rem; transition-duration: 0.3s; cursor: pointer; background-color: #4299e1; color: #fff;">
        <i class="<?php echo $item['icon']; ?>"></i>
        <span style="font-size: 0.9375rem; margin-left: 0.625rem; color: #cbd5e0; font-weight: bold;"><?php echo $item['text']; ?></span>
      </a>
    <?php endforeach; ?>
  </div>
</div>
