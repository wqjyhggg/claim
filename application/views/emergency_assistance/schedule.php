<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Work Schedule</h3>
		</div>
	</div>
	<div class="clearfix"></div>

	<!-- Policy search and List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Schedule Calendar</h2>
					<div class="form-group col-sm-4 pull-right">
						<div class="form-group col-sm-3">
							<?php echo form_label('Employee:', 'emc', array("class" => 'col-sm-12')); ?>
							<?php $priority = array("" => '--Select Priority--', "HIGH" => 'High', "Normal" => 'Normal'); ?>
						</div>
						<div class="form-group col-sm-9">
							<select name="emc" class="form-control">
								<option value="">-- Select EAC --</option>
								<?php foreach ($eacs as $key => $val):?>
								<option value="<?php echo $val['id']; ?>" <?php if ($val['id'] == $this->input->get("emc")) { echo "selected"; } ?>><?php echo $val['email'] . " " . $val['shift']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<a href="javascript:void(0)" class="btn btn-primary pull-right auto-schedule"><i class="fa fa-clock-o"></i> Auto Schedule Whole EACs</a>
					<a href="javascript:void(0)" data-toggle="modal" data-target="#clear_schedule_template" class="btn btn-primary pull-right"><i class="fa fa-trash"></i>Clear Schedule</a>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="col-sm-12 calendar-data">
						<?php echo $calendar?>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Create Intake Form Modal -->
<div id="model_window" class="modal fade" role="dialog">
	<div class="modal-dialog  modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Create Schedule</h4>
			</div>
			<div class="modal-body">
				<?php if(!$emc): ?>
				<div class="row">
					<?php echo form_open("emergency_assistance/search_users", array("class"=>'form-horizontal', 'id'=>'search_users'));?>
					<div class="form-group col-sm-3">
						<?php echo form_input("last_name", $this->input->get("last_name"), array("class" => "form-control autocomplete_field",'placeholder' => 'Last Name')); ?>
					</div>
					<div class="form-group col-sm-3">
						<?php echo form_input("first_name", $this->input->get("first_name"), array("class" => "form-control autocomplete_field", 'placeholder' => 'First Name')); ?>
					</div>
					<div class="form-group col-sm-3">
						<?php echo form_input("email", $this->input->get("email"), array("class" => "form-control autocomplete_field", 'placeholder' => 'Email')); ?>
					</div>
					<div class="col-sm-3">
						<?php echo form_submit("Search", "Search", array("class"=>'btn btn-primary'))?>
						<?php echo form_reset("Reset", "Reset", array("class"=>'btn btn-info'))?>
					</div>
					<?php echo form_close(); ?>
				</div>
				<?php endif; ?>
				<div class="x_panel">
					<div class="x_title">
						<h2>
							Employee(s) Work Schedule<small></small>
						</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content search_users">
						<center><?php echo heading("No record available", 4); ?></center>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end intake form model here -->

<!-- Email print doc content here -->
<div id="clear_schedule_template" class="modal fade" role="dialog">
	<div class="modal-dialog ">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Clear EAC Schedule</h4>
			</div>
			<?php echo form_open("emergency_assistance/clear_schedule", array("id"=>'clear_schedule')); ?>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-sm-3">
						<?php echo form_label('Select Date:', 'selected_date', array("class" => 'col-sm-12')); ?>
						<?php echo form_input("selected_date", "", array("class" => "form-control required selected_date", 'placeholder' => 'Select Date')); ?>
						<?php echo form_error("selected_date"); ?>
					</div>
					<div class="form-group col-sm-6">
						<?php echo form_label('Select Week:', 'selected_week', array("class" => 'col-sm-12')); ?>
						<?php echo form_input("selected_week", "", array("class" => "form-control required selected_week", 'placeholder' => 'Select Week')); ?>
						<?php echo form_error("selected_week"); ?>
					</div>
					<div class="form-group col-sm-3">
						<?php echo form_label('Select Month:', 'selected_month', array("class" => 'col-sm-12')); ?>
						<?php echo form_input("selected_month", "", array("class" => "form-control required selected_month", 'placeholder' => 'Select Month')); ?>
						<?php echo form_error("selected_month"); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<label class="col-sm-12">&nbsp;</label>
				<button class="btn btn-primary save-intakeform">Submit</button>
				<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!-- end here -->

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<style>
.bootstrap-datetimepicker-widget .datepicker-days table tbody tr:hover {background-color: #eee;}
</style>
<script>
$(document).ready(function(){
	$(".selected_date").datepicker({
		startDate: '-105y',
		autoclose: true,
		endDate: '+2y',
	});

	$('.selected_month').datepicker({
		autoclose: true,
		minViewMode: 1,
		format: 'yyyy-mm'
	});

	$(".selected_week").datepicker({
		format: 'yyyy-mm-dd',
		forceParse :false
	}).on("changeDate", function(e) {
		// console.log(e.date);
		var date = e.date;
		startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
		endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+6);
		$('.selected_week').datepicker('update', startDate);
		$('.selected_week').val(startDate.getFullYear() + '-' + (startDate.getMonth() + 1) + '-' + startDate.getDate() + ' to ' + endDate.getFullYear() + '-' + (endDate.getMonth() + 1) + '-' + endDate.getDate()  );
	});
	reload_calendar()
})

var date, type, day;

// to check model should not open in blank dates
$(document).on("click", ".calendar td", function(){
	type = "date";
	if(!$(this).children("span").hasClass("day_listing") && !$(this).children("div").children("span").hasClass("day_listing")) {
		return false;
	} else {
		date = $(this).children("span.day_listing").html()?$(this).children("span.day_listing").html():$(this).children("div.today").children("span.day_listing").html();
		search_users(type);
	}
})

// onde user clicked on monday, tuesday.....
$(document).on("click", ".day_header", function(){
	type = "day";
	day = $(this).children("h4").text();
	search_users(type);
})

// on submit clear function
.on("submit", "#clear_schedule", function(e) {
	e.preventDefault();
	$.ajax({
		url: $(this).attr('action')+"?employee_id="+$("select[name=emc]").val(),
		method: "post",
		data: $(this).serialize(),
		beforeSend: function() {
			// show ajax loader here
			$("#clear_schedule").addClass("csspinner load1");
		},
		success: function(data) {
			// in succss place return responce to list
			$("#clear_schedule").removeClass("csspinner load1");

			// clear schedule
			$('#clear_schedule_template').modal('hide');

			// reload calendar
			reload_calendar()
		}
	})
})

// reset all fields
.on("click", "input[name=selected_date]", function() {
	$("input[name=selected_week], input[name=selected_month]").val('');
})
.on("click", "input[name=selected_week]", function() {
	$("input[name=selected_date], input[name=selected_month]").val('');
})
.on("click", "input[name=selected_month]", function() {
	$("input[name=selected_date], input[name=selected_week]").val('');
})

// save schedule of employees
$(document).on("change", ".select_schedule", function() {
	// show trash button
	if($(this).val()) {
		$(this).parent("div").parent("div").children(".col-sm-2").show();
	} else {
		$(this).parent("div").parent("div").children(".col-sm-2").hide();
	}

	var schedule = $(this).val();
	var employee_id = $(this).attr("alt");
	var url = "<?php echo base_url("emergency_assistance/save_schedule/$year/$month"); ?>/" + date + '/' + type + '/' + day;
	var data = {employee_id:employee_id, schedule: schedule};
	$.ajax({
		url:url,
		method: "post",
		data:data,
		beforeSend: function() {
			// show ajax loader here
			$(".search_users").addClass("csspinner load1");
		},
		success: function(data) {
			// in succss place return responce to list
			$(".search_users").removeClass("csspinner load1");

			// reload calendar
			reload_calendar()
		}
	})
})

// fuzzy search
$(function() {
	$(".autocomplete_field").click(function() {
		var name = $(this).attr("name");
		$(".autocomplete_field").autocomplete({
			serviceUrl: "<?php echo base_url()."auth/autocomplete/"; ?>" + name+"/2",
			minLength: 2,
			dataType: "json",
		});
	});
});

// search users via ajax
$(document).on("submit", "#search_users", function(e) {
	e.preventDefault();
	search_users(type);
})

// search users request
function search_users(type){
	var url = "<?php echo base_url("emergency_assistance/search_users/$year/$month/$emc"); ?>/" + date + '/' + type + '/' + day;
	var data = $("#search_users").serialize();
	$.ajax({
		url:url,
		method: "post",
		data:data,
		beforeSend: function(){
			// show ajax loader here
			$(".search_users").addClass("csspinner load1");
		},
		success: function(data){
			// in succss place return responce to list
			$(".search_users").html(data);
			$(".search_users").removeClass("csspinner load1");
		}
	})
}

// reload calendar request
function reload_calendar(){
	var url = "<?php echo base_url("emergency_assistance/schedule_calendar/$emc/$year/$month/output"); ?>";
	$.ajax({
		url:url,
		beforeSend: function() {
			// show ajax loader here
			$(".calendar-data").addClass("csspinner load1");
		},
		success: function(data) {
			// in succss place return responce to list
			$(".calendar-data").html(data);
			$(".calendar-data").removeClass("csspinner load1");
			load_colors();
		}
	})
}

// remove schedule event
$(document).on("click", ".fa.fa-trash.row-link", function() {
	$(this).parent("div").parent("div").children(".col-sm-9").children("select.select_schedule").val("").trigger("change");
	$(this).parent("div").hide();
})

// once user change employee dropdown
.on("change", "select[name=emc]", function() {
	window.location = "<?php echo base_url("emergency_assistance/schedule") ?>?emc="+$(this).val();
})

// once user click on auto-schedule button
.on("click", ".auto-schedule", function() {
	if(confirm("Are you sure, you want to auto schedule whole emc? Schedule will be auto generated for all future dates for this month.")) {
		var url = "<?php echo base_url("emergency_assistance/auto_schedule/$emc/$year/$month"); ?>";
		$.ajax({
			url:url,
			beforeSend: function() {
				// show ajax loader here
				$(".right_col").addClass("csspinner load1");
			},
			success: function(data) {
				$(".right_col").removeClass("csspinner load1");
				if (data) {
					// in succss place return responce to list
					reload_calendar();
				} else {
					alert("Sorry, no auto schedule specified for this emc user. ");
					return false;
				}
			}
		})
	} else {
		return false;
	}
})

// put different-2 colors according to time schedule
.ready(function() {
    <?php if (!$this->ion_auth->is_casemamager() and !$this->ion_auth->is_admin()):?>
      $("td").removeAttr('data-toggle');
    <?php endif; ?>
    load_colors();
  })

  function load_colors(){
    $("li").each(function(){
      if($(this).text().indexOf('pm-8pm') > 0){
        $(this).addClass('red')
      }
      else if($(this).text().indexOf('pm-8am') > 0){
        $(this).addClass('green')
      }
    })
  }
</script>