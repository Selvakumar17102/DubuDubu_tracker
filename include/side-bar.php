<?php
// ini_set('display_errors', 'off');
include("include/connection.php");

	$empid = $_SESSION['id'];
	$userSql = "SELECT * FROM employee WHERE id='$empid'";
	$userResult = $conn->query($userSql);
	$userRow = mysqli_fetch_array($userResult);
	$control = $userRow['control'];
?>

<!-- LEFT MAIN SIDEBAR -->
<div class="ec-left-sidebar ec-bg-sidebar d-print-none">
	<div id="sidebar" class="sidebar ec-sidebar-footer">
		<div class="ec-brand">
			<a href="profile_dashboard.php" title="DubuDubu">
				<img class="ec-brand-icon" src="assets/img/logo/favicon.png" alt="" />&nbsp;&nbsp;
				<span class="ec-brand-name text-truncate">DUBU DUBU</span>
			</a>	
		</div>
		<!-- begin sidebar scrollbar -->
		<div class="ec-navigation" data-simplebar>
			<!-- sidebar menu -->
			<ul class="nav sidebar-inner" id="sidebar-menu">
				<?php
					if($control == 1 || $control == 2){
				?>
						<!-- profile-Dashboard -->
						<li class="<?php echo $profiledashboard; ?>">
							<?php
								if($profiledashboardBoolean != 'true'){
									$profiledashboardBoolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $profiledashboardBoolean; ?>" href="profile_dashboard.php">
								<i class="mdi mdi-account-circle"></i>
								<span class="nav-text">Profile</span>
							</a>
							<hr>
						</li>

						<!-- Dashboard -->
						<li class="has-sub <?php echo $dashboard; ?>">
							<?php
								if($dashboardBoolean != 'true'){
									$dashboardBoolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $dashboardBoolean; ?>" href="javascript:void(0)">
								<i class="mdi mdi-view-dashboard-outline"></i>
								<span class="nav-text">Menu</span>  <b class="caret"></b>
							</a>
							<div class="collapse <?php echo $dash_show; ?>">
								<ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
									<li class="<?php echo $mail_apply; ?>">
										<a class="sidenav-item-link" href="mail.php" target="_blank">
											<span class="nav-text">Mail</span>
										</a>
									</li>
									<li class="<?php echo $mess_apply; ?>">
										<a class="sidenav-item-link" href="message.php" target="_blank">
											<span class="nav-text">Chat</span>
										</a>
									</li>
									<li class="<?php echo $cal_apply; ?>">
										<a class="sidenav-item-link" href="calendar.php" target="_blank">
											<span class="nav-text">Calendar</span>
										</a>
									</li>
								</ul>
							</div>
							<hr>
						</li>

						<!-- Attendance -->
						<li class="has-sub <?php echo $attendance; ?>">
							<?php
								if($atten_boolean != 'true'){
									$atten_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $atten_boolean; ?>" href="javascript:void(0)">
								<i class="mdi mdi-book"></i>
								<span class="nav-text">Attendance</span> <b class="caret"></b>
							</a>
							<div class="collapse <?php echo $attendance_show; ?>">
								<ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
									<li class="<?php echo $attendance_page; ?>">
										<a class="sidenav-item-link" href="attendance_page.php">
											<span class="nav-text">Attendance</span>
										</a>
									</li>
									<li class="<?php echo $leave_apply; ?>">
										<a class="sidenav-item-link" href="leave-apply.php">
											<span class="nav-text">Apply Leave</span>
										</a>
									</li>
									<li class="<?php echo $permission_apply; ?>">
										<a class="sidenav-item-link" href="permission-apply.php">
											<span class="nav-text">Permission</span>
										</a>
									</li>
								</ul>
							</div>
						</li>

						<!-- Pay roll -->
						<li class = "<?php echo $emppayslip; ?>">
							<?php
								if($emppayslip_boolean != 'true'){
									$emppayslip_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $emppayslip_boolean; ?>" href="emp_payslip.php">
								<i class="mdi mdi-file-document-box" ></i>
								<span class="nav-text">Payslip</span>
							</a>
						</li>

						<!-- holi day -->
						<li class = "<?php echo $holiday; ?>">
							<?php
								if($holiday_boolean != 'true'){
									$holiday_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $holiday_boolean; ?>" href="holiday.php">
								<i class="mdi mdi-file-document-box" ></i>
								<span class="nav-text">Holidays</span>
							</a>
						</li>
						
				<?php
					}else{
				?>
						<!-- profile-Dashboard -->
						<li class="<?php echo $profiledashboard; ?>">
							<?php
								if($profiledashboardBoolean != 'true'){
									$profiledashboardBoolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $profiledashboardBoolean; ?>" href="profile_dashboard.php">
								<i class="mdi mdi-account-circle"></i>
								<span class="nav-text">Profile</span>
							</a>
							<hr>
						</li>

						<!-- Dashboard -->
						<li class="has-sub <?php echo $dashboard; ?>">
							<?php
								if($dashboardBoolean != 'true'){
									$dashboardBoolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $dashboardBoolean; ?>" href="javascript:void(0)">
								<i class="mdi mdi-view-dashboard-outline"></i>
								<span class="nav-text">Menu</span>  <b class="caret"></b>
							</a>
							<div class="collapse <?php echo $dash_show; ?>">
								<ul class="sub-menu" id="categoryss" data-parent="#sidebar-menu">
									<li class="<?php echo $dash_apply; ?>">
										<a class="sidenav-item-link" href="dashboard.php">
											<span class="nav-text">Dashboard</span>
										</a>
									</li>
									<li class="<?php echo $mail_apply; ?>">
										<a class="sidenav-item-link" href="mail.php" target="_blank">
											<span class="nav-text">Mail</span>
										</a>
									</li>
									<li class="<?php echo $mess_apply; ?>">
										<a class="sidenav-item-link" href="message.php" target="_blank">
											<span class="nav-text">Chat</span>
										</a>
									</li>
									<li class="<?php echo $cal_apply; ?>">
										<a class="sidenav-item-link" href="calendar.php" target="_blank">
											<span class="nav-text">Calendar</span>
										</a>
									</li>
								</ul>
							</div>
							<hr>
						</li>

						<!-- masters -->
						<li class="has-sub <?php echo $master; ?>">
							<?php
								if($mas_boolean != 'true'){
									$mas_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $mas_boolean; ?>" href="javascript:void(0)">
								<i class="mdi mdi-account-card-details"></i>
								<span class="nav-text">Masters</span> <b class="caret"></b>
							</a>
							<div class="collapse <?php echo $mas_show; ?>">
								<ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
									<li class="<?php echo $com_apply; ?>">
										<a class="sidenav-item-link" href="company.php">
											<span class="nav-text">Company</span>
										</a>
									</li>

									<li class="<?php echo $dep_apply; ?>">
										<a class="sidenav-item-link" href="department.php">
											<span class="nav-text">Department</span>
										</a>
									</li>
									
									<li class="<?php echo $desig_apply; ?>">
										<a class="sidenav-item-link" href="designation.php">
											<span class="nav-text">Designation</span>
										</a>
									</li>

								</ul>
							</div>
						</li>
							
						<!-- Employee -->
						<li class="has-sub <?php echo $employee; ?>">
							<?php
								if($emp_boolean != 'true'){
									$emp_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $emp_boolean; ?>" href="javascript:void(0)">
								<i class="mdi mdi-account-card-details"></i>
								<span class="nav-text">Employees</span> <b class="caret"></b>
							</a>
							<div class="collapse <?php echo $emp_show; ?>">
								<ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
									<li class="<?php echo $emp_apply; ?>">
										<a class="sidenav-item-link" href="user-list.php">
											<span class="nav-text">Employee List</span>
										</a>
									</li>
									<li class="<?php echo $termi_apply; ?>">
										<a class="sidenav-item-link" href="termination-list.php">
											<span class="nav-text">Termination List</span>
										</a>
									</li>
									<li class="<?php echo $resig_apply; ?>">
										<a class="sidenav-item-link" href="resignation-list.php">
											<span class="nav-text">Resignation List</span>
										</a>
									</li>
									
								</ul>
							</div>
						</li>

						<!-- Attendance -->
						<li class="has-sub <?php echo $attendance; ?>">
							<?php
								if($atten_boolean != 'true'){
									$atten_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $atten_boolean; ?>" href="javascript:void(0)">
								<i class="mdi mdi-book"></i>
								<span class="nav-text">Attendance</span> <b class="caret"></b>
							</a>
							<div class="collapse <?php echo $attendance_show; ?>">
								<ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
									<li class="<?php echo $attendance_page; ?>">
										<a class="sidenav-item-link" href="attendance_page.php">
											<span class="nav-text">Attendance</span>
										</a>
									</li>
									<li class="<?php echo $leave_apply; ?>">
										<a class="sidenav-item-link" href="leave-apply.php">
											<span class="nav-text">Apply Leave</span>
										</a>
									</li>
									<li class="<?php echo $permission_apply; ?>">
										<a class="sidenav-item-link" href="permission-apply.php">
											<span class="nav-text">Permission</span>
										</a>
									</li>
									<li class="<?php echo $leave_details; ?>">
										<a class="sidenav-item-link" href="leave-details.php">
											<span class="nav-text">Leave Requests</span>
										</a>
									</li>

									<!-- <li class="<?php echo $daily_attendance; ?>">
										<a class="sidenav-item-link" href="attendance.php">
											<span class="nav-text">Daily Attendance</span>
										</a>
									</li> -->
								</ul>
							</div>
						</li>

						<!-- pay roll -->
						<li class="has-sub <?php echo $payroll; ?>">
							<?php
								if($pay_boolean != 'true'){
									$pay_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $pay_boolean; ?>" href="javascript:void(0)">
								<i class="mdi mdi-book"></i>
								<span class="nav-text">Pay Roll</span> <b class="caret"></b>
							</a>
							<div class="collapse <?php echo $pay_show; ?>">
								<ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
									<li class="<?php echo $emp_salary_page; ?>">
										<a class="sidenav-item-link" href="employee_salary.php">
											<span class="nav-text">Employee Salary</span>
										</a>
									</li>
									<li class="<?php echo $payslip_page; ?>">
										<a class="sidenav-item-link" href="emp_payslip.php">
											<span class="nav-text">Pay Slip</span>
										</a>
									</li>
									<li class="<?php echo $payroll_item; ?>">
										<a class="sidenav-item-link" href="payrollitem.php">
											<span class="nav-text">Payroll Item</span>
										</a>
									</li>
								</ul>
							</div>
						</li>

						<!-- holi day -->
						<li class = "<?php echo $holiday; ?>">
							<?php
								if($holiday_boolean != 'true'){
									$holiday_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $holiday_boolean; ?>" href="holiday.php">
								<i class="mdi mdi-file-document-box" ></i>
								<span class="nav-text">Holidays</span>
							</a>
						</li>
							
						<!-- pay roll -->
						<li class="has-sub <?php echo $recruitment; ?>">
							<?
								if($recruitment_boolean != 'true'){
									$recruitment_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $recruitment_boolean; ?>" href="javascript:void(0)">
								<i class="mdi mdi-briefcase-account"></i>
								<span class="nav-text">Recruitment</span> <b class="caret"></b>
							</a>
							<div class="collapse <?php echo $recruitment_show; ?>">
								<ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
									<li class="<?php echo $job_page; ?>">
										<a class="sidenav-item-link" href="jobs.php">
											<span class="nav-text">Jobs</span>
										</a>
									</li>
									<li class="<?php echo $candidate_page; ?>">
										<a class="sidenav-item-link" href="candidates.php">
											<span class="nav-text">Candidates</span>
										</a>
									</li>
									<li class="<?php echo $referrals_page; ?>">
										<a class="sidenav-item-link" href="referrals.php">
											<span class="nav-text">Referrals</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
							
						<!-- Comp-off -->
						<li class="<?php echo $comp; ?>">
							<?php
								if($comp_boolean != 'true'){
									$comp_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $comp_boolean; ?>" href="comp-off.php">
								<i class="mdi mdi-account-switch"></i>
								<span class="nav-text">Comp-off</span>
							</a>
						</li>
							
						<!-- Department -->
						<!-- <li class="<?php echo $dept; ?>">
							<?php
								if($dept_boolean != 'true'){
									$dept_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $dept_boolean; ?>" href="department.php">
								<i class="mdi mdi-forum"></i>
								<span class="nav-text">Department</span>
							</a>
						</li> -->
							
						<!-- Client -->
						<li class="<?php echo $client; ?>">
							<?php
								if($clientBoolean != 'true'){
									$clientBoolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $clientBoolean; ?>" href="client.php">
								<i class="mdi  mdi-account-multiple-plus" ></i>
								<span class="nav-text">client</span>
							</a>
						</li>
							
						<!-- Project -->
						<li class="<?php echo $project; ?>">
							<?php
								if($projectBoolean != 'true'){
									$projectBoolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $projectBoolean; ?>" href="project.php">
								<i class="mdi mdi-file-powerpoint-box" ></i>
								<span class="nav-text">project</span>
							</a>
						</li>
							
						<!-- Task -->
						<li class="<?php echo $task; ?>">
							<?php
								if($taskBoolean != 'true'){
									$taskBoolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $taskBoolean; ?>" href="all-tasks.php">
								<i class="mdi mdi-clipboard-check-outline"></i>
								<span class="nav-text">Task</span>
							</a>
						</li>
							
						<!-- Time Sheet -->
						<li class="has-sub <?php echo $timeSheet; ?>">
							<?php
								if($timeBoolean != 'true'){
									$timeBoolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $timeBoolean; ?>" href="javascript:void(0)">
								<i class="mdi mdi-timer-sand"></i>
								<span class="nav-text">Time Sheet</span> <b class="caret"></b>
							</a>
							<div class="collapse <?php echo $time_show; ?>">
								<ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
									<li class="<?php echo $timeSheet_apply; ?>">
										<a class="sidenav-item-link" href="timeSheet.php">
											<span class="nav-text">New Sheet</span>
										</a>
									</li>
									<li class="<?php echo $time_details; ?>">
										<a class="sidenav-item-link" href="pending-timeSheet.php">
											<span class="nav-text">Pending Sheet</span>
										</a>
									</li>
									<?php
										if($userRow['control'] != 1){
									?>
											<li class="<?php echo $time_approval; ?>">
												<a class="sidenav-item-link" href="approval-timeSheet.php">
													<span class="nav-text">Approval Sheet</span>
												</a>
											</li>
									<?php
										}
									?>
									<li class="<?php echo $time_approved; ?>">
										<a class="sidenav-item-link" href="approved-timeSheet.php">
											<span class="nav-text">Approved Sheet</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
									
						<!-- Invoice Service -->
						<li class="<?php echo $invoice_service; ?>">
							<?php
								if($invoiceServiceBoolean != 'true'){
									$invoiceServiceBoolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $invoiceServiceBoolean; ?>" href="invoice_service.php">
								<i class="mdi mdi-note-text" ></i>
								<span class="nav-text">Invoice Service</span>
							</a>
						</li>

						<!-- Invoice -->
						<li class="<?php echo $invoice; ?>">
							<?php
								if($invoiceBoolean != 'true'){
									$invoiceBoolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $invoiceBoolean; ?>" href="invoice.php">
								<i class="mdi mdi-note-text" ></i>
								<span class="nav-text">Invoice</span>
							</a>
						</li>

						<!-- Leave Utilization -->
						<li class = "<?php echo $leaveUti; ?>">
							<?php
								if($leaveUti_boolean != 'true'){
									$leaveUti_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $leaveUti_boolean; ?>" href="leave-utilization.php">
								<i class="mdi mdi-format-list-checks"></i>
								<span class="nav-text">Leave Utilization</span>
							</a>
						</li>
							
						<!-- Payslip -->
						<li class = "<?php echo $payslip; ?>">
							<?php
								if($payslip_boolean != 'true'){
									$payslip_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $payslip_boolean; ?>" href="payslip.php">
								<i class="mdi mdi-file-document-box" ></i>
								<span class="nav-text">Payslip</span>
							</a>
						</li>

						<!-- Payslip -->
						<!-- <li class = "<?php echo $payslip2; ?>">
							<?php
								if($payslip2_boolean != 'true'){
									$payslip2_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $payslip2_boolean; ?>" href="payslip_details.php">
								<i class="mdi mdi-file-document-box" ></i>
								<span class="nav-text">Payslip 2</span>
							</a>
						</li> -->

						<!-- Leave Claim -->
						<!-- <li class = "<?php echo $leaveClaim; ?>">
							<?php
								if($leaveClaim_boolean != 'true'){
									$leaveClaim_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $leaveClaim_boolean; ?>" href="leave-claim.php">
								<i class="mdi mdi-file-document-box" ></i>
								<span class="nav-text">Leave Claim</span>
							</a>
						</li> -->

						<!-- Reports -->
						<li class="has-sub <?php echo $report; ?>">
							<?php
								if($report_boolean != 'true'){
									$report_boolean = 'false';
								}
							?>
							<a class="sidenav-item-link" aria-expanded="<?php echo $report_boolean; ?>" href="javascript:void(0)">
								<i class="mdi mdi-chart-areaspline"></i>
								<span class="nav-text">Reports</span> <b class="caret"></b>
							</a>
							<div class="collapse <?php echo $report_show; ?>">
								<ul class="sub-menu" id="categorys" data-parent="#sidebar-menu">
									<li class="<?php echo $attendance_details; ?>">
										<a class="sidenav-item-link" href="report-list.php">
											<span class="nav-text">Attendance</span>
										</a>
									</li>
									<li class="<?php echo $project_details; ?>">
										<a class="sidenav-item-link" href="project_report.php">
											<span class="nav-text">Project</span>
										</a>
									</li>
									<li class="<?php echo $payslip_details; ?>">
										<a class="sidenav-item-link" href="payslip_report.php">
											<span class="nav-text">Payslip</span>
										</a>
									</li>
									<li class="<?php echo $employee_details; ?>">
										<a class="sidenav-item-link" href="employee_report.php">
											<span class="nav-text">Employee</span>
										</a>
									</li>
									<li class="<?php echo $leave_details; ?>">
										<a class="sidenav-item-link" href="leave_report.php">
											<span class="nav-text">Leave</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
				<?php
					}
				?>
			</ul>
		</div>
	</div>
</div>