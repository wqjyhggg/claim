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
						<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_INSURER, Users_model::GROUP_EXAMINER, Users_model::GROUP_MANAGER))) { ?> 
						<ul>
							<li style='line-height: 2em;'><?php echo anchor("report/phonestatus", ' Phone Status</a>', array("class"=>'leftmeun h4', 'target' => 'phonestatus')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/cases", ' Case Report</a>', array("class"=>'leftmeun h4')) ?> </li>
						</ul>
						<ul>
							<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_EXAMINER, Users_model::GROUP_MANAGER))) { ?>
							<li style='line-height: 2em;'><?php echo anchor("report/claim_summary", ' Claim Summary Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/claims", ' Case & CLaim Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/exceptionals", ' CLaim Exceptional Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/recoveries", ' Recovery Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<?php if (0) { ?>
							<li style='line-height: 2em;'><?php echo anchor("report/payables", ' Payable Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/agents", ' Agent Working Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<?php } ?>
							<li style='line-height: 2em;'><?php echo anchor("report/reserve", ' Reserve Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/claim_review", ' Large Loss Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/expenses", ' Claim Summary Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/expenses2", ' Claim Summary Report2</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/claim_sla", ' Claim SLA Report</a>', array("class"=>'leftmeun h4')) ?> </li>
						</ul>
						<ul>
              <li style='line-height: 2em;'><?php echo anchor("report/phone_online", ' EAC Phone Online Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/agent_activity", ' Agent Activity Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/agent_performance", ' Agent Performance Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/phone_report", ' Phone Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/phone_waiting", ' Phone Waiting Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/phone_queue", ' Phone Queue Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/phone_abandon", ' Phone Abandon Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<li style='line-height: 2em;'><?php echo anchor("report/phone_response", ' Phone Response Report</a>', array("class"=>'leftmeun h4')) ?> </li>
							<?php } ?>
						</ul>
						<?php } else if ($this->ion_auth->in_group(array(Users_model::GROUP_EAC))) { ?> 
						<ul>
							<li style='line-height: 2em;'><?php echo anchor("report/phonestatus", ' Phone Status</a>', array("class"=>'leftmeun h4', 'target' => 'phonestatus')) ?> </li>
						</ul>
						<?php } ?> 
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