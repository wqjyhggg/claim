<div>
	<div class="page-title">
		<?php 
			if ($this->input->get ( 'type' ) == 'add_claim') {
				echo anchor ( "claim/create_claim?policy=", '<i class="fa fa-plus-circle"></i> New Claim', array ("class" => 'btn btn-primary new_claim') );
			}
		?>
		<?php
			if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER))) {
				echo anchor("emergency_assistance/create_provider", '<i class="fa fa-plus-circle"></i> New Provider', array("class"=>'btn btn-primary'));
			}
		?>
		<a class="btn btn-primary pull-right" onclick="window.history.back()"><i class="fa fa-arrow-left"></i>Back</a>
	</div>
	<div class="clearfix"></div>
	<!-- Policy search and List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Policy Details<small></small></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-group col-sm-3">
						<label><span>Policy No: </span><span class="policy"><?php echo (isset($policy['policy']) ? $policy['policy'] : ''); ?></span></label>
					</div>
					<div class="form-group col-sm-3">
						<label style="text-transform: capitalize;"><span>By Agent: </span><span class="agent_firstname"><?php echo (isset($policy['agent_firstname']) ? $policy['agent_firstname'] : ''); ?></span> <span class="agent_lastname"><?php echo (isset($policy['agent_lastname']) ? $policy['agent_lastname'] : ''); ?></span></label>
					</div>
					<div class="form-group col-sm-3">
						<label style="text-transform: capitalize;"><span>Status: </span><?php echo (isset($policy['status_id']) ? $policy_status[$policy['status_id']]['name'] : ''); ?></label>
					</div>
					<?php if (isset($policy['product_short']) && ($policy['product_short'] == 'TOP')) { ?>
					<div class="form-group col-sm-3">
						<label style="text-transform: capitalize;"><span>Package: </span><?php echo (isset($policy['package']) ? preg_replace('/_/', " ", $policy['package']) : ''); ?></label>
					</div>
					<?php if ($policy['package'] == 'all_inclusive') { ?>
					<div class="form-group col-sm-3">
						<label style="text-transform: capitalize;">Medical : $10,000,000</label>
					</div>
					<div class="form-group col-sm-3">
						<label style="text-transform: capitalize;">AD&D : $100,000</label>
					</div>
					<div class="form-group col-sm-3">
						<label style="text-transform: capitalize;">Flight Accident: $300,000</label>
					</div>
					<div class="form-group col-sm-3">
						<label style="text-transform: capitalize;">Trip Cancellation and Interruption: $<?php echo number_format($policy['sum_insured'], 2); ?></label>
					</div>
					<?php if ($policy['free_cancel']) { ?>
					<div class="form-group col-sm-3">
						<label style="text-transform: capitalize;">Cancel trip for any reason</label>
					</div>
					<?php } ?>
					<?php } else if (($policy['package'] == 'single_medical_plan') || ($policy['package'] == 'optional_plan')) { ?>
					<?php     if ($policy['package'] == 'single_medical_plan') { ?>
					<div class="form-group col-sm-3">
						<label style="text-transform: capitalize;">Sum Insured: $10,000,000</label>
					</div>
					<?php     } ?>
					<?php     if ($policy['ad_and_d_ck']) { ?>
					<div class="form-group col-sm-3">
						<label style="text-transform: capitalize;">AD & D : $<?php echo number_format($policy['ad_and_d_insured'], 2); ?></label>
					</div>
					<?php     } ?>
					<?php     if ($policy['flight_accident_ck']) { ?>
					<div class="form-group col-sm-3">
						<label style="text-transform: capitalize;">Flight Accident : $<?php echo number_format($policy['flight_accident_insured'], 2); ?></label>
					</div>
					<?php     } ?>
					<?php     if ($policy['trip_cancellation_ck']) { ?>
					<div class="form-group col-sm-3">
						<label style="text-transform: capitalize;">Trip Cancellation : $<?php echo number_format($policy['trip_cancellation_insured'], 2); ?></label>
					</div>
					<?php     } ?>
					<?php } else if ($policy['package'] == 'annual_plan') { ?>
					<div class="form-group col-sm-3">
						<label style="text-transform: capitalize;">Selected days : <?php echo $policy['annual_plan_days']; ?></label>
					</div>
					<?php } ?>
					<?php if ($policy['stable_condition']) { ?>
					<div class="form-group col-sm-6">
						<label style="text-transform: capitalize;"><?php echo ($policy['stable_condition'] == 1) ? 'Including' : 'Excluding'; ?> stable pre-existing condition coverage</label>
					</div>
					<?php } ?>
					<?php if ($policy['questionnaire']) { ?>
					<div class="form-group col-sm-6">
						<label style="text-transform: capitalize;">
							<span>With Questionnaire answers</span> 
							<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Question 1 : 
								<?php if ($policy['question1'] == 4) { ?> 3 or more medications
								<?php } else if ($policy['question1'] == 3) { ?> 2 medications
								<?php } else if ($policy['question1'] == 2) { ?> 1 medication
								<?php } else  { ?> none <?php } ?>
								</span>
							<?php if ($policy['question2']) { ?>
							<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Question 2 : 
								<?php if ($policy['question2']) { ?>
								<?php     if ($policy['question2'] == 2) { ?> Yes
								<?php     } else  { ?> No <?php } ?> 
								<?php } ?>
								</span>
							<?php if ($policy['question3']) { ?>
							<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Question 3 : 
								<?php if ($policy['question3']) { ?>
								<?php     if ($policy['question3'] == 3) { ?> 2 or more medical conditions
								<?php     } else if ($policy['question3'] == 2) { ?> 1 medical condition
								<?php     } else  { ?> none <?php } ?> 
								<?php } ?>
								</span>
							<?php if ($policy['question4']) { ?>
							<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Question 4 : 
								<?php if ($policy['question4']) { ?>
								<?php     if ($policy['question4'] == 2) { ?> Yes
								<?php     } else  { ?> No <?php } ?> 
								<?php } ?>
								</span>
							<?php if ($policy['question5']) { ?>
							<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Question 5 : 
								<?php if ($policy['question5']) { ?>
								<?php     if ($policy['question2'] == 2) { ?> Yes
								<?php     } else  { ?> No <?php } ?> 
								<?php } ?>
								</span>
							<?php } // question5 ?>
							<?php } // question4 ?>
							<?php } // question3 ?>
							<?php } // question2 ?>
							<?php } // questionnaire ?>
						</label>
					</div>
					<?php } ?>
					<div class="clearfix"></div>
					<div class="form-group col-sm-12">
						<label style="text-transform: capitalize;"><span>Notes: </span></label> <?php echo isset($policy['note']) ? $policy['note'] : ''; ?>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-12"></div>
				</div>
				<?php if(!empty($cases)) : ?>
				<div class="table-responsive">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>Case Number</th>
								<th>Create Date</th>
								<th>Reason</th>
								<th>Insured Name</th>
								<th>Follow Up EAC</th>
								<th>Case Manager</th>
								<th>Priority</th>
								<th>Status</th>
								<th>Last Update</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($cases as $value): ?>
                              <tr class="view-policies" data='<?php echo json_encode($value); ?>'>
                                 <td><?php echo anchor("emergency_assistance/edit_case/".$value['id'], $value['case_no']); ?></td>
                                 <td><?php echo substr($value['created'], 0, 10); ?></td>
                                 <td><?php echo $value['reason']; ?></td>
                                 <td><?php echo $value['insured_firstname'] . " " . $value['insured_lastname']; ?></td>
                                 <td><?php echo $value['assign_to_email']; ?></td>
                                 <td><?php echo $value['case_manager_email']; ?></td>
                                 <td><?php echo $value['priority']; ?></td>
                                 <td><?php echo ($value['status'] == 'A') ? "Active" : "Inactive"; ?></td>
                                 <td><?php echo substr($value['last_update'], 0, 10); ?></td>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                  </table>
               </div>               
               <?php else:?>
               <center><?php echo heading("No related case", 4); ?></center>
               <?php endif;?>
				<br>
				<div class="row">
					<div class="col-sm-12"></div>
				</div>
				<?php if(!empty($claims)) : ?>
				<div class="table-responsive">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>Claim Number</th>
								<th>Create Date</th>
								<th>Insured Name</th>
								<th>Examiner</th>
								<th>Status</th>
								<th>Last Update</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($claims as $value): ?>
                              <tr class="view-policies" data='<?php echo json_encode($value); ?>'>
                                 <td><?php echo anchor("claim/claim_detail/".$value['id'], $value['claim_no']); ?></td>
                                 <td><?php echo substr($value['created'], 0, 10); ?></td>
                                 <td><?php echo $value['insured_first_name'] . " " . $value['insured_last_name']; ?></td>
                                 <td><?php echo $value['assign_to_email']; ?></td>
                                 <td><?php echo $value['status']; ?></td>
                                 <td><?php echo substr($value['last_update'], 0, 10); ?></td>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                  </table>
               </div>               
               <?php else:?>
               <center><?php echo heading("No related claims", 4); ?></center>
               <?php endif;?>
				<div class="row">
					<div class="col-sm-12">
						<fieldset>
							<legend>Travel Dates</legend>
							<div class="row">
								<div class="form-group col-sm-3">
									<label><span>Apply Date : </span></label> <span class="apply_date"><?php echo (isset($policy['apply_date']) ? $policy['apply_date'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Arrival Date : </span></label> <span class="arrival_date"><?php echo (isset($policy['arrival_date']) ? $policy['arrival_date'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Effective Date : </span></label> <span class="effective_date"><?php echo (isset($policy['effective_date']) ? $policy['effective_date'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Expiry Date : </span></label> <span class="expiry_date"><?php echo (isset($policy['expiry_date']) ? $policy['expiry_date'] : ''); ?></span>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-3">
									<label><span>Days : </span></label> <span class="totaldays"><?php echo (isset($policy['totaldays']) ? $policy['totaldays'] : ''); ?></span>
								</div>
								<?php if (isset($policy['status_id']) && ($policy['status_id'] == 6)) : ?>
								<div class="form-group col-sm-3">
									<label><span>Refund date : </span></label> <span class="refund_date"><?php echo (isset($policy['refund_date']) ? $policy['refund_date'] : ''); ?></span>
								</div>
								<?php endif; ?>
							</div>
						</fieldset>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-12">
						<fieldset>
							<legend>Insurable Information</legend>
							<div class="row">
								<div class="form-group col-sm-3">
									<label><span>Beneficiary : </span></label> <span class="beneficiary"><?php echo (isset($policy['beneficiary']) ? $policy['beneficiary'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Sum Insured : </span></label> $<span class="sum_insured"><?php echo (isset($policy['sum_insured']) ? $policy['sum_insured'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Deductible Amount : </span></label> $<span class="deductible_amount"><?php echo (isset($policy['deductible_amount']) ? $policy['deductible_amount'] : ''); ?></span>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-3">
									<label><span>Student ID : </span></label> <span class="student_id"><?php echo (isset($policy['student_id']) ? $policy['student_id'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>School Name : </span></label> <span class="institution"><?php echo (isset($policy['institution']) ? $policy['institution'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>School Address : </span></label> <span class="institution_addr"><?php echo (isset($policy['institution_addr']) ? $policy['institution_addr'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>School Phone : </span></label> <span class="institution_phone"><?php echo (isset($policy['institution_phone']) ? $policy['institution_phone'] : ''); ?></span>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-12">
						<fieldset>
							<legend>Insurable Members</legend>
							<div class="row">
								<div class="form-group col-sm-3">
									<label><span>Name : </span></label>
									<span class="firstname"><?php echo (isset($policy['firstname']) ? $policy['firstname'] : ''); ?></span>
									<span class="lastname"><?php echo (isset($policy['lastname']) ? $policy['lastname'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Birth Date : </span></label> <span class="birthday"><?php echo (isset($policy['birthday']) ? $policy['birthday'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Gender : </span></label> <span class="gender"><?php echo (isset($policy['gender']) ? $policy['gender'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<span class="creates">
										<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER))) { ?>
										<a href="<?php echo $create_claim_url; ?>" class="btn btn-primary">New Claim</a>
										<?php } ?>
										<a href="<?php echo $create_case_url; ?>" class="btn btn-primary">New Case</a>
									</span>
								</div>
							</div>
							<?php if (!empty($policy['family'])) { ?>
							<?php foreach ($policy['family'] as $key => $val) { ?>
							<div class="row">
								<div class="form-group col-sm-3">
									<label><span>Name : </span></label>
									<span class="firstname"><?php echo $val['firstname']; ?></span>
									<span class="lastname"><?php echo $val['lastname']; ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Birth Date : </span></label> <span class="birthday"><?php echo $val['birthday']; ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Gender : </span></label> <span class="gender"><?php echo $val['gender']; ?></span>
								</div>
								<div class="form-group col-sm-3">
									<span class="creates">
										<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER))) { ?>
										<a href="<?php echo $val['create_claim_url']; ?>" class="btn btn-primary">New Claim</a>
										<?php } ?>
										<a href="<?php echo $val['create_case_url']; ?>" class="btn btn-primary">New Case</a>
									</span>
								</div>
							</div>
							<?php } ?>
							<?php } ?>
						</fieldset>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-12">
						<fieldset>
							<legend>Address</legend>
							<div class="row">
								<div class="form-group col-sm-3">
									<label><span>Street# : </span></label> <span class="street_number"><?php echo (isset($policy['street_number']) ? $policy['street_number'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Street Name : </span></label> <span class="street_name"><?php echo (isset($policy['street_name']) ? $policy['street_name'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Suite# : </span></label> <span class="suite_number"><?php echo (isset($policy['suite_number']) ? $policy['suite_number'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>City : </span></label> <span class="city"><?php echo (isset($policy['city']) ? $policy['city'] : ''); ?></span>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-3">
									<label><span>Province : </span></label> <span class="province2"><?php echo (isset($policy['province2']) ? $policy['province2'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Country : </span></label> <span class="country2"><?php echo (isset($policy['country2']) ? $policy['country2'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Postcode : </span></label> <span class="postcode"><?php echo (isset($policy['postcode']) ? $policy['postcode'] : ''); ?></span>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-3">
									<label><span>Phone1 : </span></label> <span class="phone1"><?php echo (isset($policy['phone1']) ? $policy['phone1'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Phone2 : </span></label> <span class="phone2"><?php echo (isset($policy['phone2']) ? $policy['phone2'] : ''); ?></span>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-12">
						<fieldset>
							<legend>Contact</legend>
							<div class="row">
								<div class="form-group col-sm-3">
									<label><span>Email : </span></label> <span class="contact_email"><?php echo (isset($policy['contact_email']) ? $policy['contact_email'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Phone : </span></label> <span class="contact_phone"><?php echo (isset($policy['contact_phone']) ? $policy['contact_phone'] : ''); ?></span>
								</div>
								<div class="form-group col-sm-3">
									<label><span>Residence : </span></label> <span class="residence"><?php echo (isset($policy['residence']) ? $policy['residence'] : ''); ?></span>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-12"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
