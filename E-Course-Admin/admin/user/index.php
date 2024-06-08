<?php
$user = $conn->query("SELECT * FROM employees where employee_id ='" . $_settings->userdata('employee_id') . "'");
foreach ($user->fetch_array() as $k => $v) {
	$meta[$k] = $v;
}

$login_types = array(
	'1' => 'Administrator',
	'2' => 'Sales Person',
	'3' => 'Procurement Staff'
);

if (isset($_GET['id']) && $_GET['id'] > 0) {
	$user = $conn->query("SELECT e.*, j.title as login_type FROM employees e LEFT JOIN jobpositions j ON e.job_position_id = j.job_position_id WHERE e.employee_id ='{$_GET['id']}'");
	if ($user->num_rows > 0) {
		$meta = $user->fetch_assoc();
	}
}
?>
<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">
				<input type="hidden" name="employee_id" value="<?php echo $_settings->userdata('employee_id') ?>">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name'] : '' ?>" required>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email'] : '' ?>">
				</div>
				<div class="form-group">
					<label for="phone">Phone</label>
					<input type="text" name="phone" id="phone" class="form-control" value="<?php echo isset($meta['phone']) ? $meta['phone'] : '' ?>">
				</div>
				<div class="form-group">
					<label for="address">Address</label>
					<input type="text" name="address" id="address" class="form-control" value="<?php echo isset($meta['address']) ? $meta['address'] : '' ?>">
				</div>
				<div class="form-group">
					<label for="job_position_id">Job Position</label>
					<input type="text" name="job_position_id" id="job_position_id" class="form-control" value="<?php echo $job_position_title ?>" readonly>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
					<small><i>Leave this blank if you don't want to change the password.</i></small>
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
		<div class="col-md-12">
			<div class="row">
				<button class="btn btn-sm btn-primary" form="manage-user">Update</button>
			</div>
		</div>
	</div>
</div>
<style>
	img#cimg {
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	$('#manage-user').submit(function(e) {
		e.preventDefault();
		var _this = $(this);
		start_loader();
		$.ajax({
			url: _base_url_ + 'classes/Users.php?f=save',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					location.reload();
				} else {
					$('#msg').html('<div class="alert alert-danger">Email already exists</div>');
					end_loader();
				}
			}
		});
	});
</script>