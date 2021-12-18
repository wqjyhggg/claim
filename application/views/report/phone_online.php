<?php $this->load->model('phone_model'); ?>
<div>
  <div class="page-title">
    <div class="title_left">
      <h3>Phone Online Report</h3>
    </div>
  </div>
  <div class="clearfix"></div>
  <!-- Product List Section -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_content">
          <!-- search filter start -->
          <?php echo form_open("", array('class' => 'form-horizontal', 'method' => 'get')); ?>
          <div class="row">
            <div class="form-group col-sm-3">
              <?php echo form_label('Phone Number:', 'phone', array("class" => 'col-sm-12')); ?>
              <select name="agent" class="form-control">
                <option value="">-- Select Phone Number--</option>
                <?php foreach ($phone_list as $val) { ?>
                  <option value="<?php echo $val; ?>" <?php if ($val == $this->input->get('agent')) {
                                                        echo "selected";
                                                      } ?>><?php echo $val; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group col-sm-3">
              <?php echo form_label('Date From:', 'start_dt', array("class" => 'col-sm-12')); ?>
              <div class="input-group date">
                <?php echo form_input("start_dt", $this->input->get("start_dt"), array("class" => "form-control datepicker", 'placeholder' => 'Date From')); ?>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
              </div>
            </div>
            <div class="form-group col-sm-3">
              <?php echo form_label('Date To:', 'end_dt', array("class" => 'col-sm-12')); ?>
              <div class="input-group date">
                <?php echo form_input("end_dt", $this->input->get("end_dt"), array("class" => "form-control datepicker", 'placeholder' => 'Date To')); ?>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
              </div>
            </div>
            <div class="clearfix"><br /></div>
            <div class="col-sm-11">
              <label class="col-sm-12">&nbsp;</label>
              <label class="col-sm-1">&nbsp;</label>
              <?php echo anchor($export_url, 'Export', array('title' => 'Export', 'class' => 'btn btn-primary')); ?>
              <button class="btn btn-primary pull-right" name="filter" value="1">Search</button>
            </div>
          </div>
          <?php echo form_close(); ?>
          <!-- search policy filter end -->
          <div class="clearfix"><br /></div>

          <?php if (!empty($records)) : ?>
            <div class="row">
              <div class="col-sm-12">
                <?php echo ($this->input->get("agent") ? "Phone Number : " . $this->input->get("agent") . " - " : "") . " Date : " . $start_dt . " to " . $end_dt; ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
              <table class="table">
                <tr>
                  <td><b>Phone Number</b></td>
                  <td><b>Start Time</b></td>
                  <td><b>End Time</b></td>
                  <td><b>Long</b></td>
                </tr>
                <?php foreach ($records as $rc) { ?>
                  <tr>
                    <td><?php echo $rc['agent']; ?></td>
                    <td><?php echo $rc['stm']; ?></td>
                    <td><?php echo $rc['etm']; ?></td>
                    <td><?php echo $rc['tiemlong']; ?></td>
                  </tr>
                <?php } ?>
              </table>
              </div>
            </div>
          <?php else : ?>
            <center><?php echo heading("No record available", 4); ?></center>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- End List Section -->
</div>
<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script src="<?php echo base_url() ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
  $(document).ready(function() {
    $(".datepicker").datepicker({
      format: "yyyy-mm-dd",
      endDate: '+0m'
    });
  });
</script>