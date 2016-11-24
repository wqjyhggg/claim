<?php
if($error = $this->session->flashdata("error")) {
	?>
	<div class="alert-error">
		<p><?php echo $error; ?></p>
	</div>
	<?php
}
if($error = validation_errors()) {
	?>
	<div class="alert-error">
		<p><?php echo $error; ?></p>
	</div>
	<?php
}
if($error = $this->ion_auth->errors()) {
	?>
	<div class="alert-error">
		<p><?php echo $error; ?></p>
	</div>
	<?php
}
if($success = $this->session->flashdata("success")) {
?>
	<div class="alert-success">
		<p><?php echo $success; ?></p>
	</div>
	<?php
}
?>