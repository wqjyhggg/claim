<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Reports</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Product List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="table-responsive">
						<ul>
							<li style='line-height: 2em;'><?php echo anchor("report/cases", ' Case Report</a>', array("class"=>'leftmeun h4')) ?> </li>
						</ul>
						<ul>
							<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN))) { ?>
							<li style='line-height: 2em;'><?php echo anchor("report/claim_summary", ' Claim Summary Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/claims", ' Case & CLaim Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<?php if (0) { ?>
							<li style='line-height: 2em;'><?php echo anchor("report/receivables", ' Receivable Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/payables", ' Payable Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/agents", ' Agent Working Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<?php } ?>
							<li style='line-height: 2em;'><?php echo anchor("report/claim_review", ' Claim Medical Review</a>', array("class"=>'leftmeun h4')) ?> </li>
						</ul>
						<ul>
							<li style='line-height: 2em;'><?php echo anchor("report/agent_activity", ' Agent Activity Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/agent_performance", ' Agent Performance Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/phone_report", ' Phone Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/phone_waiting", ' Phone Waiting Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/phone_queue", ' Phone Queue Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/phone_abandon", ' Phone Abandon Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/phone_response", ' Phone Response Report</a>', array("class"=>'leftmeun h4')) ?> </li>
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