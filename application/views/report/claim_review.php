<?php $this->load->model('claim_model'); ?>
<div width='100%'>
	<div class="page-title" width='100%'>
		<div class="title_left" width='100%'>
			<h3 width='100%' style='text-align: center;'>Large Loss Report</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Product List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<div class="form-group col-sm-12">
					</div>
					<?php if (! $ispdf) { ?>
					<?php echo form_open($export_url, array('class'=>'form-horizontal', 'method'=>'post')); ?>
					<?php } ?>
					<div class="row">
						<?php if (! $ispdf) { ?>
						<div class="form-group col-sm-12">
							<button class="btn btn-primary pull-right" name="export" value="1">Export</button>
						</div>
						<?php } ?>
						<div class="form-group col-sm-12">
							<?php if (! $ispdf) { ?>
							<input type='hidden' name='claim_id' value='<?php echo $claim['id']; ?>'>
							<?php } ?>
						</div>
						<table class="table table-bordered col-sm-12"  border="1">
							<tbody>
								<tr>
									<td width='50%'><b>Claimant / Insured's Name :</b></td>
									<td><?php echo $claim['insured_first_name'] . " " . $claim['insured_last_name']; ?></td>
								</tr>
								<tr>
									<td width='50%'><b>Date of Birth / Age / Sex :</b></td>
									<td><?php echo $claim['dob'] . ", " . $claim['age'] . ", " . $claim['gender']; ?></td>
								</tr>
								<tr>
									<td width='50%'><b>Claim Number (Case Number):</b></td>
									<td><?php echo (empty($claim['claim_no']) ? "Not a Claim " : $claim['claim_no']) . "(" . $claim['case_no'] . ")"; ?></td>
								</tr>
								<tr>
									<td width='50%'><b>Other claims (related or unrelated) :</b></td>
									<td><?php echo $claim['other_claims']; ?></td>
								</tr>
								<tr>
									<td width='50%'><b>Policy number (as applicable) :</b></td>
									<td><?php echo $claim['policy_no']; ?></td>
								</tr>
								<tr>
									<td width='50%'><b>Product :</b></td>
									<td><?php echo $claim['product_full_name']; ?></td>
								</tr>
								<tr>
									<td width='50%'><b>Plan Type :</b></td>
									<td><?php echo empty($claim['policy_info']) ? '' : empty($claim['policy_info']['isfamilyplan']) ? 'Individual' : (($claim['policy_info']['isfamilyplan'] == 1) ? 'Family' : 'Group'); ?></td>
								</tr>
								<tr>
									<td width='50%'><b>Date of Application / Issue : (if applicable)</b></td>
									<td><?php echo empty($claim['policy_info']) ? '' : $claim['policy_info']['apply_date']; ?></td>
								</tr>
								<tr>
									<td width='50%'><b>Coverage Period :</b></td>
									<td><?php echo empty($claim['policy_info']) ? '' : $claim['policy_info']['effective_date'] . ' to ' . $claim['policy_info']['expiry_date']; ?></td>
								</tr>
								<tr>
									<td width='50%'><b>Travel Dates :</b></td>
									<?php if (! $ispdf) { ?>
									<td><input type='text' name='travel_dates' value='' class="form-control"></td>
									<?php } else { ?>
									<td><?php echo $this->input->post('travel_dates'); ?></td>
									<?php } ?>
								</tr>
								<tr>
									<td width='50%'><b>Date of Loss :</b></td>
									<td><?php echo empty($claim['expense']) ? '' : $claim['expense']['date_of_service']; ?></td>
								</tr>
								<tr>
									<td width='50%'><b>Travel Destination :</b></td>
									<td><?php echo $claim['street_address'] . ", " . $claim['city'] . ", " . $claim['province']; ?></td>
								</tr>
								<tr>
									<td width='50%'><b>Cause for Claim / Diagnosis :</b></td>
									<td><?php echo $claim['diagnosis']; ?></td>
								</tr>
								<tr>
									<td width='50%'><b>Reserve Amount :</b></td>
									<td><?php echo (($claim['status'] == Claim_model::STATUS_Paid) || ($claim['status'] == Claim_model::STATUS_Closed)) ? $claim['expenses_summary']['payable'] : $claim['expenses_summary']['claimed']; ?></td>
								</tr>
								<tr>
									<td width='50%'><b>Pre-existing Condition Period :</b></td>
									<?php if (! $ispdf) { ?>
									<td><input type='text' name='pre_existing' value='' class="form-control"></td>
									<?php } else { ?>
									<td><?php echo $this->input->post('pre_existing'); ?></td>
									<?php } ?>
								</tr>
								<tr>
									<td width='50%'><b>Late Notification of Claim (if applicable):</b></td>
									<?php if (! $ispdf) { ?>
									<td><input name='late_notification' value='' class="form-control"></td>
									<?php } else { ?>
									<td><?php echo $this->input->post('late_notification'); ?></td>
									<?php } ?>
								</tr>
							</tbody>
						</table>
						<br />

						<div class="form-group col-sm-12">
							<label for="medical_disclosure" class="col-sm-12"><b>Medical Disclosure By Insured / Claimant :</b></label>
							<?php if (! $ispdf) { ?>
							<textarea name='medical_disclosure' class="form-control" rows="5"></textarea>
							<?php } else { ?>
							<br />
							<?php echo $this->input->post('medical_disclosure'); ?>
							<?php } ?>
						</div>
						<br />

						<div class="form-group col-sm-12">
							<label for="review_objectives" class="col-sm-12"><b>Review Objective(s) :</b></label>
							<div class="form-group col-sm-12"><input type="checkbox" name="review_objectives_eligibility" <?php echo ($this->input->post('review_objectives_eligibility') ? 'checked="checked"' : ''); ?>> Eligibility to purchase the policy</div>
							<div class="form-group col-sm-12"><input type="checkbox" name="review_objectives_medical" <?php echo ($this->input->post('review_objectives_medical') ? 'checked="checked"' : ''); ?>> Medical Disclosure (Questionaire)</div>
							<div class="form-group col-sm-12"><input type="checkbox" name="review_objectives_pre_existing" <?php echo ($this->input->post('review_objectives_pre_existing') ? 'checked="checked"' : ''); ?>> Pre-existing Condition</div>
							<div class="form-group col-sm-12"><input type="checkbox" name="review_objectives_exclusions" <?php echo ($this->input->post('review_objectives_exclusions') ? 'checked="checked"' : ''); ?>> Policy Exclusions</div>
						</div>
						<br />

						<div class="form-group col-sm-12">
							<label for="details_noted" class="col-sm-12"><b>Details noted on Claim Form (if any) :</b></label>
							<?php if (! $ispdf) { ?>
							<textarea name='details_noted' class="form-control" rows="5"></textarea>
							<?php } else { ?>
							<br />
							<?php echo $this->input->post('details_noted'); ?>
							<?php } ?>
						</div>
						<br />

						<div class="form-group col-sm-12">
							<label for="details_noted" class="col-sm-12"><b>Claim Synopsis :</b></label>
							<?php if (! $ispdf) { ?>
							<textarea name='claim_synopsis' class="form-control" rows="5"></textarea>
							<?php } else { ?>
							<br />
							<?php echo $this->input->post('claim_synopsis'); ?>
							<?php } ?>
						</div>
						<br />

						<div class="form-group col-sm-12">
							<label for="details_noted" class="col-sm-12"><b>Review of TMO Records :</b></label>
							<?php if (! $ispdf) { ?>
							<textarea name='review_of_tmo' class="form-control" rows="5"></textarea>
							<?php } else { ?>
							<br />
							<?php echo $this->input->post('review_of_tmo'); ?>
							<?php } ?>
						</div>
						<br />

						<div class="form-group col-sm-12">
							<label for="details_noted" class="col-sm-12"><b>Review of LMO Records :</b></label>
							<?php if (! $ispdf) { ?>
							<textarea name='review_of_lmo' class="form-control" rows="5"></textarea>
							<?php } else { ?>
							<br />
							<?php echo $this->input->post('review_of_lmo'); ?>
							<?php } ?>
						</div>
						<br />

						<div class="form-group col-sm-12">
							<label for="details_noted" class="col-sm-12"><b>CONCLUSION :</b></label>
						</div>
						<br />

						<div class="form-group col-sm-12">
							<label for="details_noted" class="col-sm-12"><b>Eligibility for the policy / coverage :</b></label>
							<br />
							Not applicable<br /><br />
							Or<br /><br />
							Based on the medical information received, the claimant/insured appears to meet the eligibility criteria. This is further supported by the response from the LMO to the eligibility questionnaire, where he/she has answered “No” to all questions. LMO has also indicated that insured did have a complete medical check-up within the 24 months from application date, further specifying the date of the examination as ___________.<br /><br />
							Or<br /><br />
							Based on the medical information received, the claimant/insured DOES NOT appear to meet the eligibility criteria.<br /><br />
							Reason:<br /><br /> 
							Or<br /><br />
							Further clarity/information is needed (specifying reason etc.)<br /><br />
						</div>
						<br />

						<div class="form-group col-sm-12">
							<label for="details_noted" class="col-sm-12"><b>Medical Disclosure (per questionnaire) :</b></label>
							<br />
							Not applicable<br /><br />
							Or<br /><br />
							Based on the medical information received, the claimant/insured appears to have disclosed his/her medical conditions appropriately.<br /><br />
							Or<br /><br />
							Based on the medical information received, the claimant/insured appears to have failed to disclose his/her medical conditions appropriately on the declaration questionnaire.<br /><br />
							Elaborate on reason:<br /><br /> 
							Or<br /><br />
							Further clarity/information is needed (specifying reason etc.)<br /><br />
						</div>
						<br />

						<div class="form-group col-sm-12">
							<label for="details_noted" class="col-sm-12"><b>Pre-existing condition :</b></label>
							<br />
							Not applicable<br /><br />
							Or<br /><br />
							Based on the medical information received, the cause for claim DOES NOT appear to be related to a pre-existing medical condition<br /><br />
							Or<br /><br />
							does appear to be related to a pre-existing condition that was stable/unstable in the pre-existing condition period of _________ days before the effective/departure date. <br />
							Elaborate on reason:<br /><br />
						</div>
						<br />

						<div class="form-group col-sm-12">
							<label for="details_noted" class="col-sm-12"><b>Exclusions :</b></label>
							<br />
							Not applicable<br /><br />
							Or<br /><br />
							The below exclusion appears to apply to this claim because _____________________________________________________________ (you would provide an elaborate reasoning here).<br /><br />
						</div>
						<br />

						<div class="form-group col-sm-12">
							<label for="details_noted" class="col-sm-12"><b>Additional comments (if any) :</b></label>
							<br />
							Here you may comment on whether the treatment sought/rendered was elective Vs emergent. This may be more relevant for claims that were not actively managed by WTP and were rather notified after-the-fact.<br /><br />
						</div>
						<br />

						<div class="form-group col-sm-12">
							<label for="details_noted" class="col-sm-12"><b>Policy terms and conditions herewith considered :</b></label>
							<br />
							Here you can copy the policy wordings that may apply in support of a denial. For example: definition of pre-existing condition, definition of emergency, any particular exclusion such as those related to alcohol etc.<br /><br />
						</div>
						<br />

						<div class="form-group col-sm-12">
							Print your name here:<br /><br /><br /><br />
							(Medical Reviewer)<br /><br /><br />
						</div>
						<br />

						<div class="form-group col-sm-12">
							<label for="details_noted" class="col-sm-12"><b>Date :</b></label> <?php echo date("Y-m-d"); ?>
						</div>
						<?php if (! $ispdf) { ?>
						<div class="form-group col-sm-12">
							<button class="btn btn-primary pull-right" name="export" value="2">Export</button>
						</div>
						<?php } ?>
					</div>
					<?php if (! $ispdf) { ?>
					<?php echo form_close(); ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<!-- End List Section -->
</div>
