<ul class="nav side-menu" style="">
	<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN))): ?>
	<li> <?php echo anchor("auth/users", '<i class="fa fa-users"></i>Users Management', array("class"=>'leftmeun')) ?> </li>
	<?php endif; ?>
	<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_EXAMINER, Users_model::GROUP_MANAGER))) : ?>
	<li> <?php echo anchor("provider", '<i class="fa fa-briefcase"></i>Provider', array("class"=>'leftmeun')) ?> </li>
	<li> <?php echo anchor("blocklist", '<i class="fa fa-briefcase"></i>Block List', array("class"=>'leftmeun')) ?> </li>
	<?php endif; ?>
	<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_EAC, Users_model::GROUP_EXAMINER, Users_model::GROUP_MANAGER))) : ?>
	<li> <?php echo anchor("auth/mytasks/CLAIM", '<i class="fa fa-briefcase"></i>My Claim', array("class"=>'leftmeun')) ?> </li>
	<li> <?php echo anchor("auth/mytasks/CASE", '<i class="fa fa-briefcase"></i>My Case', array("class"=>'leftmeun')) ?> </li>
	<li> <?php echo anchor("emergency_assistance", '<i class="fa fa-briefcase"></i>Emergency assistance', array("class"=>'leftmeun')) ?> </li>
	<?php endif; ?>
	<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER))) : ?>
	<li> <?php echo anchor("eclaim", '<i class="fa fa-briefcase"></i>Eclaim', array("class"=>'leftmeun')) ?> </li>
	<?php endif; ?>

	<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_INSURER, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER, Users_model::GROUP_MANAGER))) : ?>
	<li>  <?php echo anchor("emergency_assistance/case_management", '<i class="fa fa-list-ul"></i>Case management', array("class"=>'leftmeun')) ?> </li>
	<?php endif; ?>

	<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_INSURER, Users_model::GROUP_CLAIMER, Users_model::GROUP_EXAMINER, Users_model::GROUP_ACCOUNTANT))) : ?>
	<li> <?php echo anchor("claim", '<i class="fa fa-files-o"></i>Claim', array("class"=>'leftmeun')) ?> </li>
	<?php endif; ?>

	<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EAC))) : ?>
	<li> <?php echo anchor("emergency_assistance/schedule", '<i class="fa fa-calendar"></i>Schedule', array("class"=>'leftmeun')) ?> </li>
	<?php endif; ?>
	<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_MANAGER, Users_model::GROUP_EXAMINER, Users_model::GROUP_INSURER, Users_model::GROUP_EAC))): ?>
	<li> <?php echo anchor("report", '<i class="fa fa-list-alt"></i>Report', array("class"=>'leftmeun')) ?> </li>
	<?php endif; ?>
	<?php if ($this->ion_auth->in_group(array(Users_model::GROUP_ADMIN, Users_model::GROUP_ACCOUNTANT))) : ?>
	<li> <?php echo anchor("claim/payments", '<i class="fa fa-money"></i>Payments', array("class"=>'leftmeun')) ?> </li>
	<?php endif; ?>

	<li> <?php echo anchor("auth/password", '<i class="fa fa-cog"></i>Change Password', array("class"=>'leftmeun')) ?> </li>
	<li> <?php echo anchor("auth/logout", '<i class="fa fa-power-off"></i>Logout', array("class"=>'leftmeun')) ?> </li>
</ul>
