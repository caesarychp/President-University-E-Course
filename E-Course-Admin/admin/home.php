<?php
function format_idr($amount)
{
  return 'Rp ' . number_format($amount, 0, ',', '.');
}
?>
<h1 class="text-dark">Welcome to <?php echo $_settings->info('name') ?></h1>
<hr class="border-dark">
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-handshake"></i></span>

      <div class="info-box-content">
        <a href="<?php echo base_url ?>admin/?page=vendor" style="color: black;">
          <span class="info-box-text">Total Vendors</span>
          <span class="info-box-number">
            <?php
            $vendor = $conn->query("SELECT * FROM vendor")->num_rows;
            echo number_format($vendor);
            ?>
          </span>
        </a>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-dolly-flatbed"></i></span>

      <div class="info-box-content">
        <a href="<?php echo base_url ?>admin/?page=vendor" style="color: black;">
          <span class="info-box-text">Receive Goods</span>
          <span class="info-box-number">
            <?php
            $receive = $conn->query("SELECT * from receive_goods ")->num_rows;
            echo number_format($receive);
            ?>
          </span>
        </a>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-file-invoice"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Approve P.O.</span>
        <span class="info-box-number">
          <?php
          $po_appoved = $conn->query("SELECT * FROM purchase_order where `status` =1 ")->num_rows;
          echo number_format($po_appoved);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-bill-alt"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Current Overall Budget</span>
        <span class="info-box-number text-right">
          <?php
          $cur_bul = $conn->query("SELECT sum(balance) as total FROM `categories_expenses` where status = 1 ")->fetch_assoc()['total'];
          echo format_idr($cur_bul);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
</div>
<!-- /.col -->
<div class="row">

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-day"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Today's Budget Entries</span>
        <span class="info-box-number text-right">
          <?php
          $today_budget = $conn->query("SELECT sum(amount) as total FROM `running_balance` where category_id in (SELECT id FROM categories_expenses where status =1) and date(date_created) = '" . (date("Y-m-d")) . "' and balance_type = 1 ")->fetch_assoc()['total'];
          echo format_idr($today_budget);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="clearfix hidden-md-up"></div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar-day"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Today's Budget Expenses</span>
        <span class="info-box-number text-right">
          <?php
          $today_expense = $conn->query("SELECT sum(amount) as total FROM `running_balance` where category_id in (SELECT id FROM categories_expenses where status =1) and date(date_created) = '" . (date("Y-m-d")) . "' and balance_type = 2 ")->fetch_assoc()['total'];
          echo format_idr($today_expense);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <h4>Current Budget in each Categories</h4>
    <hr>
  </div>
</div>
<div class="col-md-12 d-flex justify-content-center">
  <div class="input-group mb-3 col-md-5">
    <input type="text" class="form-control" id="search" placeholder="Search Category">
    <div class="input-group-append">
      <span class="input-group-text"><i class="fa fa-search"></i></span>
    </div>
  </div>
</div>
<div class="row row-cols-4 row-cols-sm-1 row-cols-md-4 row-cols-lg-4">
  <?php
  $categories = $conn->query("SELECT * FROM `categories_expenses` where status = 1 order by `category` asc ");
  while ($row = $categories->fetch_assoc()) :
  ?>
    <div class="col p-2 cat-items">
      <div class="callout callout-info">
        <span class="float-right ml-1">
          <button type="button" class="btn btn-secondary info-tooltip" data-toggle="tooltip" data-html="true" title='<?php echo (html_entity_decode($row['description'])) ?>'>
            <span class="fa fa-info-circle text-info"></span>
          </button>
        </span>
        <h5 class="mr-4"><b><?php echo $row['category'] ?></b></h5>
        <div class="d-flex justify-content-end">
          <b><?php echo format_idr($row['balance']) ?></b>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>
<div class="col-md-12">
  <h3 class="text-center" id="noData" style="display:none">No Data to display.</h3>
</div>
<script>
  function check_cats() {
    if ($('.cat-items:visible').length > 0) {
      $('#noData').hide('slow')
    } else {
      $('#noData').show('slow')
    }
  }
  $(function() {
    $('[data-toggle="tooltip"]').tooltip({
      html: true
    })
    check_cats()
    $('#search').on('input', function() {
      var _f = $(this).val().toLowerCase()
      $('.cat-items').each(function() {
        var _c = $(this).text().toLowerCase()
        if (_c.includes(_f) == true)
          $(this).toggle(true);
        else
          $(this).toggle(false);
      })
      check_cats()
    })
  })
</script>