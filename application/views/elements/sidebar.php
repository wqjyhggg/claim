<ul class="nav side-menu" style="">
	<?php if ($this->ion_auth->is_admin()): ?>
		<li> <?php echo anchor("auth/users", '<i class="fa fa-users"></i>Users Management</a>', array("class"=>'leftmeun')) ?> </li>
	<?php endif; ?>
	<li> <?php echo anchor("auth/mytasks", '<i class="fa fa-briefcase"></i>My Tasks</a>', array("class"=>'leftmeun')) ?> </li>

	<li> <?php echo anchor("emergency_assistance", '<i class="fa fa-briefcase"></i>Emergency assistance</a>', array("class"=>'leftmeun')) ?> </li>

	<?php if ($this->ion_auth->is_admin() OR $this->ion_auth->is_casemamager()): ?>
	<li>  <?php echo anchor("emergency_assistance/case_management", '<i class="fa fa-list-ul"></i>Case management</a>', array("class"=>'leftmeun')) ?> </li>
	<?php endif; ?>

	<li> <?php echo anchor("claim", '<i class="fa fa-files-o"></i>Claim</a>', array("class"=>'leftmeun')) ?> </li>

	<li> <a href="#" class="leftmeun"><i class="fa fa-upload"></i>Upload claim</a> </li>

	<?php if ($this->ion_auth->is_casemamager()): ?>
	<li> <?php echo anchor("emergency_assistance/schedule", '<i class="fa fa-calendar"></i>Schedule</a>', array("class"=>'leftmeun')) ?> </li>
	<?php endif; ?>

	<li> <a href="#" class="leftmeun"><i class="fa fa-list-alt"></i>Report</a> </li>

	<li> <a href="#" class="leftmeun"><i class="fa fa-money"></i>Payments</a> </li>

	<li> <a href="#" class="leftmeun"><i class="fa fa-user"></i>HR management</a> </li>

	<li> <?php echo anchor("auth/logout", '<i class="fa fa-power-off"></i>Logout</a>', array("class"=>'leftmeun')) ?> </li>
</ul>