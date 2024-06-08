<?php
require_once('../config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./css/invoicesbanks.css">
</head>

<body>
  <?php
  $imageLink = $_GET['ImageLink'];

  // Mengambil nama bank berdasarkan ImageLink
  $sql_bank = "SELECT BanksName FROM banks WHERE ImageLink = '$imageLink'";
  $result_bank = mysqli_query($conn, $sql_bank);
  $row_bank = mysqli_fetch_assoc($result_bank);
  $nama_bank = $row_bank['BanksName'];

  ?>

  <div class="div">
    <div class="card-container">
      <div class="div-2">Invoices</div>
      <div class="div-3">
        <!-- muncul nama bank, data dari table banks -->
        <div class="div-4"><?php echo $nama_bank ?></div>
        <div class="div-5">
          <p class="p1">Congratulations!!!</p>
          <p class="p2">Successful for Payment</p>
          <p class="p3">You have a Pro Account Now</p>
        </div>
    </div>
    </div>
      <div class="div-20" onclick="ok()">OK</div>
   
  </div>


</body>
<script>
    function ok() {
        window.location.href = "homepage.php"; 
    }
</script>

</html>
