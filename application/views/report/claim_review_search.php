<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Claim Medical Review</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Product List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<!-- search filter start -->
					<?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'get')); ?>
					<div class="row">
						<div class="form-group col-sm-3">
							<?php echo form_label('Claim No:', 'claim_no', array ("class" => 'col-sm-12')); ?>
							<?php echo form_input("claim_no", $this->input->get( "claim_no" ), array ("class" => "form-control")); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Case No:', 'case_no', array ("class" => 'col-sm-12')); ?>
							<?php echo form_input("case_no", $this->input->get( "case_no" ), array ("class" => "form-control")); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label('Policy No:', 'policy_no', array ("class" => 'col-sm-12')); ?>
							<?php echo form_input("policy_no", $this->input->get( "policy_no" ), array ("class" => "form-control")); ?>
						</div>
						<div class="form-group col-sm-3">
							<label class="col-sm-12">&nbsp;</label>
							<button class="btn btn-primary" name="filter" value="1">Search</button>
						</div>
					</div>
					<?php echo form_close(); ?>
					<!-- search policy filter end -->
					<div class="clearfix"><br /></div>

					<div class="table-responsive">
						<?php if(!empty($message)): ?>
						<center><?php echo heading("No record available", 4); ?></center>
						<?php else :?>
						<center><?php echo heading("Please input Claim No", 4); ?></center>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End List Section -->
</div>
<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
function scope_change() {
	var sls = $("select[name=scope]").val();
	if (sls == 'Claim') {
		$('#status_div').show();
	} else {
		$('#status_div').hide();
	}
}

$(document).ready(function() {
	$(".datepicker").datepicker({
		format: "yyyy-mm",
		viewMode: "months", 
	    minViewMode: "months",
	    endDate: '+0m'
    });
    
	$("select[name=scope]").change(scope_change);
	scope_change();
});
</script>