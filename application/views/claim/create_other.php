<div>
	<div class="page-title">
		<div class="title_left">
			<h3>New Claim</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Policy search and List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<h4>JF Canadian Travel Insurance</h4>
					<div class="row" style="margin-bottom: 15px;">
						<div class="col-sm-12">
							<?php echo anchor("claim/create_other/top_trip".$getpara, ' TOP Trip Cancellation and Intrruption Claim', array("class"=>'btn btn-primary create_claim'))?>
						</div>
						<div class="col-sm-12">
							<?php echo anchor("claim/create_other/top_medical".$getpara, ' TOP Medical Claim', array("class"=>'btn btn-primary create_claim'))?>
						</div>
						<div class="col-sm-12">
							<?php echo anchor("claim/create_other/top_baggage".$getpara, ' TOP Baggage Benefit Claim', array("class"=>'btn btn-primary create_claim'))?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url() ?>/assets/js/jQuery.print.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jquery.validate.min.js"></script>
