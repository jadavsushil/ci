
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/login/bootstrap.min.css">
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-sm-4">
			<?php
		    	if(validation_errors()){
		    		?>
		    		<div class="alert alert-info text-center">
		    			<?php echo validation_errors(); ?>
		    		</div>
		    		<?php
		    	}
 
				if($this->session->flashdata('message')){
					?>
					<div class="alert alert-info text-center">
						<?php echo $this->session->flashdata('message'); ?>
					</div>
					<?php
					unset($_SESSION['message']);
				}	
		    ?>
			<h3 class="text-center">Signup Form</h3>
			<form method="POST" action="<?php echo base_url().'user/register'; ?>">
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="text" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>">
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" class="form-control" id="password" name="password" value="<?php echo set_value('password'); ?>">
				</div>
				<div class="form-group">
					<label for="password_confirm">Confirm Password:</label>
					<input type="password" class="form-control" id="password_confirm" name="password_confirm" value="<?php echo set_value('password_confirm'); ?>">
				</div>
				<button type="submit" class="btn btn-primary">Register</button>
				<a href="<?= base_url('user/login') ?>">Login</a>
			</form>
			
		</div>
		
	</div>
</div>
</body>
</html>