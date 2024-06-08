<style>
  .div {
    background-color: var(--jay, #fff);
    display: flex;
    max-width: 463px;
    padding-bottom: 68px;
    flex-direction: column;
    font-weight: 400;
  }

  .div-2 {
    align-items: start;
    background-color: #293352;
    width: 100%;
    color: var(--puis-president-ac-id-12633333740234375-x-5413333129882812-default-nero, var(--jay, #fff));
    white-space: nowrap;
    justify-content: center;
    padding: 26px 29px;
    font: 20px/120% Roboto Slab, sans-serif;
  }

  .div-3 {
    display: flex;
    margin-top: 32px;
    width: 100%;
    flex-direction: column;
    color: var(--puis-president-ac-id-12633333740234375-x-5413333129882812-default-black, #000);
    padding: 0 39px;
  }

  .div-4 {
    font: 700 40px/60% Roboto Slab, sans-serif;
  }

  .div-5 {
    margin-top: 38px;
    font: 22px/109% Roboto Slab, sans-serif;
  }

  .div-6 {
    margin-top: 8px;
    font: 700 35px/69% Roboto Slab, sans-serif;
  }

  .div-7 {
    display: flex;
    margin-top: 45px;
    gap: 20px;
    font-size: 20px;
    line-height: 120%;
  }

  .div-8 {
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .div-9 {
    font-family: Roboto Slab, sans-serif;
  }

  .div-10 {
    font-family: Roboto Slab, sans-serif;
    margin-top: 22px;
  }

  .div-11 {
    font-family: Roboto Slab, sans-serif;
    margin-top: 22px;
  }

  .div-12 {
    font-family: Roboto Slab, sans-serif;
    margin-top: 18px;
  }

  .div-13 {
    font-family: Roboto Slab, sans-serif;
    margin-top: 17px;
  }

  .div-14 {
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .div-15 {
    font-family: Roboto Slab, sans-serif;
  }

  .div-16 {
    font-family: Roboto Slab, sans-serif;
    margin-top: 23px;
  }

  .div-17 {
    font-family: Roboto Slab, sans-serif;
    margin-top: 22px;
  }

  .div-18 {
    font-family: Roboto Slab, sans-serif;
    margin-top: 21px;
  }

  .div-19 {
    font-family: Roboto Slab, sans-serif;
    margin-top: 21px;
  }

  .div-20 {
    background-color: #293352;
    align-self: center;
    margin-top: 107px;
    width: 174px;
    max-width: 100%;
    align-items: center;
    color: var(--jay, #fff);
    white-space: nowrap;
    text-align: center;
    justify-content: center;
    padding: 22px 60px;
    font: 20px/120% Roboto Slab, sans-serif;
  }
</style>

<?php
require_once('../../config.php'); // Ensure you include your config file for database connection

// Check if 'id' is set in the URL and is a positive integer
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
  $ap_id = (int)$_GET['id']; // Cast to integer to sanitize input
  $qry = $conn->query("SELECT * FROM `accounts_payable` WHERE ap_id = '$ap_id'");

  if ($qry) {
    if ($qry->num_rows > 0) {
      $result = $qry->fetch_assoc();
      foreach ($result as $k => $v) {
        $$k = stripslashes($v);
      }
    } else {
      echo "No record found with ap_id = $ap_id";
    }
  } else {
    // Handle query error
    echo "Error: " . $conn->error;
  }
} else {
  echo "Invalid or missing ap_id parameter.";
}
?>

<?php if ($_settings->chk_flashdata('success')) : ?>
  <script>
    alert_toast("<?php echo $_settings->flashdata('success'); ?>", 'success');
  </script>
<?php endif; ?>

<div class="div">
  <div class="div-2">Invoices</div>
  <div class="div-3">
    <?php
    $qry = $conn->query("SELECT 
      po.*, 
      v.vendor_name AS vname, 
      m.material_name,
      SUM(po.quantity * po.price) AS total_amount
    FROM 
      `accounts_payable` ap
    INNER JOIN 
      `purchase_order` po ON ap.po_id = po.po_id
    INNER JOIN 
      `vendor` v ON po.vendor_id = v.vendor_id 
    INNER JOIN 
      `material` m ON po.material_id = m.material_id 
    WHERE 
      ap.ap_id = '$ap_id'
    GROUP BY 
      po.po_id 
    ORDER BY 
      po.po_id ASC");

    if ($qry) {
      while ($row = $qry->fetch_assoc()) :
    ?>
        <div class="div-5"><?php echo $row['material_name']; ?></div>
        <div class="div-6">Rp <?php echo number_format($row['total_amount']); ?></div>
        <div class="div-7">
          <div class="div-8">
            <div class="div-9">Order ID</div>
            <div class="div-10">Order Date</div>
            <div class="div-11">Quantity</div>
            <div class="div-13">Vendor</div>
          </div>
          <div class="div-14">
            <div class="div-15"><?php echo "PO" . $row['po_no']; ?></div>
            <div class="div-16"><?php echo date("M d,Y H:i", strtotime($row['date_created'])); ?></div>
            <div class="div-17"><?php echo $row['quantity']; ?></div>
            <div class="div-19"><?php echo $row['vname']; ?></div>
          </div>
        </div>
        <form id="item-invoices" method="POST">
          <!-- Add the form here -->
          <input type="hidden" name="id" value="<?php echo $ap_id; ?>">
          <!-- You can add additional fields if needed -->
          <button class="div-20" type="submit">OK</button>
          <!-- <div class="div-20" onclick="updateStatus(<?php echo $ap_id; ?>)">OK</div> -->
        </form>

    <?php
      endwhile;
    } else {
      echo "Error: " . $conn->error;
    }
    ?>
  </div>
</div>



<script>
  $(function() {
    $('#item-invoices').submit(function(e) {
      e.preventDefault();
      var _this = $(this);
      $('.err-msg').remove();
      start_loader();
      $.ajax({
        url: _base_url_ + "classes/Master.php?f=save_invoices",
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        dataType: 'json',
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
          var errorMessage = xhr.responseText.includes("<br>") ? xhr.responseText.split("<br />")[1].trim() : "An error occurred";
          alert_toast(errorMessage, 'error');
          end_loader();
        },
        success: function(resp) {
          if (typeof resp == 'object' && resp.status == 'success') {
            location.reload();
          } else if (resp.status == 'failed' && !!resp.msg) {
            var el = $('<div>');
            el.addClass("alert alert-danger err-msg").text(resp.msg);
            _this.prepend(el);
            el.show('slow');
            $("html, body").animate({
              scrollTop: 0
            }, "fast");
          } else {
            alert_toast("An error occurred", 'error');
            console.log(resp);
          }
          end_loader();
        }
      });
    });
  });
</script>