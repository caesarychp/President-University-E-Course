<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Sales</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div class="container-fluid">
				<table class="table table-hover table-striped">
					<colgroup>
						<col width="5%">
						<col width="20%">
						<col width="15%">
						<col width="20%">
						<col width="15%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr class="bg-navy disabled">
							<th class="text-center">#</th>
							<th class="text-center">Order Date</th>
							<th class="text-center">Order ID</th>
							<th class="text-center">Membership Plan</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Invoice ID</th>
							<th class="text-center">Status</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT so.*, mp.plan_name, i.InvoiceID FROM sales_orders so
                            LEFT JOIN membershipplans mp ON so.MembershipPlanID = mp.PlanID
                            LEFT JOIN invoices i ON so.InvoiceID = i.InvoiceID
                            ORDER BY so.OrderDate ASC");
						while ($row = $qry->fetch_assoc()) :
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td class="text-center"><?php echo date("M d, Y H:i", strtotime($row['OrderDate'])); ?></td>
								<td class="text-center"><?php echo "SO".$row['OrderID']; ?></td>
								<td class="text-center"><?php echo $row['plan_name']; ?></td>
								<td class="text-center"><?php echo "Rp". number_format($row['Amount'], 2); ?></td>
								<td class="text-center"><?php echo $row['InvoiceID']; ?></td>
								<td class="text-center">
									<?php
									switch ($row['Status']) {
										case 'Processing':
											echo '<span class="badge badge-primary">Processing</span>';
											break;
										case 'Active':
											echo '<span class="badge badge-success">Active</span>';
											break;
										case 'Cancelled':
											echo '<span class="badge badge-danger">Cancelled</span>';
											break;
										default:
											echo '<span class="badge badge-secondary">Pending</span>';
											break;
									}
									?>
								</td>
								<td align="center">
									<div class="dropdown">
										<button class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Action
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item" href="?page=purchase_orders/view_po&id=<?php echo $row['OrderID']; ?>"><span class="fa fa-eye text-primary"></span> View</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="?page=purchase_orders/manage_po&id=<?php echo $row['OrderID']; ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['OrderID']; ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
										</div>
									</div>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('.delete_data').click(function() {
			_conf("Are you sure to delete this rent permanently?", "delete_rent", [$(this).attr('data-id')])
		})
		$('.view_details').click(function() {
			uni_modal("Reservaton Details", "purchase_orders/view_details.php?id=" + $(this).attr('data-id'), 'mid-large')
		})
		$('.renew_data').click(function() {
			_conf("Are you sure to renew this rent data?", "renew_rent", [$(this).attr('data-id')]);
		})
		$('.table th,.table td').addClass('px-1 py-0 align-middle')
		$('.table').dataTable();
	})

	function delete_rent($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_rent",
			method: "POST",
			data: {
				id: $id
			},
			dataType: "json",
			error: err => {
				console.log(err)
				alert_toast("An error occured.", 'error');
				end_loader();
			},
			success: function(resp) {
				if (typeof resp == 'object' && resp.status == 'success') {
					location.reload();
				} else {
					alert_toast("An error occured.", 'error');
					end_loader();
				}
			}
		})
	}

	function renew_rent($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=renew_rent",
			method: "POST",
			data: {
				id: $id
			},
			dataType: "json",
			error: err => {
				console.log(err)
				alert_toast("An error occured.", 'error');
				end_loader();
			},
			success: function(resp) {
				if (typeof resp == 'object' && resp.status == 'success') {
					location.reload();
				} else {
					alert_toast("An error occured.", 'error');
					end_loader();
				}
			}
		})
	}
</script>