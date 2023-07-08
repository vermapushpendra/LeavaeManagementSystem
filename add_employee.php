<?php
require('top.inc.php');
$name = '';
$email = '';
$mobile = '';
$department_id = '';
$id = '';
if (isset($_GET['id'])) {
	$id = mysqli_real_escape_string($con, $_GET['id']);
	if ($_SESSION['ROLE'] == 2 && $_SESSION['USER_ID'] != $id) {
		die('Access denied');
	}
	$res = mysqli_query($con, "select * from employee where id='$id'");
	$row = mysqli_fetch_assoc($res);
	$name = $row['name'];
	$email = $row['email'];
	$mobile = $row['mobile'];
	$department_id = $row['department_id'];
}
if (isset($_POST['submit'])) {
	$name = mysqli_real_escape_string($con, $_POST['name']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$mobile = mysqli_real_escape_string($con, $_POST['mobile']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$department_id = mysqli_real_escape_string($con, $_POST['department_id']);

	if ($id > 0) {
		$sql = "update employee set name='$name',email='$email',mobile='$mobile',password='$password',department_id='$department_id' where id= '$id'";
	} else {
		$sql = "insert into employee(name,email,mobile,password,department_id,role) values('$name','$email','$mobile','$password','$department_id','2')";
	}
	mysqli_query($con, $sql);
	header('location:employee.php');
	die();
}
?>

<div class="content pb-0">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header"><strong>Profile</strong></div>
					<div class="card-body card-block">
						<form method="post">
							<div class="form-group">
								<label class=" form-control-label">Name</label>
								<input type="text" value="<?php echo $name ?>" name="name" placeholder="Enter name" class="form-control" <?php echo ($_SESSION['ROLE'] != 1) ? 'readonly' : '' ?> required>
							</div>
							<div class="form-group">
								<label class=" form-control-label">Email</label>
								<input type="email" value="<?php echo $email ?>" name="email" placeholder="Enter email" class="form-control" <?php echo ($_SESSION['ROLE'] != 1) ? 'readonly' : '' ?> required>
							</div>
							<div class="form-group">
								<label class=" form-control-label">Mobile</label>
								<input type="text" value="<?php echo $mobile ?>" name="mobile" placeholder="Enter mobile" class="form-control" <?php echo ($_SESSION['ROLE'] != 1) ? 'readonly' : '' ?> required>
							</div>

							<div class="form-group">
								<label class=" form-control-label">Password</label>
								<input type="password" name="password" id="" placeholder="Enter password" class="form-control" <?php echo ($_SESSION['ROLE'] != 1) ? 'readonly' : '' ?> required>
							</div>

							<div class="form-group">
								<label class=" form-control-label">Department</label>
								<select name="department_id" required class="form-control" <?php echo ($_SESSION['ROLE'] != 1) ? 'disabled' : '' ?>>
									<option value="">Select Department </option>

									<?php
									$res = mysqli_query($con, "select * from department order by department desc");
									while ($row = mysqli_fetch_assoc($res)) {
										if ($department_id == $row['id']) {
											echo "<option selected='selected' value=" . $row['id'] . ">" . $row['department'] . "</option>";
										} else {
											echo "<option value=" . $row['id'] . ">" . $row['department'] . "</option>";
										}
									}




									?>
								</select>
								<br>
								<?php if ($_SESSION['ROLE'] == 1) { ?>
									<button type="submit" name="submit" class="btn btn-lg btn-info btn-block">
										<span id="payment-button-amount">Submit</span>
									</button>
								<?php } ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
require('footer.inc.php');
?>