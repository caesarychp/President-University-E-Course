<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>

<style>
	.img-avatar {
		width: 45px;
		height: 45px;
		object-fit: cover;
		object-position: center center;
		border-radius: 100%;
	}
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of System Employees</h3>
		<div class="card-tools">
			<a href="?page=user/manage_user" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="10%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="5%">
				</colgroup>
				<thead>
					<tr class="bg-navy disabled">
						<th class="text-center">#</th>
						<th class="text-center">Employee ID</th>
						<th class="text-center">Name</th>
						<th class="text-center">Job Position</th>
						<th class="text-center">Address</th>
						<th class="text-center">Email</th>
						<th class="text-center">Contact</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					// $qry = $conn->query("SELECT e.*, j.title AS job_title FROM employees e LEFT JOIN jobpositions j ON e.job_position_id = j.job_position_id WHERE e.employee_id = '1' AND e.employee_id != '{$_settings->userdata('employee_id')}' AND e.job_position_id != 1 ORDER BY e.employee_id ASC");
					$qry = $conn->query("SELECT e.*, j.title AS job_title FROM employees e LEFT JOIN jobpositions j ON e.job_position_id = j.job_position_id  ORDER BY e.employee_id ASC");
					while ($row = $qry->fetch_assoc()) :
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?php echo $row['employee_id'] ?></td>
							<td class="text-center"><?php echo ucwords($row['name']) ?></td>
							<td class="text-center"><?php echo $row['job_title'] ?></td>
							<td class="text-center"><?php echo $row['address'] ?></td>
							<td class="text-center"><?php echo $row['email'] ?></td>
							<td class="text-center"><?php echo $row['phone'] ?></td>
							<td class="text-center">
								<button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
									Action
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
								<a class="dropdown-item" href="?page=user/manage_user&id=<?php echo $row['employee_id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['employee_id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('.delete_data').click(function() {
			_conf("Are you sure to delete this Employee permanently?", "delete_employee", [$(this).attr('data-id')]);
		});
		$('.table th,.table td').addClass('px-1 py-0 align-middle');
		$('.table').dataTable();
	});

	function delete_employee($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Users.php?f=delete_users",
			method: "POST",
			data: {
				id: $id
			},
			dataType: "json",
			error: function(err) {
				console.log(err);
				alert_toast("An error occurred.", 'error');
				end_loader();
			},
			success: function(resp) {
				if (resp.status == 'success') {
					location.reload();
				} else {
					alert_toast("An error occurred.", 'error');
				}
				end_loader();
			}
		});
	}
</script>