<ul class="nav side-menu" style="">
	<?php if ($this->ion_auth->is_admin()): ?>
		<li> <?php echo anchor("auth/users", '<i class="fa fa-users"></i>Users Management</a>', array("class"=>'leftmeun')) ?> </li>
	<?php endif; ?>
	<li> <a href="#" class="leftmeun"><i class="fa fa-briefcase"></i>My task</a> </li>

	<li> <a href="#" class="leftmeun"><i class="fa fa-briefcase"></i>Emergency assistance</a> </li>

	<li> <a href="#" class="leftmeun"><i class="fa fa-list-ul"></i>Case management</a> </li>

	<li> <a href="#" class="leftmeun"><i class="fa fa-files-o"></i>Claim</a> </li>

	<li> <a href="#" class="leftmeun"><i class="fa fa-upload"></i>Upload claim</a> </li>

	<li> <a href="#" class="leftmeun"><i class="fa fa-calendar"></i>Schedule</a> </li>

	<li> <a href="#" class="leftmeun"><i class="fa fa-list-alt"></i>Report</a> </li>

	<li> <a href="#" class="leftmeun"><i class="fa fa-money"></i>Payments</a> </li>

	<li> <a href="#" class="leftmeun"><i class="fa fa-user"></i>HR management</a> </li>

	<li> <?php echo anchor("auth/logout", '<i class="fa fa-power-off"></i>Logout</a>', array("class"=>'leftmeun')) ?> </li>
</ul>