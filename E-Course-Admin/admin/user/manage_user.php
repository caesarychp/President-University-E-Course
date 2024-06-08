<?php

// Fetch job positions from the database
$job_positions = array();
$job_positions_query = $conn->query("SELECT * FROM jobpositions");
while ($row = $job_positions_query->fetch_assoc()) {
	$job_positions[$row['job_position_id']] = $row['title'];
}

// Fetch user data if editing an existing user
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$user_query = $conn->query("SELECT * FROM employees WHERE employee_id = '{$_GET['id']}'");
	if ($user_query->num_rows > 0) {
		$meta = $user_query->fetch_assoc();
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
				<input type="hidden" name="id" value="<?php echo isset($meta['employee_id']) ? $meta['employee_id'] : '' ?>">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name'] : '' ?>" required>
						</div>
						<div class="form-group">
							<label for="phone">Phone</label>
							<input type="text" name="phone" id="phone" class="form-control" value="<?php echo isset($meta['phone']) ? $meta['phone'] : '' ?>" required>
						</div>
						<div class="form-group">
							<label for="address">Address</label>
							<textarea name="address" id="address" class="form-control address-input" rows="3" required><?php echo isset($meta['address']) ? $meta['address'] : '' ?></textarea>
						</div>

					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email'] : '' ?>" required autocomplete="off">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off" <?php echo isset($meta['employee_id']) ? "" : 'required' ?>>
							<?php if (isset($_GET['id'])) : ?>
								<small><i>Leave this blank if you dont want to change the password.</i></small>
							<?php endif; ?>
						</div>
						<div class="form-group">
							<label for="job_position_id">Job Position</label>
							<select name="job_position_id" id="job_position_id" class="custom-select">
								<?php foreach ($job_positions as $id => $title) : ?>
									<option value="<?php echo $id; ?>" <?php echo isset($meta['job_position_id']) && $meta['job_position_id'] == $id ? 'selected' : ''; ?>><?php echo $title; ?></option>
								<?php endforeach; ?>
							</select>
						</div>

					</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
		<div class="col-md-12">
			<div class="row">
				<button class="btn btn-sm btn-primary mr-2" form="manage-user">Save</button>
				<a class="btn btn-sm btn-secondary" href="./?page=user/list">Cancel</a>
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

	.address-input {
		height: auto;
	}
</style>
<script>
	$('#manage-user').submit(function(e) {
		e.preventDefault();
		var formData = new FormData($(this)[0]); // Get form data
		var _this = $(this);
		start_loader();
		$.ajax({
			url: _base_url_ + 'classes/Users.php?f=save',
			data: formData, // Send form data
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					location.href = './?page=user/list';
				} else if (resp == 3) {
					$('#msg').html('<div class="alert alert-danger">Email already exists</div>');
					$("html, body").animate({
						scrollTop: 0
					}, "fast");
				} else {
					$('#msg').html('<div class="alert alert-danger">Error saving user details</div>');
					$("html, body").animate({
						scrollTop: 0
					}, "fast");
				}
				end_loader();
			},
			error: function(xhr, status, error) {
				$('#msg').html('<div class="alert alert-danger">Error occurred while processing request</div>');
				$("html, body").animate({
					scrollTop: 0
				}, "fast");
				end_loader();
			}
		});
	});
</script>