<?php $this->load->model('mytask_model'); ?>
<div>
	<div class="page-title">
		<div class="title_left"><h3>Reports</h3></div>
	</div>
	<div class="clearfix"></div>
	<!-- Product List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="table-responsive">
						<ul>
							<li><?php echo anchor("report/cases", ' Case Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li><?php echo anchor("report/claims", ' CLaim Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN))) { ?>
							<li><?php echo anchor("report/agents", ' Agent Working Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End List Section -->
</div>
<script>
$(document).ready(function() {
});
</script>