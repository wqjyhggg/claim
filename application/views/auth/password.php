<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Change Password</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="alert-error"><p><?php echo $my_message; ?></p></div>
	
	<!-- search section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<?php echo form_open("auth/password", array('class'=>'form-horizontal', 'method'=>'post')); ?>
					<div class="row">
						<div class="form-group col-sm-3">
							<?php echo form_label('Current Password', 'cur_password', array("class"=>'col-sm-12'));?>
							<div class="col-sm-12 input-group">
								<?php echo form_input(array('name' => 'cur_password', 'class' => 'form-control', 'type' => 'password'));?>
							</div>
						</div>
						<div class="col-sm-3 form-group">
							<?php echo form_label('Password', 'password', array("class"=>'col-sm-12'));?>
							<div class="col-sm-12 input-group">
								<?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password'));?>
							</div>
						</div>
						<div class="col-sm-3 form-group">
							<?php echo form_label('Confirm Password', 'password_confirm', array("class"=>'col-sm-12'));?>
							<div class="col-sm-12 input-group">
								<?php echo form_input(array('name' => 'password_confirm', 'class' => 'form-control', 'type' => 'password'));?>
							</div>
						</div>
						<div class="col-sm-3 form-group">
							<br />
							<div class="col-sm-12 input-group">
								<?php echo form_submit('submit', "Submit", array("class"=>'btn btn-primary'));?>
							</div>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	<!-- end of search section -->
	<div class="clearfix"></div>
</div>
<script>
