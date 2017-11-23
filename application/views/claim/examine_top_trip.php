<?php $this->load->model('claim_model'); ?>
<?php $total_payable = 0; $total_this_payable = 0; ?>
<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Claim Examine - #<?php echo $claim_details['claim_no']; ?></h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Policy search and List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
	            <?php echo $message; ?>
	            <div class="x_title">
					<h2>Trip Cancellation and Intrruption Claim Details</h2>
					<?php if (!empty($claim_details['case_no'])) { echo anchor("emergency_assistance/edit_case/".$claim_details['id'], 'Case Info <i class="fa fa-link"></i>', array("class"=>'btn btn-primary pull-right')); } ?>
					<div class="clearfix"></div>
				</div>
	            
				<div class="x_content">
					<h4 style="margin-top: 25px;">POLICY INFO</h4>
					<div class="row policy_info">
						<div class="form-group col-sm-3">
							<label>Policy : </label><?php echo $policy['policy']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Arrival Date : </label><?php echo $policy['arrival_date']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Effective Date : </label><?php echo $policy['effective_date']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Expiry Date : </label><?php echo $policy['expiry_date']; ?>
						</div>
						<div class="clearfix"></div>
	
						<div class="form-group col-sm-3">
							<label>Beneficiary : </label><?php echo $policy['beneficiary']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Sum Insured : </label>$<?php echo number_format($policy['sum_insured'], 2); ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Deductible Amount : </label>$<?php echo number_format($policy['deductible_amount'], 2); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php if ($policy['stable_condition'] == 1) { ?>
							<label>&nbsp;</label>Include stable pre-existing condition coverage
							<?php } else if ($policy['stable_condition'] == 2) { ?>
							<label>&nbsp;</label>Exclude stable pre-existing condition coverage
							<?php } else  { ?>
							<label>&nbsp;</label>&nbsp;
							<?php } ?>
						</div>
						<div class="clearfix"></div>
	
						<div class="form-group col-sm-3">
							<label>First Name : </label><?php echo $policy['firstname']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Last Name : </label><?php echo $policy['lastname']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Gender : </label><?php echo $policy['gender']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Birthday : </label><?php echo $policy['birthday']; ?>
						</div>
						<div class="clearfix"></div>
	
						<?php if (!empty($policy['family'])) { ?>
						<?php 	foreach($policy['family'] as $member ) { ?>
						<div class="form-group col-sm-3">
							<label>First Name : </label><?php echo $member['firstname']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Last Name : </label><?php echo $member['lastname']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Gender : </label><?php echo $member['gender']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Birthday : </label><?php echo $member['birthday']; ?>
						</div>
						<div class="clearfix"></div>
						<?php 	} ?>
						<?php } ?>
					</div>
					<hr />
	
					<h4 style="margin-top: 25px;">SECTION A: INSURED’S INFORMATION</h4>
					<div class="row policy_info">
						<div class="form-group col-sm-3">
							<label>Claim No : </label><?php echo $claim['claim_no']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Case No : </label><?php echo $claim['case_no']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Apply Date : </label><?php echo $claim['apply_date']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Arrival Date : </label><?php echo $claim['arrival_date_canada']; ?>
						</div>
	
						<div class="form-group col-sm-3">
							<label>Insured First Name : </label><?php echo $claim['insured_first_name']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Insured Last Name : </label><?php echo $claim['insured_last_name']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Insured Gender : </label><?php echo $claim['gender']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Insured Birthday : </label><?php echo $claim['dob']; ?>
						</div>

						<div class="form-group col-sm-3">
							<label>Second Insured First Name : </label><?php echo $exinfo['insured2_first_name']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Second Insured Last Name : </label><?php echo $exinfo['insured2_last_name']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Second Insured Gender : </label><?php echo $exinfo['gender2']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Second Insured Birthday : </label><?php echo $exinfo['dob2']; ?>
						</div>
	
						<h4>Address in Canada </h4>
						<div class="form-group col-sm-3">
							<label>Street Address : </label><?php echo $claim['street_address']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>City/Town : </label><?php echo $claim['city']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Province : </label><?php echo $claim['province']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>PostCode : </label><?php echo $claim['post_code']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Destination : </label><?php echo $exinfo['destination']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Telephone : </label><?php echo $claim['telephone']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Fax : </label><?php echo $exinfo['fax']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Email : </label><?php echo $claim['email']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Date of Departure : </label><?php echo $exinfo['depature_date']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Date of Return : </label><?php echo $exinfo['return_date']; ?>
						</div>
						<div class="clearfix"></div>
					</div>

					<h4>SECTION B: TYPE OF LOSS </h4>
					<div class="row">
						<div class="form-group col-sm-12">
							<label>Type : </label><?php echo $exinfo['loss_type']; ?>
						</div>
						<div class="clearfix"></div>
						<div class="form-group col-sm-12">
							If loss is due to sickness, please provide details : 
							<?php echo isset($exinfo["sickness"]) ? $exinfo["sickness"] : ''; ?>
						</div>
						<div class="form-group col-sm-6">
							Date symptoms or injury first appeared : <?php echo isset($exinfo["injury_date"]) ? $exinfo["injury_date"] : ''; ?>
						</div>
						<div class="form-group col-sm-6">
							Date you first saw physician for this condition : <?php echo isset($exinfo["physician_date"]) ? $exinfo["physician_date"] : ''; ?>
						</div>
						<div class="form-group col-sm-12">
							If loss is due to injury, please provide details : <?php echo isset($exinfo["injury_details"]) ? $exinfo["injury_details"] : ''; ?>
						</div>
						<div class="form-group col-sm-12">
							Describe how the injury/accident occured : <?php echo isset($exinfo["injury_describe"]) ? $exinfo["injury_describe"] : ''; ?>
						</div>
						<div class="form-group col-sm-6">
							Date of injury/accident : <?php echo isset($exinfo["injury_date"]) ? $exinfo["injury_date"] : ''; ?>
						</div>
						<div class="clearfix"></div>
						<div class="form-group col-sm-12">
							If loss is due to death, please provide details : <?php echo isset($exinfo["injury_describe"]) ? $exinfo["injury_describe"] : ''; ?>
						</div>
						<div class="form-group col-sm-6">
							Date of death : <?php echo isset($exinfo["death_date"]) ? $exinfo["death_date"] : ''; ?>
						</div>
						<div class="form-group col-sm-6">
							Cause of death : <?php echo isset($exinfo["death_cause"]) ? $exinfo["death_cause"] : ''; ?>
						</div>
						<div class="form-group col-sm-6">
							Your relationship to sick, injured or deceased person : <?php echo isset($exinfo["relation"]) ? $exinfo["relation"] : ''; ?>
						</div>
						<div class="form-group col-sm-6">
							Name of patient or deceased : <?php echo isset($exinfo["patient_name"]) ? $exinfo["patient_name"] : ''; ?>
						</div>
						<div class="clearfix"></div>

						<h4>Name and Address of patient’s usual Family Physician</h4>
						<div class="col-sm-12">
							<div class="form-group col-sm-3">
								<label>Name : </label><?php echo $claim['physician_name']; ?>
							</div>
							<div class="form-group col-sm-3">
								<label>Clinic Name or Address : </label><?php echo $claim['clinic_name']; ?>
							</div>
							<div class="form-group col-sm-3">
								<label>Street Address : </label><?php echo $claim['physician_street_address']; ?>
							</div>
							<div class="form-group col-sm-3">
								<label>City/Town : </label><?php echo $claim['physician_city']; ?>
							</div>
							<!-- div class="form-group col-sm-3">
								<label>Province : </label><?php /* echo $claim['physician_province']; */ ?>
							</div -->
							<div class="form-group col-sm-3">
								<label>Postal Code : </label><?php echo $claim['physician_post_code']; ?>
							</div>
							<div class="form-group col-sm-3">
								<label>Telephone : </label><?php echo $claim['physician_telephone']; ?>
							</div>
							<div class="form-group col-sm-3">
								<label>Alt Telephone : </label><?php echo $claim['physician_alt_telephone']; ?>
							</div>
						</div>
						<div class="clearfix"></div>

						<h4>Name and Address of any other physician who may have treated the patient in the last 12 months</h4>
						<div class="col-sm-12">
							<div class="form-group col-sm-3">
								<label>Name : </label><?php echo $claim['physician_name_canada']; ?>
							</div>
							<div class="form-group col-sm-3">
								<label>Clinic Name or Address : </label><?php echo $claim['clinic_name_canada']; ?>
							</div>
							<div class="form-group col-sm-3">
								<label>Street Address : </label><?php echo $claim['physician_street_address_canada']; ?>
							</div>
							<div class="form-group col-sm-3">
								<label>City/Town : </label><?php echo $claim['physician_city_canada']; ?>
							</div>
							<!-- div class="form-group col-sm-3">
								<label>Province : </label><?php /* echo $claim['physician_province_canada']; */ ?>
							</div -->
							<div class="form-group col-sm-3">
								<label>Postal Code : </label><?php echo $claim['physician_post_code_canada']; ?>
							</div>
							<div class="form-group col-sm-3">
								<label>Telephone : </label><?php echo $claim['physician_telephone_canada']; ?>
							</div>
							<div class="form-group col-sm-3">
								<label>Alt Telephone : </label><?php echo $claim['physician_alt_telephone_canada']; ?>
							</div>
						</div>
						<div class="form-group col-sm-6">
							If loss is due to other circumstances, please provide description of loss : <?php echo isset($exinfo["circumstances"]) ? $exinfo["circumstances"] : ''; ?>
						</div>
						<div class="form-group col-sm-6">
							Date the loss first occured : <?php echo isset($exinfo["occured_date"]) ? $exinfo["occured_date"] : ''; ?>
						</div>
						<div class="form-group col-sm-3">
							Date you cancelled with travel agent/travel supplier : <?php echo isset($exinfo["cancelled_date"]) ? $exinfo["cancelled_date"] : ''; ?>
						</div>
					</div>
					
					<h4>Contact Information</h4>
					<div class="row">
						<div class="form-group col-sm-3">
							<label>First Name : </label><?php echo $claim['contact_first_name']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Last Name : </label><?php echo $claim['contact_last_name']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Email : </label><?php echo $claim['contact_email']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Phone : </label><?php echo $claim['contact_phone']; ?>
						</div>
					</div>

					<h4>SECTION D: OTHER INSURANCE COVERAGE</h4>
					<div class="row">
						<div class="col-sm-12">
							Do you have credit card insurance coverage ? <?php echo (isset($exinfo['credit_card_insurance']) && ($exinfo['credit_card_insurance'] == 'Y')) ? "Yes" : 'No';?>,  If ‘Yes’, please provide the following information
						</div>
						<?php if (isset($exinfo['credit_card_insurance']) && ($exinfo['credit_card_insurance'] == 'Y')) { ?>
						<div class="form-group col-sm-12">
							Name of the financial Institution : <?php echo isset($exinfo["credit_card_name"]) ? $exinfo["credit_card_name"] : ''; ?>
						</div>

						<div class="form-group col-sm-6">
							First 6 digits of credit card : <?php echo isset($exinfo["credit_card_number"]) ? $exinfo["credit_card_number"] : ''; ?>
						</div>

						<div class="form-group col-sm-6">
							Expiry Date(MM/YYYY) : <?php echo isset($exinfo["credit_card_expire"]) ? $exinfo["credit_card_expire"] : ''; ?>
						</div>

						<div class="form-group col-sm-6">
							Name of Cardholder : <?php echo isset($exinfo["credit_card_holder"]) ? $exinfo["credit_card_holder"] : ''; ?>
						</div>
						<div class="clearfix"></div>
						<?php } ?>
						<div class="col-sm-12">
							Do you have insurance benefits available through group insurance or any other source? <?php if (! empty($exinfo["group_insurance"])) { echo "Yes"; } else { echo "No"; } ?>>. If 'yes', please provide details below:_
						</div>
						<?php if (! empty($exinfo["group_insurance"])) { ?>
						<div class="col-sm-12">
							Group Insurance
						</div>
						<div class="form-group col-sm-6">
							Name and Address of Insurance Company : <?php echo isset($exinfo["group_insurance"]) ? $exinfo["group_insurance"] : ''; ?>
						</div>
						<div class="form-group col-sm-3">
							Policy # : <?php echo isset($exinfo["group_insurance"]) ? $exinfo["group_insurance_policy"] : ''; ?>
						</div>
						<div class="form-group col-sm-3">
							Telephone : <?php echo isset($exinfo["group_insurance"]) ? $exinfo["group_insurance_phone"] : ''; ?>
						</div>
						<?php } ?>
						<div class="col-sm-12">
							Other Travel Insurance
						</div>
						<div class="form-group col-sm-6">
							Name and Address of Insurance Company : <?php echo isset($exinfo["other_travel_insurance"]) ? $exinfo["group_insurance"] : ''; ?>
						</div>
						<div class="form-group col-sm-3">
							Policy # : <?php echo isset($exinfo["group_insurance"]) ? $exinfo["other_travel_insurance_policy"] : ''; ?>
						</div>
						<div class="form-group col-sm-3">
							Telephone : <?php echo isset($exinfo["group_insurance"]) ? $exinfo["other_travel_insurance_phone"] : ''; ?>
						</div>
						<div class="clearfix"></div>
	
						<div class="form-group col-sm-3">
							<label>Status : </label><?php echo $claim['status']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Decision : </label>
							<?php 
								if (($claim['status'] == Claim_model::STATUS_Processed) || ($claim['status'] == Claim_model::STATUS_Paid) || ($claim['status'] == Claim_model::STATUS_Closed)) {
									echo ($claim['is_accepted'] == 'N') ? 'Deny' : 'Accept'; 
								} else {
									echo "&nbsp;";
								}
							?>
							<?php echo form_hidden("policy_info", $claim['policy_info'] ); ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Priority : </label><?php echo $claim['priority']; ?>
						</div>
						<div class="form-group col-sm-3">
							<label>Related Files : </label>
							<?php 
								foreach ($claim_files as $fn => $urlfn) {
									echo "<br /><a href='" . $urlfn . "' target='_blank'>" . $fn . "</a>"; 
								}
							?>
						</div>
					</div>
					<hr />
	
					<h4>Items</h4>
					<div class="row">
					<?php if (empty($items)) { echo "There is no item for this claim"; } else { ?>
						<div class="table-responsive claim_items">
							<table class="table table-hover table-bordered" style='overflow: hidden; margin-right: 26px; padding-right: 26px;'>
								<thead>
									<tr>
										<th>No</th>
										<th>Claim Item No</th>
										<th>Invoice No</th>
										<th>Service Date</th>
										<th>Coverage</th>
										<th>Diagnosis</th>
										<th>Amt Billed</th>
										<th>Amt Claimed</th>
										<th>Amt Payable</th>
										<th>Amt Received</th>
										<th>Comment</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$i = 1;
									foreach ( $items as $key => $value ) {
									$total_payable += (float)$value['amt_payable'];
									$total_this_payable += (float)$value['amt_payable'];
								?>
									<tr class="row-link claim_items" data-id="<?php echo $value['id']; ?>">
										<td><?php echo $i++; ?></td>
										<td><?php echo $value['claim_item_no']; ?></td>
										<td><?php echo $value['invoice']; ?></td>
										<td><?php echo $value['date_of_service']; ?></td>
										<td><?php echo $value['coverage_code']; ?></td>
										<td><?php echo $value['diagnosis']; ?></td>
										<td><?php echo $value['amount_billed']?$value['amount_billed']:0; ?></td>
										<td><?php echo $value['amount_claimed']?$value['amount_claimed']:0; ?></td>
										<td><?php echo $value['amt_payable']?$value['amt_payable']:0; ?></td>
										<td><?php echo $value['amt_received']?$value['amt_received']:0; ?></td>
										<td><?php echo $value['comment'] ?></td>
									</tr>
									<tr class='claim_items_form trinputform' id='item_form_<?php echo $value['id']; ?>'>
										<td colspan="11">
											<div class="row policy_info">
											<?php 
												echo form_open_multipart("claim/save_item", array('class'=>'form-horizontal claim_items_submit', 'method'=>'post'));
												echo form_hidden("id",  $value['id']);
												echo form_hidden("claim_id", $value['claim_id'] );
											?>
												<div class="form-group col-sm-3">
													<label class="col-sm-12">Provider Name : </label>
													<div class='col-sm-12'><?php echo $value['provider_name']; ?>&nbsp;</div>
												</div>
												<div class="form-group col-sm-3">
													<label class="col-sm-12">Service Description : </label>
													<div class='col-sm-12'><?php echo $value['service_description']; ?>&nbsp;</div>
												</div>
												<div class="form-group col-sm-3">
													<label class="col-sm-12">Date of Service : </label>
													<div class='col-sm-12'><?php echo $value['date_of_service']; ?>&nbsp;</div>
												</div>
												<div class="form-group col-sm-3">
													<label class="col-sm-12">Created: </label>
													<div class='col-sm-12'><?php echo $value['created']; ?></div>
												</div>
												<div class="clearfix"></div>

												<div class="form-group col-sm-3">
													<label class="col-sm-12">Deductible : </label>
													<div class='col-sm-12'><input type='number' step='0.01' name='amt_deductible' value="<?php echo $value['amt_deductible']; ?>"></div>
												</div>
												<div class="form-group col-sm-3">
													<label class="col-sm-12">New Payable : </label>
													<div class='col-sm-12'><input type='number' step='0.01' name='amt_payable' value="<?php echo $value['amt_payable']; ?>"></div>
												</div>
												<div class="form-group col-sm-3">
													<label class="col-sm-12">Received : </label>
													<div class='col-sm-12'><input type='number' step='0.01' name='amt_received' value="<?php echo $value['amt_received']; ?>"></div>
												</div>
												<div class="form-group col-sm-3">
													<label class="col-sm-12">Exceptional : </label>
													<div class='col-sm-12'><input type='number' step='0.01' name='amt_exceptional' value="<?php echo $value['amt_exceptional']; ?>"></div>
												</div>
												<div class="clearfix"></div>
												
												<div class="form-group col-sm-3">
													<label class="col-sm-12">Pay To : </label>
													<div class='col-sm-12'><?php echo $value['pay_to']; ?>&nbsp;</div>
												</div>
												<div class="form-group col-sm-3">
													<label class="col-sm-12">Last Update : </label>
													<div class='col-sm-12'><?php echo $value['last_update']; ?></div>
												</div>
												<div class="form-group col-sm-3">
													<label class="col-sm-12">Status : </label>
													<div class='col-sm-12'><?php echo form_dropdown ( "status", $examine_status, $value['status'], array () ); ?></div>
												</div>
												<div class="clearfix"></div>
												
												<div class="form-group col-sm-3">
													<label class="col-sm-12">Recovery Name : </label>
													<div class='col-sm-12'><input type='text' name='recovery_name' value="<?php echo $value['recovery_name']; ?>"></div>
												</div>
												<div class="form-group col-sm-3">
													<label class="col-sm-12">Recovery Amount : </label>
													<div class='col-sm-12'><input type='number' step='0.01' name='recovery_amt' value="<?php echo $value['recovery_amt']; ?>"></div>
												</div>
												<div class="form-group col-sm-3">
													<label class="col-sm-12">Reason : </label>
													<div class='col-sm-12'>
														<select name="reason">
															<option value=""> -- Select Reason -- </option>
															<?php foreach ($reasons as $rc):?>
															<option value="<?php echo $rc; ?>" <?php if ($rc == $value['reason']) { echo "selected"; } ?>><?php echo $rc; ?></option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
												<div class="form-group col-sm-3">
													<div class='col-sm-12'><?php echo form_submit("Save", "Save", 'class="btn btn-primary"'); ?></div>
												</div>
											<?php echo form_close(); ?>
											</div>
										</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					<?php } ?>
					</div>
					<hr />
	
					<h4 style="margin-top: 35px; margin-bottom: 26px;">Total Pay info By Policy</h4>
					<div class="row actions" style="margin-top: 20px;">
						<div class="col-sm-3">
							<label class="col-sm-12">Total Approved or Paid Amount</label>
							<div class='col-sm-12'>$ <?php echo number_format($payinfo['payable'], 2); ?></div>
						</div>
						<div class="col-sm-3">
							<label class="col-sm-12">Policy Deductible Amount</label>
							<div class='col-sm-12'>$ <?php echo number_format($policy['deductible_amount'], 2); ?></div>
						</div>
						<div class="col-sm-3">
							<label class="col-sm-12">Total Deducted Amount</label>
							<div class='col-sm-12'>$ <?php echo number_format($payinfo['deductible'], 2); ?></div>
						</div>
						<div class="clearfix"></div>
					</div>
    				<hr />

					<div class="row actions" style="margin-top: 20px;">
						<div class="row">
							<div class="col-sm-3">
								<?php echo anchor("claim", "Cancel", array("class"=>'btn btn-primary')); ?>
							</div>
							<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_EXAMINER))) { ?>
							<?php if (($claim['status'] != Claim_model::STATUS_Processed) && ($claim['status'] != Claim_model::STATUS_Pending) && ($claim['status'] != Claim_model::STATUS_Paid) && ($claim['status'] != Claim_model::STATUS_Closed)) { ?>
							<div class="col-sm-3 investigate_pending">
								<input class="btn btn-primary" name="Investigate Pending" value="Investigate Pending" type="button">
							</div>
	                     	<?php } ?>
							<?php if (($claim['status'] != Claim_model::STATUS_Processed) && ($claim['status'] != Claim_model::STATUS_Paid) && ($claim['status'] != Claim_model::STATUS_Closed)) { ?>
							<div class="col-sm-3 accept_decision">
								<input class="btn btn-primary" name="Accept" value="Investigate Finished" type="button">
							</div>
							<?php } ?>
							<?php if (0) { ?>
							<div class="col-sm-3 deny_decision">
								<input class="btn btn-primary" name="Deny" value="Deny" type="button">
								<div class="col-sm-12 deny_reasons" style="display: none">
									<?php
										$reason = array ('' => '--Denial Reason--');
										foreach ( $docs as $doc ) $reason [$doc ['id']] = $doc ['name'];
										echo form_dropdown ( "deny_reason", $reason, '', array ('class' => 'form-control') );
									?>
								</div>
							</div>
							<?php } ?>
							<!-- div class="col-sm-2">
								<input class="btn btn-primary email_print" data-toggle="modal" name="Email" value="Email/Print" type="button" data-target="#print_template">
							</div -->
							<?php } ?>
						</div>
					</div>
					<?php if(!empty($other_items)) { ?>
					<hr />
					<h4 style="margin-top: 35px; margin-bottom: 26px;">OTHER CLAIM INFO ON THIS POLICY</h4>
					<div class="row">
						<div class="form-group col-sm-12">
							<table class="table table-hover table-bordered">
								<thead>
									<tr>
										<th>No</th>
										<th>Claim No</th>
										<th>Claim Item No</th>
										<th>Invoice No</th>
										<th>Service Date</th>
										<th>Coverage</th>
										<th>Diagnosis</th>
										<th>Amt Claimed</th>
										<th>Amt Payable</th>
										<th>Amt Deductible</th>
										<th>Amt Insured</th>
										<th>Amt Received</th>
										<th>Comment</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$i = 1;
										foreach ($other_items as $key => $value ) {
											$total_payable += (float)$value['amt_payable'];
									?>
									<tr class="row-link">
										<td><?php echo $i++; ?></td>
										<td><?php echo $value['claim_no']; ?></td>
										<td><?php echo $value['claim_item_no']; ?></td>
										<td><?php echo $value['invoice']; ?></td>
										<td><?php echo $value['date_of_service']; ?></td>
										<td><?php echo $value['coverage_code']; ?></td>
										<td><?php echo $value['diagnosis']; ?></td>
										<td><?php echo $value['amount_claimed']?$value['amount_claimed']:0; ?></td>
										<td><?php echo $value['amt_payable']?$value['amt_payable']:0; ?></td>
										<td><?php echo $value['amt_deductible']?$value['amt_deductible']:0; ?></td>
										<td><?php echo $value['amt_insured']?$value['amt_insured']:0; ?></td>
										<td><?php echo $value['amt_received']?$value['amt_received']:0; ?></td>
										<td><?php echo $value['comment']; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<?php } ?>
            	</div>
			</div>
		</div>
	</div>
</div>

<!-- Email print doc content here -->
<div id="print_template" class="modal fade" role="dialog">
	<div class="modal-dialog  modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Print/email Template Letter</h4>
			</div>
			<?php echo form_open_multipart ( "claim/send_print_email_claim", array ("id" => 'send_print_email') );?>
			<div class="modal-body reload_docs">
				<div class="row">
					<div class="col-sm-6">
						<div>
							<label for="mail_label" class="col-sm-2">Mail Addres:</label>
							<div class="form-group col-sm-6">
								<input name="priority" value="HIGH" id="mail_address" class="col-sm-1" type="checkbox">
								<label for="mail_address" class="col-sm-10 pull-right" style="margin-top: 3px;">Use same address with the policy</label>
							</div>
						</div>
						<div>
							<?php echo form_label ( 'To:', 'email', array ("class" => 'col-sm-12') );?>
							<div class="form-group col-sm-12">
								<?php echo form_input ( "email", "", array ("class" => "form-control col-sm-6 form-group email required", 'placeholder' => 'Email Address') ); ?>
								<?php echo form_hidden ( 'type', 'email' ); // used for which action need to perform "email or deny claim" ?>
							</div>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<div class="form-group col-sm-3">
							<?php echo form_label ( 'Street No.:', 'street_no_email', array ("class" => 'col-sm-12') ); ?>
							<?php echo form_input ( "street_no_email", "", array ("class" => "form-control required", 'placeholder' => 'Street No.') ); ?>
							<?php echo form_error ( "street_no_email" ); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label ( 'Street Name.:', 'street_name_email', array ("class" => 'col-sm-12') ); ?>
							<?php echo form_input ( "street_name_email", "", array ("class" => "form-control required", 'placeholder' => 'Street Name.') ); ?>
							<?php echo form_error ( "street_name_email" ); ?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label ( 'City:', 'city_email', array ("class" => 'col-sm-12') ); ?>
							<?php echo form_input ( "city_email", "", array ("class" => "form-control required", 'placeholder' => 'City') ); ?>
							<?php echo form_error ( "city" );?>
						</div>
						<div class="form-group col-sm-3">
							<?php echo form_label ( 'Province:', 'province_email', array ("class" => 'col-sm-12') ); ?>
							<select name="province_email" class="form-control">
								<?php foreach ($province as $key => $val): ?>
								<option value="<?php echo $key; ?>" <?php if ($key == $this->input->post("province_email")) { echo "selected"; } ?>><?php echo $val; ?></option>
								<?php endforeach; ?>
							</select>
							<?php echo form_error ( "province_email" ); ?>
						</div>
						<?php echo form_label ( 'Select Template:', 'select_template', array ("class" => 'col-sm-12') ); ?>
						<div class="form-group col-sm-12">
							<?php foreach($docs as $doc): ?>
							<div class="select-doc col-sm-2" doc="<?php echo $doc['id'] ?>">
								<i class="fa fa-file-word-o large"></i>
								<?php echo $doc['name']?>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="form-group col-sm-12 docfiles">
						<?php foreach($docs as $doc): ?>
						<div class="col-sm-12 doc-description doc-<?php echo $doc['id'] ?>" style="display: none">
							<div class="col-sm-12 doc_title">
                        		<?php echo heading($doc['name']); ?>
							</div>
							<div class="col-sm-12 doc-desc">
								<?php
									// find and replace text
									$find = array ('{otc_logo}', '{otc_logo_big}', '{current_date}');
									$replace = array (img ( array ('src' => 'assets/img/otc.jpg', 'width' => '130') ), img ( array ('src' => 'assets/img/otc_big.jpg', 'width' => '262') ), date ( "F d, Y" ));
									echo str_replace ( $find, $replace, $doc ['description'] );
								?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<label class="col-sm-12">&nbsp;</label>
				<button type="button" class="btn btn-info preview-template" disabled>Preview</button>
				<button class="btn btn-primary email-intakeform" disabled>Email</button>
				<button type="button" class="btn btn-info print" disabled>Print</button>
				<button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
			</div>
      		<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!-- end here -->
<div style="display: none">
	<div id="products">
		<select name="product_short" class="form-control">
			<option value="">--Select Product--</option>
			<?php foreach ($products as $key => $val): ?>
			<option value="<?php echo $key; ?>" <?php if ($key == $this->input->post("product_short")) { echo "selected"; } ?>><?php echo $val; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>

<!-- Create Intake Form Modal -->
<div id="create_intake_form" class="modal fade" role="dialog">
	<div class="modal-dialog  modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Create Note</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-sm-6">
						<?php echo form_label ( 'Note #:', 'form_id', array ("class" => 'col-sm-12') ); ?>
						<div class="form-group col-sm-12">####</div>
					</div>
					<div class="form-group col-sm-6">
						<?php echo form_label ( 'Create Date:', 'create_date', array ("class" => 'col-sm-12') );?>
						<div class="form-group col-sm-12">
							<?php echo date ( "Y-m-d" ); ?>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<?php echo form_label ( 'Notes:', 'intake_notes', array ("class" => 'col-sm-12') ); ?>
						<?php echo form_textarea ( "intake_notes", $this->input->post ( "intake_notes" ), array ("class" => "form-control", 'placeholder' => 'Notes', 'style' => "height:100px") ); ?>
						<?php echo form_error ( "intake_notes" ); ?>
					</div>
					<div class="form-group col-sm-12 files"></div>
				</div>
			</div>
			<div class="modal-footer">
				<label class="col-sm-12">&nbsp;</label>
				<button class="btn btn-primary save-intakeform">Save</button>
				<a href="javascript:void(0)" class="btn btn-primary multiupload">Upload Attached</a>
				<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- end intake form model here -->

<!-- word templates here -->
<div style="display: none" class="word_templates">
<?php if(!empty($word_templates)): ?>
   <ul>
   <?php foreach($word_templates as $tmp): ?>
      <li style='list-style: outside none none;'><?php echo form_checkbox('word_doc', $tmp['content']).' <b>'.$tmp['title'].'</b>: '.$tmp['content'] ?></li>
   <?php endforeach; ?>
   </ul>
<?php endif; ?>
</div>

<script src="<?php echo base_url() ?>/assets/js/jQuery.print.js"></script>
<script src="<?php echo base_url() ?>/assets/js/jquery.validate.min.js"></script>
<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script
	src="<?php echo base_url(); ?>/assets/js/bootstrap-datetimepicker.js"></script>
<script>
$(document).ready(function() {
	$(".claim_items").on("click", function() {
		var id = $(this).attr('data-id');
		if (id) {
			$(".claim_items").removeClass('active-green');
			$(this).addClass('active-green');
			$(".claim_items_form").hide();
			$("#item_form_" + id).show();
		}
	});

	$(".claim_items_submit").on("submit", function(e) {
		e.preventDefault();
		var href = $(this).attr("action");
		$.ajax({
			url: href,
			method: "post",
			data:$(this).serialize(),
			beforeSend: function() {
				$(this).children("input[name=Save]").hide();
			},
			complete: function() {
				$(this).children("input[name=Save]").show();
				$(".claim_items").removeClass('active-green');
			},
			success: function() {
				window.location.reload();
			}
		})
	});

      var amt_payable = 0;
      // enable buttons according to claim Decision
      var decision = "<?php echo @$claim_details['status']; ?>"
      if(decision == ''){
         $(".accept_decision, .deny_decision, .record_exceptional, .investigate_pending").show();
         $(".my_decision").hide();
      } else {
         if(decision == '<?php echo Claim_model::STATUS_Processed; ?>' || decision == '<?php echo Claim_model::STATUS_Exceptional; ?>' || decision == '<?php echo Claim_model::STATUS_Paid; ?>')
            $(".accept_decision, .deny_decision, .record_exceptional, .investigate_pending").hide();
         else
            $(".accept_decision, .deny_decision, .record_exceptional, .investigate_pending").show();

         $(".my_decision").show().html('<label style="float: left; font-size: 25px;">: '+decision+' </label>');
      }

      $("tr[alt=<?php echo $id; ?>]").addClass('active-green');
      $(".datepicker").datepicker({
           startDate: '-105y',
           endDate: '+2y',
       });
   })
   .on("click",".more_filters", function(){
      $(".more_items").toggle();
   })

   // fuzzy search
   .on("click", ".autocomplete_field", function() {
      $(".autocomplete_field").autocomplete({
        serviceUrl: "<?php echo base_url()."claim/search_diagnosis/description"; ?>" ,
        minLength: 2,
        dataType: "json",
      });
    })
   .on("click", ".add_new_expenses", function(){
      var html = $(".base-row").html();
      $(".expenses-list").append(html);
   })
   .on("click", ".remove_claim", function(){
      $(this).parent("td").parent("tr").remove();
   })

   .on("click", ".add_payee", function(){
      var html = $(".payee-buffer").html();
      $(".payee-data").append(html);
   })
   .on("click", ".remove-payee", function(){
      $(this).parent("td").parent("tr").remove();
   })

   // fill autofill on key type
   .on("keyup", ".company_name input", function(){
      $(".company_name input").val($(this).val());
   })

   // show email/print function
   .on("click", ".select-doc", function(){

      // hide all doc files here
      $(".doc-description").hide();
      $(".select-doc").removeClass("active");

      // get doc if
      var id = $(this).attr("doc");
      $(this).addClass("active");

      // show related doc file
      $(".doc-"+id).show();

      // get selected case details object
      var obj = $(".email_print");

      // get policy info
      var data = $("input[name=policy_info]").val()?$.parseJSON($("input[name=policy_info]").val()):'';

      // parse case data details
      var claim_data = $.parseJSON($(".select_claim.active-green").attr('data'));

      // replace string from casemanager name etc
      var str = $(".doc-"+id+"  .doc-desc").html();
      str = str.replace(/{insured_name}/gi, claim_data.insured_first_name+' '+claim_data.insured_last_name)
      .replace(/{claimant_name}/gi, claim_data.insured_first_name+' '+claim_data.insured_last_name)
      .replace("{insured_address}", claim_data.street_address+' '+claim_data.city+' '+claim_data.province)
      .replace("{insured_lastname}", claim_data.insured_last_name)
      .replace("{policy_no}", claim_data.policy_no)
      .replace("{case_no}", claim_data.case_no)
      .replace("{policy_coverage_info}", "{policy_coverage_info}")
      .replace("{casemanager_name}", '<?php echo $this->ion_auth->user()->row()->first_name ?>')
      .replace("{claimexaminer_name}", claim_data.claimexaminer_name)
      .replace("{current_date_+_90}", '<?php echo date('Y-m-d', strtotime(' + 90 days')) ?>')

      .replace("{clinic_name}", claim_data.clinic_name)
      .replace("{insured_dob}", claim_data.dob)

      .replace("{policy_holder}", claim_data.insured_first_name+' '+claim_data.insured_last_name)
      if(data)
         str = str.replace("{coverage_period}", data[0].effective_date+" to "+data[0].expiry_date);
      else
        str =  str.replace("{coverage_period}", '');

      $(".doc-"+id+" .doc-desc").html(str);

      // reset all edit//preview section
      $(".preview-template").text("Preview").removeClass("active-preview");

      // enable disable buttons
      $(".print").attr("disabled", "disabled");
      $(".preview-template, .email-intakeform").removeAttr("disabled");
   })

   .on("click", ".email_print", function(){
         $("input[name=type]").val("email");
         $(".email-intakeform").text("Email");
   })

   // preview template script
   .on("click", ".preview-template", function(){
      // get selected doc
      $(this).toggleClass("active-preview");
      var doc_id = $(".select-doc.active").attr("doc");
      if($(this).hasClass("active-preview"))
      {
         $(this).text("Edit Template");
         var $outer = $(".doc-"+doc_id+" .outer-text input, .doc-"+doc_id+" .outer-text textarea, .doc-"+doc_id+" .select-product select");
         $outer.each(function(){
            var text = $.trim($(this).val());

            $(this).parent("p,span").html(text.replace(/\n/g, "<br>"));
            $(this).remove();
         });

         // show selected word templates
         $(".outer_custom_comment").each(function(){
            var text = [];
            $("input[name=word_doc]:checked").each(function(){
               text.push(" - "+$(this).val());
            })
            var text = text.join("<br>");
            text += "<br>";
            $(this).html(text.replace(/\n/g, "<br>"));
            $(this).children('ul').remove();
         });

         // enable print button
         $(".print").removeAttr("disabled");
      }
      else
      {
         $(this).text("Preview");
         var $outer = $(".outer-text");
         $outer.each(function(){
            var text = $.trim($(this).html()).replace(/<br>/g, "\n");

            $(this).empty();
            if(!$(this).hasClass("area"))
               $(this).append("<input class='outer-text' value='" + text + "'></input>");
            else
               $(this).append("<textarea  style='width:100%' rows='6'>"+ text +"</textarea>");
         });

         // for the products list
         var $outer_select = $(".select-product");
         $outer_select.each(function(){
            var text = $.trim($(this).text());

            $(this).empty();
            $(this).append($("#products").html()).children("select").val(text);
         });

         // create word template selection for deny reason
         var $outer = $(".outer_custom_comment");
         $outer.each(function(){
            var text = $.trim($('.word_templates').html());

            $(this).empty();
            $(this).append(text);
         });

         // disable print button
         $(".print").attr("disabled", "disabled");
      }

   })

   // print button script here
   .on("click", ".print", function(){
      var doc_id = $(".select-doc.active").attr("doc");
      $(".doc-"+doc_id).print({
           globalStyles: false,
           mediaPrint: true,
           iframe: true,
           noPrintSelector: ".avoid-this",
       });
   })

   // once auto file clicked
   .on("change","input[type=file]", function(){

      // validate file extension
      var ext = $(this).val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['pdf']) == -1) {
          alert('invalid extension! Please attach only pdf file.');
          $(this).val('');
          return false;
      }

      // display file name and delete button
      $(this).next("span.file-label").text($(this).val()).parent("div.col-sm-9").show();
   })

   // custom script for multi file upload
   .on("click",".multiupload", function(){
      var count = $("input[type=file]").length;

      // count no of intake forms
      var no_of_form = $(".intake-forms").length + 1;

      // add new file here
      $(".modal-body .files").append('<div class="col-sm-9" style="display:none"><input style="display:none" type="file" name="files_'+no_of_form+'[]" id="file'+(count+1)+'" accept="pdf" /><span class="file-label"></span> <i class="fa fa-trash row-link" id="'+(count+1)+'"></i></div>');

      // place trigger clicked once file append in files class
      $('#file'+(count+1)).trigger("click");
   })

   // custom script for multi file upload
   .on("click",".multiupload_files", function(){
      var count = $("input[type=file]").length;

      // count no of intake forms
      var no_of_form = $(".intake-forms").length + 1;

      // add new file here
      $(".uploaded_files").append('<div class="col-sm-9"  style="display:none" ><input style="display:none" type="file" name="files_multi[]" id="file'+(count+1)+'" accept="pdf" /><span class="file-label"></span> <i class="fa fa-trash row-link" id="'+(count+1)+'"></i></div>');

      // place trigger clicked once file append in files class
      $('#file'+(count+1)).trigger("click");
   })

   // delete intake form
   .on("click",".fa.fa-remove.row-link.remove-form.pull-right", function(){
      var id = $(this).attr("alt");

      if(confirm('Are you sure you want to delete? '))
      {
         // remove form area instant to make it visible fast
         $(this).parent("div").parent("div").parent("div.intake-forms").remove();

         $.ajax({
            url: "<?php echo base_url("emergency_assistance/deleteform/") ?>"+id,
            method: "get"
         })
      } else {
         return false;
      }
   })


   // delete attached document
   .on("click",".remove_doc", function(e){

      e.preventDefault();

      var link = $(this).parent('a').attr("href");

      if(confirm('Are you sure you want to delete? '))
      {
         // remove form area instant to make it visible fast
         $(this).parent("a").parent("div").remove();

         $.ajax({
            url: link,
            method: "get"
         })
      } else {
         return false;
      }
   })

     // once user clicked on same with policy button
   .on("click", "#mail_address", function(){

      // get local data
      var data = $.parseJSON($("input[name=policy_info]").val());
      if($(this).is(":checked"))
      {
         // fill all json values to address fields
         $("input[name=email]").val(data.contact_email);
         $("input[name=street_no_email]").val(data.street_number);
         $("input[name=street_name_email]").val(data.street_name);
         $("input[name=city_email]").val(data.city);
         $("select[name=province_email]").val(data.province2);
      }
      else
      {
         $("input[name=street_no_email],input[name=street_name_email],input[name=city_email],select[name=province_email]").val("");
      }
   })

   // once user click over save intake form, we are just hold every value untill case is not submitted
   .on("click", '.save-intakeform', function(){

      // check notes field filled or not
      if(!$("textarea[name=intake_notes]").val())
      {
         alert("Please add notes first.")
         return false;
      }

      // count no of intake forms
      var count = $(".intake-forms").length + 1;

      // place no of form in hidden field
      $("input[name=no_of_form]").val(count);

      // get notes and files
      var notes = $("textarea[name=intake_notes]").val();
      var files = $(".modal-body .files").clone();

      // generate html data
      var html = '<div class="col-sm-12 intake-forms"><div class=col-sm-12"><input type="hidden" name="notes_'+count+'" value="'+notes+'" />' + notes + '</div><div id="intake-files-'+count+'"></div> <div class=col-sm-3"><i class="fa fa-remove row-link remove-form pull-right"></i></div> <div class="col-sm-12">By: <?php echo $this->ion_auth->user()->row()->first_name; ?> on <i><?php echo date("Y-m-d"); ?></i></div></div>';

      // place every value to intake display area
      $(".intake-forms-list").append(html);

      // set clone files to that area
      $("#intake-files-"+count).html(files);

      // close model popup
      $('#create_intake_form').modal('hide');

      // save intake heading
      $(".intake-heading").show()
   })

   // to load, show/hide contents
   .on("click", ".move_down", function(){
      $(this).next("div.row").slideToggle();
      $(this).children("i").toggleClass("fa-angle-up").toggleClass("fa-angle-down");
   })

   // send email print to recepient email:-
   .on("submit", "#send_print_email", function(e){
      e.preventDefault();
      var doc_id = $(".select-doc.active").attr("doc");
      if($(this).valid())
      {
         $(".preview-template").trigger('click');
         var template = $(".doc-"+doc_id).children("div.doc-desc").html();
         $.ajax({
            url: "<?php echo base_url("claim/send_print_email_claim") ?>",
            method: "post",
            data:{
               email:$("#send_print_email input[name=email]").val(),
               street_no:$("#send_print_email  input[name=street_no_email]").val(),
               street_name:$("#send_print_email  input[name=street_name_email]").val(),
               city:$("#send_print_email  input[name=city_email]").val(),
               province:$("#send_print_email  select[name=province_email]").val(),
               template:template,
               case_id: $(".select_claim.active-green").attr('alt'),
               claim_item_id:$(".edit_claim.active-green").attr('alt'),
               doc: $("#send_print_email .select-doc.active").text(),
               type: $("#send_print_email input[name=type]").val()
            },
            beforeSend: function(){
               $(".modal-content").addClass("csspinner load1");
            },
            success: function() {
               window.location.reload();
            }
         })
      }
   })

	.on("click", "input[name=Accept]", function() {
		if (confirm('Are you sure you want to change claim status to processed ?')) {
			$.ajax({
				url: "<?php echo base_url("claim/status/".Claim_model::STATUS_Processed."/Y") ?>",
				method: "post",
				data:{claim_id:<?php echo $claim['id']; ?>},
				beforeSend: function(){
					$(".modal-content, .main_container").addClass("csspinner load1");
				},
				success: function() {
					window.location.reload();
				}
			})
		} else {
			return false;
		}
	}).on("click", "input[name='Investigate Pending']", function() {
		if (confirm('Are you sure you want to mark this claim as pending?')) {
			$.ajax({
				url: "<?php echo base_url("claim/status/".Claim_model::STATUS_Pending) ?>",
				method: "post",
				data:{claim_id:<?php echo $claim['id']; ?>},
				beforeSend: function() {
					$(".main_container").addClass("csspinner load1");
				},
				success: function() {
					window.location.reload();
				}
			})
		} else {
			return false;
		}
	}).on("click", "input[name='Record Exceptional']", function() {
		if (confirm('Are you sure you want to mark this claim as record exceptional?')) {
			$.ajax({
				url: "<?php echo base_url("claim/status/".Claim_model::STATUS_Exceptional) ?>",
				method: "post",
				data:{claim_id:<?php echo $claim['id']; ?>},
				beforeSend: function() {
					$(".main_container").addClass("csspinner load1");
				},
				success: function() {
					window.location.reload();
				}
			})
		} else {
			return false;
		}
	}).on("click", "input[name=Deny]", function() {
		$(".deny_reasons").show();
	}).on("change", "select[name=deny_reason]", function() {
		if ($(this).val()) {
			if (confirm('Are you sure you want to deny claim?')) {
				$.ajax({
					url: "<?php echo base_url("claim/status/".Claim_model::STATUS_Closed."/N") ?>",
					method: "post",
					data:{
						claim_id:<?php echo $claim['id']; ?>,
						reason:$(this).children("option").filter(":selected").text(),
					},
					beforeSend: function() {
						$(".main_container").addClass("csspinner load1");
					},
					success: function() {
						window.location.reload();
					}
				})
			} else {
				return false;
			}
		}
	})

 
// create input boxes where the requirement need
var $outer = $(".outer-text");
$outer.each(function(){
   var text = $.trim($(this).text());

   $(this).empty();
   if(!$(this).hasClass("area"))
      $(this).append("<input class='outer-text' value='" + text + "'></input>");
   else
      $(this).append("<textarea  style='width:100%' rows='6' value=''>"+ text +"</textarea>");
});
$(".claim-items").html($("#claim-items").html())

// create word template selection for deny reason
var $outer = $(".outer_custom_comment");
$outer.each(function(){
   var text = $.trim($('.word_templates').html());

   $(this).empty();
   $(this).append(text);
});

var $outer_select = $(".select-product");
$outer_select.each(function(){
   var text = $.trim($(this).text());

   $(this).empty();
   $(this).append($("#products").html());
});

</script>
