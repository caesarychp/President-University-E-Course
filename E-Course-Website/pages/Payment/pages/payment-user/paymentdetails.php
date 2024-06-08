<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payments Details</title>
  <link rel="stylesheet" href="./css/paymentsdetails.css">
</head>

<body>
  <div class="div">
      <div class="card-container">
          <div class="div-2">Payment Details</div>
        
          <!-- images banks -->
          <div class="div-3">
            <button class="div-4" onclick="Banks()">BANKS</button>
          </div>

          <!-- images ewallet -->
          <div class="div-3">
            <button class="div-4" onclick="Ewallet()">E-WALLET</button>
          </div>
      </div>
  </div>



  <script>
    function Banks() {
      window.location.href = "http://localhost/webiste-ecourse/webiste/pages/banks.php";
    }
  </script>

  <script>
    function Ewallet() {
      window.location.href = "http://localhost//webiste-ecourse/webiste/ewallet.php";
    }
  </script>
</body>

</html>