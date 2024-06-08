<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Material</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div class="container-fluid">
				<table class="table table-hover table-striped">
					<colgroup>
						<col width="5%">
						<col width="15%">
						<col width="20%">
						<col width="20%">
						<col width="10%">
						<col width="10%">
						<col width="20%">
					</colgroup>
					<thead>
						<tr class="bg-navy disabled">
							<th>#</th>
							<th>Date Created</th>
							<th>Material Name</th>
							<th>Description</th>
							<th>Category</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT m.*, c.category_name FROM `material` m LEFT JOIN `category_material` c ON m.category_id = c.category_id ORDER BY m.date_created ASC");
						while ($row = $qry->fetch_assoc()) :
							$row['description'] = html_entity_decode($row['description']);
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
								<td><?php echo $row['material_name'] ?></td>
								<td class='truncate-3' title="<?php echo $row['description'] ?>"><?php echo $row['description'] ?></td>
								<td><?php echo $row['category_name'] ?></td>
								<td class="text-center">
									<?php if ($row['status'] == 1) : ?>
										<span class="badge badge-success">Active</span>
									<?php else : ?>
										<span class="badge badge-secondary">Inactive</span>
									<?php endif; ?>
								</td>
								<td align="center">
									<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon py-0" data-toggle="dropdown">
										Action
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" role="menu">
										<a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['material_id'] ?>"><span class="fa fa-info text-primary"></span> View</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['material_id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['material_id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
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
			_conf("Are you sure to delete this Item permanently?", "delete_item", [$(this).attr('data-id')])
		})
		$('.view_data').click(function() {
			uni_modal("<i class='fa fa-info-circle'></i> Material's Details", "items/view_details.php?id=" + $(this).attr('data-id'), "")
		})
		$('#create_new').click(function() {
			uni_modal("<i class='fa fa-plus'></i> Create New Material", "items/manage_item.php")
		})
		$('.edit_data').click(function() {
			uni_modal("<i class='fa fa-edit'></i> Edit Material's Details", "items/manage_item.php?id=" + $(this).attr('data-id'))
		})
		$('.table th,.table td').addClass('px-1 py-0 align-middle')
		$('.table').dataTable();
	})

	function delete_item($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_item",
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