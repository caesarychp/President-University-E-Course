<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo htmlspecialchars($_settings->flashdata('success'), ENT_QUOTES, 'UTF-8'); ?>", 'success');
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Sales</h3>
	</div>
	<div class="card-body">
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
					if ($qry) {
						while ($row = $qry->fetch_assoc()) :
					?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td class="text-center"><?php echo date("M d, Y H:i", strtotime($row['OrderDate'])); ?></td>
								<td class="text-center"><?php echo "SO" . htmlspecialchars($row['OrderID'], ENT_QUOTES, 'UTF-8'); ?></td>
								<td class="text-center"><?php echo htmlspecialchars($row['plan_name'], ENT_QUOTES, 'UTF-8'); ?></td>
								<td class="text-center"><?php echo "Rp" . number_format($row['Amount'], 2); ?></td>
								<td class="text-center"><?php echo htmlspecialchars($row['InvoiceID'], ENT_QUOTES, 'UTF-8'); ?></td>
								<td class="text-center">
									<?php
									switch ($row['Status']) {
										case 'Active':
											echo '<span class="badge badge-success">Active</span>';
											break;
										case 'Cancelled':
											echo '<span class="badge badge-danger">Cancelled</span>';
											break;
										default:
											echo '<span class="badge badge-primary">Procesing</span>';
											break;
									}
									?>
								</td>
								<td align="center">
									<div class="dropdown">
										<button class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Action
										</button>
										<div class="dropdown-menu" role="menu">
											<a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo htmlspecialchars($row['OrderID'], ENT_QUOTES, 'UTF-8'); ?>"><span class="fa fa-info text-primary"></span> View</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo htmlspecialchars($row['OrderID'], ENT_QUOTES, 'UTF-8'); ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo htmlspecialchars($row['OrderID'], ENT_QUOTES, 'UTF-8'); ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
										</div>
									</div>
								</td>
							</tr>
					<?php
						endwhile;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('.delete_data').click(function() {
			_conf("Are you sure to delete this Sales Order permanently?", "delete_so", [$(this).attr('data-id')])
		})
		$('.view_data').click(function() {
			uni_modal_view("<i class='fa fa-info-circle'></i> Sales Order's Details", "sales_order/view_so.php?id=" + $(this).attr('data-id'), "")
		})
		$('.edit_data').click(function() {
			uni_modal("<i class='fa fa-edit'></i> Edit Sales Orders's Details", "sales_order/manage_so.php?id=" + $(this).attr('data-id'))
		})
		$('.table th,.table td').addClass('px-1 py-0 align-middle')
		$('.table').dataTable();
	})

	function delete_so($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_so",
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