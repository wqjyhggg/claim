<?php $this->load->model('provider_model'); ?>
<style>
.modal-lg { width: 75%; }
</style>
<div>
	<div class="page-title">
		<div class="title_left">
			<h3><?php echo !empty($provider['id']) ? "Edit" : "Add"; ?> provider</h3>
      </div>
	</div>
	<div class="clearfix"></div>

	<!-- Policy search and List Section -->
	<div class="row">
		<div id="infoMessage"><?php echo $message;?></div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<!-- search policy filter start -->
					<?php echo form_open('provider/form', array('class'=>'form-horizontal')); ?>
					<?php echo form_hidden('id', $provider["id"]); ?>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Provider Name:', 'name', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("name", $provider["name"], array('placeholder'=>'Name')); ?>
							<?php echo form_error("name");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Status', 'status', array("class" =>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<select name="status" class="form-control" style="width: 17%; height: 28px; padding-top: 4px;">
								<option value="<?php echo Provider_model::ACTIVE; ?>"  <?php if ($provider["status"] == "<?php echo Provider_model::ACTIVE; ?>") { echo "selected"; } ?>><?php echo Provider_model::ACTIVE; ?></option>
								<option value="<?php echo Provider_model::DISABLE; ?>"  <?php if ($provider["status"] == "<?php echo Provider_model::DISABLE; ?>") { echo "selected"; } ?>><?php echo Provider_model::DISABLE; ?></option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Address:', 'address', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("address", $provider["address"], array('placeholder'=>'Address')); ?>
							<?php echo form_error("address");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Province:', 'province', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("province", $provider["province"], array('placeholder'=>'Province')); ?>
							<?php echo form_error("province");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Country:', 'country', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("country", $provider["country"], array('placeholder'=>'Country')); ?>
							<?php echo form_error("country");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Postcode:', 'postcode', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("postcode", $provider["postcode"], array('placeholder'=>'Postcode')); ?>
							<?php echo form_error("postcode");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Discount:', 'discount', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("discount", $provider["discount"], array('placeholder'=>'Discount')); ?>
							<?php echo form_error("discount");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Network Fee:', 'network_fee', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("network_fee", $provider["network_fee"], array('placeholder'=>'Network Fee')); ?>
							<?php echo form_error("network_fee");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Contact Person:', 'contact_person', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("contact_person", $provider["contact_person"], array('placeholder'=>'Contact Person')); ?>
							<?php echo form_error("contact_person");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Phone Number:', 'phone_no', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("phone_no", $provider["phone_no"], array('placeholder'=>'Phone Number')); ?>
							<?php echo form_error("phone_no");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Email:', 'email', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("email", $provider["email"], array('placeholder'=>'Email')); ?>
							<?php echo form_error("email");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('PPO Codes:', 'ppo_codes', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("ppo_codes", $provider["ppo_codes"], array('placeholder'=>'PPO Codes')); ?>
							<?php echo form_error("ppo_codes");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Services:', 'services', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("services", $provider["services"], array('placeholder'=>'Services')); ?>
							<?php echo form_error("services");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Latitude:', 'lat', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("lat", $provider["lat"], array('placeholder'=>'Latitude')); ?>
							<?php echo form_error("lat");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Longitude:', 'lng', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("lng", $provider["lng"], array('placeholder'=>'Longitude')); ?>
							<?php echo form_error("lng");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-2 ">
							<?php echo form_label('Priority:', 'priority', array("class"=>"pull-right")); ?>
						</div>
						<div class="form-group col-sm-10">
							<?php echo form_input("priority", $provider["priority"], array('placeholder'=>'Priority')); ?>
							<?php echo form_error("priority");?>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-6">
						</div>
						<div class="form-group col-sm-6">
							<label class="col-sm-12">&nbsp;</label>
							<button class="btn btn-primary">Save</button>
						</div>
						<div class="clearfix"></div>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
})
.on("click", ".move_down", function(){
	$(this).next("div.row").slideToggle();
	$(this).children("i").toggleClass("fa-angle-up").toggleClass("fa-angle-down");
})
// clicking on save assign button
// .on("click", ".mark_inactive", function(){
// 	if(!confirm("Are you sure you want to Deactivate case?")) {
// 		return false;
// 	}
// 	$.ajax({
//		url: "<?php echo base_url("emergency_assistance/update_case_status/D") ?>",
// 		method: "post",
//		data:{cases:"<?php echo $case_id; ?>"},
// 		beforeSend: function(){
// 			$(".right_col").addClass("csspinner load1");
// 		},
// 		success: function() {
// 			window.location.reload();
// 		}
// 	})
// })
</script>
