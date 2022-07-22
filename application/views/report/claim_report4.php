<?php $this->load->model('claim_model'); ?>
	<style>
		.buttonexport {
			margin-top: 1.8em;
			margin-left: 14em;
		}

		.buttonsubmit {
			margin-top: 1.8em;
		}
	</style>
<div width='100%'>
	<div class="page-title" width='100%'>
		<div class="title_left" width='100%'>
			<h3>Claim Monthly Report4</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Product List Section -->
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<?php echo form_open($current_url, array('class' => 'form-horizontal', 'method' => 'get')); ?>
						<div class="row">
              <div class="form-group col-sm-3">
								<?php echo form_label('Claim Created From Date:', 'start_dt', array("class" => 'col-sm-12'));   ?>
								<div class="input-group date">
									<?php echo form_input("start_dt", $this->input->get('start_dt'), array("class" => "form-control datepicker required", 'placeholder' => 'From Date')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								<?php echo form_error("dob"); ?>
							</div>
							<div class="form-group col-sm-3">
								<?php echo form_label('Claim Created To Date:', 'end_dt', array("class" => 'col-sm-12'));   ?>
								<div class="input-group date">
									<?php echo form_input("end_dt", $this->input->get('end_dt'), array("class" => "form-control datepicker required", 'placeholder' => 'To Date')); ?>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								<?php echo form_error("dob"); ?>
							</div>
							<div class="form-group col-sm-3">
                <?php echo form_label('Year:', 'year', array("class" => 'col-sm-12'));   ?>
								<div class="input-group">
  								<?php echo form_dropdown ( "year", $yearlist, $this->input->get("year"), array('class' => 'form-control') ); ?>
								</div>
								<?php echo form_error("dob"); ?>
							</div>
							<div class="form-group col-sm-3">
                <?php echo form_label('Claim Status:', 'status2', array("class" => 'col-sm-12')); ?>
								<div class="input-group">
                  <?php echo form_dropdown("status2", array('' => 'select status', 'Open' => 'Open', 'Reopen' => 'Reopen', 'Closed' => 'Closed', 'Denied' => 'Denied'), $this->input->get('status2'), array("class" => 'form-control change_claim_status2')); ?>
                </div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-9">
                <?php echo form_label('Products:', 'product_short', array ("class" => 'col-sm-12')); ?>
                <?php $curproducts = empty($this->input->get('products[]')) ? array() : $this->input->get('products[]');?>
                <?php foreach ($products as $key => $val) { ?>
                <span style="margin-left: 1em;">
                <input type="checkbox" name="products[]" value="<?php echo $key; ?>" <?php if (in_array($key, $curproducts)) { echo "checked"; } ?> /> <?php echo $key; ?>
                </span>
                <?php } ?>
							</div>
							<div class="form-group col-sm-3">
              <?php echo form_label('Insurer:', 'up_insuer', array("class" => 'col-sm-12')); ?>
								<div class="input-group">
                  <?php echo form_dropdown("up_insuer", $up_insuer_list, $this->input->get("up_insuer"), array("class" => 'form-control')); ?>
                </div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6">
								&nbsp;
							</div>
							<div class="form-group col-sm-3">
								<a class="btn btn-primary buttonexport" href="<?php echo $export_url; ?>" target="_blank">Export</a>
							</div>
							<div class="form-group col-sm-3">
								<button class="btn btn-primary buttonsubmit" name="submit" value="1">Submit</button>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	<!-- End List Section -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_content">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>Insurer</th>
                  <th>Product</th>
                  <th>Last Name</th>
                  <th>First Name</th>
                  <th>Policy Number</th>
                  <th>Sum Insured</th>
                  <th>Policy Start Date</th>
                  <th>Province</th>
                  <th>Claim number</th>
                  <th>Claim Type</th>
                  <th>Claim Loss Date</th>
                  <th>Claim Status</th>
                  <th>Process Status</th>
                  <th>Created Date</th>
                  <th>Closed Date</th>
                  <th>Days Opened</th>
                  <th>Claim Denied Reason</th>
                  <th>Other Reasons</th>
                  <th>Total Claimed Amount</th>
                  <th>Reserve</th>
                  <th>Diminishing Reserve</th>
                  <th>Total Amount Paid</th>
                  <th>Incurred</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($records as $value) { ?>
                  <?php $diminishing = 0; ?>
                  <?php if (($value['status2'] != 'Closed') && ($value['status2'] != 'Denied')) { $diminishing = $value['reserve_amount'] - $value['paied_amount']; } ?>
                  <?php $incurred = $diminishing + $value['paied_amount']; ?>
                  <?php 
                    $province = empty($value['province'])?"":$value['province'];
                    if (!empty($this->data['provinces'][$province])) {
                      $province = $this->data['provinces'][$province];
                    }
                    $province = ucfirst(strtolower($province));
                  ?>
                  <tr>
                    <td><?php echo $value['up_insuer']; ?></td>
                    <td><?php echo $value['product_short']; ?></td>
                    <td><?php echo $value['insured_last_name']; ?></td>
                    <td><?php echo $value['insured_first_name']; ?></td>
                    <td><?php echo $value['policy_no']; ?></td>
                    <td><?php echo number_format($value['sum_insured'], 2); ?></td>
                    <td><?php echo $value['effective_date']; ?></td>
                    <td><?php echo $province; ?></td>
                    <td><?php echo $value['claim_no']; ?></td>
                    <td><?php echo $value['package']; ?></td>
                    <td><?php echo $value['date_symptoms']; ?></td>
                    <td><?php echo $value['status2']; ?></td>
                    <td><?php echo $value['status']; ?></td>
                    <td><?php echo substr($value['created'], 0, 10); ?></td>
                    <td><?php echo substr($value['last_update'], 0, 10); ?></td>
                    <td><?php echo empty($value['opendays'])?0:($value['opendays']+1); ?></td>
                    <td><?php echo ($value['status2'] == 'Closed')?"":$value['denied_reason']; ?></td>
                    <td><?php echo $value['notes']; ?></td>
                    <td><?php echo number_format($value['claimed_amount'], 2); ?></td>
                    <td><?php echo number_format($value['reserve_amount'], 2); ?></td>
                    <td><?php echo number_format($diminishing, 2); ?></td>
                    <td><?php echo number_format($value['paied_amount'], 2); ?></td>
                    <td><?php echo number_format($incurred, 2); ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url() ?>/assets/js/jquery.validate.min.js"></script>
<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
	function is_examiner_test() {
		var v = $('input[name=is_examiner]:checked').val();
		if (v == 1) {
			$('#examiner_div').show();
		} else {
			$('#examiner_div').hide();
		}
	}
	$(document).ready(function() {
		is_examiner_test();
		$(".datepicker").datepicker({
			startDate: '-20y',
			endDate: '+0d',
		});
		$('input[name=is_examiner]').on('change', function() {
			is_examiner_test();
		});
	});
</script>
