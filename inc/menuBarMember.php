<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="#"><?php echo $companyName; ?></a>
			<ul class="nav">
				<li id="scheduleMenuItem" class="">
					<a href="./schedule.php"><i class="icon-calendar"></i> Schedule</a>
				</li>
				<li id="optionsMenuItem" class="">
					<a href="./options.php"><i class="icon-calendar"></i> Options</a>
				</li>
			</ul>
			<ul class="nav pull-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $memberLoginName; ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li id="memberProfileMenuItem"><a href="./editMemberInfoForm.php">Member Profile</a></li>
						<li id="changePasswordMenuItem"><a href="./changePasswordForm.php">Change Password</a></li>
						<li class="divider"></li>
						<li id="addNewMemberMenuItem"><a href="./addNewMemberForm.php"><i class="icon-cog"></i> Add New Member</a></li>
						<li class="divider"></li>
						<li>
							<a href="javascript:logout()"><i class="icon-user"></i> Logout</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>