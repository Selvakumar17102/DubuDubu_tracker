<?php

session_start();
include("include/connection.php");
$today = date('Y-m-d');

// if(empty($_SESSION['id'])){
// 	header('location: sign-in.php');
// }
// else{
	$userId = $_SESSION['id'];
	// echo $userId; exit();
	$emp_sql = "SELECT * FROM employee WHERE id='$userId'";
	$emp_result = $conn->query($emp_sql);
	$emp_row = mysqli_fetch_array($emp_result);
// }

// notification for leave
$leave_sql = "SELECT * FROM employee_leave a LEFT OUTER JOIN employee b ON a.emp_id = b.id WHERE a.tl_status = 0";
$leave_result = $conn->query($leave_sql);

// notification for timesheet
$time_sql = "SELECT * FROM time_sheet a LEFT OUTER JOIN employee b ON a.employee = b.id LEFT OUTER JOIN project c ON a.project_id = c.id WHERE a.time_sheet_status = 1";
$time_result = $conn->query($time_sql);
?>

			<header class="ec-main-header d-print-none" id="header">
				<nav class="navbar navbar-static-top navbar-expand-lg">
					
					<button id="sidebar-toggler" class="sidebar-toggle"></button>
					
					<img id="timeImage" src="" width="60" height="60">
					<h5 id="greeting"></h5>&nbsp;&nbsp;
					<h5><?php echo $emp_row['fname'];?>&nbsp;<?php echo $emp_row['lname'];?></h5>

					
					<div class="search-form d-lg-inline-block">
						<div id="search-results-container">
							<ul id="search-results"></ul>
						</div>
					</div>

					<p id="timeing"></p>

					<div class="navbar-right">
						<ul class="nav navbar-nav">
							<li class="dropdown user-menu">
								<button class="dropdown-toggle nav-link ec-drop" data-bs-toggle="dropdown"
									aria-expanded="false">
									<?php
									$firstname=$emp_row['fname'];
									$secondname=$emp_row['lname'];
									?>
									<div class="btn bg-primary-color">
										<p><?php echo ucfirst(substr($firstname,0,1)).ucfirst(substr($secondname,0,1));?></p>
									</div>
									
								</button>
								<ul class="dropdown-menu dropdown-menu-right ec-dropdown-menu">
									<li class="dropdown-header">
										<img src="<?= $emp_row['emp_photo'];?>" class="img-circle" alt="User Image" />
										<div class="d-inline-block">
											<?php echo $emp_row['fname'];?>&nbsp;<?php echo $emp_row['lname'];?> <small class="pt-1"><?php echo $emp_row['oemail'];?></small>
										</div>
									</li>
									<li class="dropdown-body">
										<a href="change-password.php"><i class="mdi mdi-textbox-password"></i> Change password</a>
									</li>
									<li class="dropdown-footer">
										<a href="javascript:void(0);" onclick="logOut()"> <i class="mdi mdi-logout"></i> Log Out </a>
									</li>
								</ul>
							</li>
							<?php
								if($leave_result->num_rows == 0 && $time_result->num_rows == 0){
									$display = "notify-alert";
								}
								else{
									$display = "";
								}
							?>
							<li class="dropdown notifications-menu custom-dropdown <?= $display; ?>">
								<button class="dropdown-toggle notify-toggler custom-dropdown-toggler">
									<i class="mdi mdi-bell-outline"></i>
								</button>

								<div class="card card-default dropdown-notify dropdown-menu-right mb-0">
									<div class="card-header card-header-border-bottom px-3">
										<h2>Notifications</h2>
									</div>

									<div class="card-body px-0 py-0">
										<ul class="nav nav-tabs nav-style-border p-0 justify-content-between" id="myTab"
											role="tablist">
											<li class="nav-item mx-3 my-0 py-0">
												<a href="#" class="nav-link active pb-3" id="home2-tab"
													data-bs-toggle="tab" data-bs-target="#home2" role="tab"
													aria-controls="home2" aria-selected="true">All</a>
											</li>

											<li class="nav-item mx-3 my-0 py-0">
												<a href="#" class="nav-link pb-3" id="timesheet2-tab" data-bs-toggle="tab"
													data-bs-target="#timesheet2" role="tab" aria-controls="timesheet2"
													aria-selected="false">Timesheet</a>
											</li>

											<li class="nav-item mx-3 my-0 py-0">
												<a href="#" class="nav-link pb-3" id="leave2-tab" data-bs-toggle="tab"
													data-bs-target="#leave2" role="tab" aria-controls="leave2"
													aria-selected="false">Leave</a>
											</li>
										</ul>

										<div class="tab-content" id="myNotifications">
											<div class="tab-pane fade show active" id="home2" role="tabpanel">
												<ul class="list-unstyled" data-simplebar style="height: 360px">
												<?php
													if($leave_result->num_rows > 0){
													while($leave_row = mysqli_fetch_array($leave_result)){
														$fName = $leave_row['fname'];
														$lName = $leave_row['lname'];
												?> 
													<li>
														<a href="leave-details.php"
															class="media media-message media-notification">
															<div
																class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 notification-color">
																<?php echo ucfirst(substr($fName,0,1)).ucfirst(substr($lName,0,1));?>
															</div>
															<div class="media-body d-flex justify-content-between">
																<div class="message-contents">
																	<h4 class="title"><?php echo $leave_row['fname']." ".$leave_row['lname']; ?></h4>
																	<p class="last-msg font-size-14"><?php echo $leave_row['type']; ?></p>
																	<?php
																		$appDate = $leave_row['applied_date'];
																		if($appDate <= $today){
																			$diff1 = abs(strtotime($today) - strtotime($appDate));
																			$years1 = floor($diff1/(365*60*60*24));
																			$months1 = floor(($diff1 - $years1 * 365*60*60*24) / (30*60*60*24));
																			$days1 = floor(($diff1 - $years1 * 365*60*60*24 - $months1*30*60*60*24)/ (60*60*24));
																			if($days1 == 0){
																				$value1 = "Today";
																			}
																			elseif($days1 == 1){
																				$value1 = "Yesterday";
																			}
																			else{
																				$value1 = $days1." "."days ago";
																			}
																		}
																	?>
																	<span
																		class="font-size-12 font-weight-medium text-secondary">
																		<i class="mdi mdi-clock-outline"></i><?= " ".$value1; ?></span>
																</div>
															</div>
														</a>
													</li>
												<?php
													}
												}
												?>

												<?php
													if($time_result->num_rows > 0){
													while($time_row = mysqli_fetch_array($time_result)){
														$fName1 = $time_row['fname'];
														$lName1 = $time_row['lname'];
												?>
													<li>
														<a href="approval-timeSheet.php"
															class="media media-message media-notification">
															<div
																class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 notification-color">
																<?php echo ucfirst(substr($fName1,0,1)).ucfirst(substr($lName1,0,1));?>
															</div>
															<div class="media-body d-flex justify-content-between">
																<div class="message-contents">
																	<h4 class="title"><?php echo $time_row['fname']." ".$time_row['lname']; ?></h4>
																	<p class="last-msg"><?php echo $time_row['project_name']; ?></p>
																	<?php
																		$date = $time_row['date'];
																		if($date <= $today){
																			$diff = abs(strtotime($today) - strtotime($date));
																			$years = floor($diff/(365*60*60*24));
																			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
																			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
																			if($days == 0){
																				$value = "Today";
																			}
																			elseif($days == 1){
																				$value = "Yesterday";
																			}
																			else{
																				$value = $days." "."days ago";
																			}
																		}
																	?>
																	<span
																		class="font-size-12 font-weight-medium text-secondary">
																		<i class="mdi mdi-clock-outline"></i><?= " ".$value; ?></span>
																</div>
															</div>
														</a>
													</li>
												<?php
													}
													}
													if($leave_result->num_rows == 0 && $time_result->num_rows == 0){
												?>
														<li>
															<h4 class="title pt-4" style="text-align: center">No Notifications</h4>
														</li>
												<?php
													}
												?>
												</ul>
											</div>

											<div class="tab-pane fade" id="timesheet2" role="tabpanel">
												<ul class="list-unstyled" data-simplebar style="height: 360px">
												<?php
													$time_sql1 = "SELECT * FROM time_sheet a LEFT OUTER JOIN employee b ON a.employee = b.id LEFT OUTER JOIN project c ON a.project_id = c.id WHERE a.time_sheet_status = 1";
													$time_result1 = $conn->query($time_sql1);
													if($time_result1->num_rows > 0){
														while($time_row1 = mysqli_fetch_array($time_result1)){
															$fName_time = $time_row1['fname'];
															$lName_time = $time_row1['lname'];
												?>
														<li>
															<a href="approval-timeSheet.php"
																class="media media-message media-notification">
																<div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 notification-color">
																	<?php echo ucfirst(substr($fName_time,0,1)).ucfirst(substr($lName_time,0,1));?>
																</div>
																<div class="media-body d-flex justify-content-between">
																	<div class="message-contents">
																		<h4 class="title"><?php echo $time_row1['fname']." ".$time_row1['lname']; ?></h4>
																		<p class="last-msg"><?php echo $time_row1['project_name']; ?></p>
																		<?php
																			$date = $time_row1['date'];
																			if($date <= $today){
																				$diff = abs(strtotime($today) - strtotime($date));
																				$years = floor($diff/(365*60*60*24));
																				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
																				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
																				if($days == 0){
																					$value_time = "Today";
																				}
																				elseif($days == 1){
																					$value_time = "Yesterday";
																				}
																				else{
																					$value_time = $days." "."days ago";
																				}
																			}
																		?>
																		<span
																			class="font-size-12 font-weight-medium text-secondary">
																			<i class="mdi mdi-clock-outline"></i><?= " ".$value_time; ?></span>
																	</div>
																</div>
															</a>
														</li>
												<?php
														}
													}
													else{
												?>
														<li>
															<h4 class="title pt-4" style="text-align: center">No Timesheet Requested</h4>
														</li>
												<?php
													}
												?>
												</ul>
											</div>

											<div class="tab-pane fade" id="leave2" role="tabpanel">
												<ul class="list-unstyled" data-simplebar style="height: 360px">
												<?php
													$leave_sql1 = "SELECT * FROM employee_leave a LEFT OUTER JOIN employee b ON a.emp_id = b.id WHERE a.tl_status = 0";
													$leave_result1 = $conn->query($leave_sql1);
													if($leave_result1->num_rows > 0){
														while($leave_row1 = mysqli_fetch_array($leave_result1)){
															$fName_leave = $leave_row1['fname'];
															$lName_leave = $leave_row1['lname'];
												?> 
														<li>
															<a href="leave-details.php"
																class="media media-message media-notification">
																<div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 notification-color">
																	<?php echo ucfirst(substr($fName_leave,0,1)).ucfirst(substr($lName_leave,0,1));?>
																</div>
																<div class="media-body d-flex justify-content-between">
																	<div class="message-contents">
																		<h4 class="title"><?php echo $leave_row1['fname']." ".$leave_row1['lname']; ?></h4>
																		<p class="last-msg font-size-14"><?php echo $leave_row1['type']; ?></p>
																		<?php
																			$appDate = $leave_row1['applied_date'];
																			if($appDate <= $today){
																				$diff1 = abs(strtotime($today) - strtotime($appDate));
																				$years1 = floor($diff1/(365*60*60*24));
																				$months1 = floor(($diff1 - $years1 * 365*60*60*24) / (30*60*60*24));
																				$days1 = floor(($diff1 - $years1 * 365*60*60*24 - $months1*30*60*60*24)/ (60*60*24));
																				if($days1 == 0){
																					$value_leave = "Today";
																				}
																				elseif($days1 == 1){
																					$value_leave = "Yesterday";
																				}
																				else{
																					$value_leave = $days1." "."days ago";
																				}
																			}
																		?>
																		<span
																			class="font-size-12 font-weight-medium text-secondary">
																			<i class="mdi mdi-clock-outline"></i><?= " ".$value_leave; ?></span>
																	</div>
																</div>
															</a>
														</li>
												<?php
														}
													}
													else{
												?>
														<li>
															<h4 class="title pt-4" style="text-align: center">No Leave Requested</h4>
														</li>
												<?php
													}
												?>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<ul class="dropdown-menu dropdown-menu-right d-none">
									<li class="dropdown-header">You have 5 notifications</li>
									<li>
										<a href="#">
											<i class="mdi mdi-account-plus"></i> New user registered
											<span class=" font-size-12 d-inline-block float-right"><i
													class="mdi mdi-clock-outline"></i> 10 AM</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="mdi mdi-account-remove"></i> User deleted
											<span class=" font-size-12 d-inline-block float-right"><i
													class="mdi mdi-clock-outline"></i> 07 AM</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="mdi mdi-chart-areaspline"></i> Sales report is ready
											<span class=" font-size-12 d-inline-block float-right"><i
													class="mdi mdi-clock-outline"></i> 12 PM</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="mdi mdi-account-supervisor"></i> New client
											<span class=" font-size-12 d-inline-block float-right"><i
													class="mdi mdi-clock-outline"></i> 10 AM</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="mdi mdi-server-network-off"></i> Server overloaded
											<span class=" font-size-12 d-inline-block float-right"><i
													class="mdi mdi-clock-outline"></i> 05 AM</span>
										</a>
									</li>
									<li class="dropdown-footer">
										<a class="text-center" href="#"> View All </a>
									</li>
								</ul>
							</li>
							<li class="right-sidebar-in right-sidebar-2-menu">
								<i class="mdi mdi-settings-outline mdi-spin"></i>
							</li>
						</ul>
					</div>
				</nav>
			</header>

<script>
  	var boxes = document.querySelectorAll(".notification-color");
  	var colors = ['#fa6b6b', '#677af5', '#5bbb5b', '#00abab', 'rosybrown', 'tan', 'plum', '#cb6d2a', '#abb56f', '#9b83e7', '#d5a448'];

  	boxes.forEach(function(box) {
    	var randomIndex = Math.floor(Math.random() * colors.length);
    	box.style.backgroundColor = colors[randomIndex];
    	colors.splice(randomIndex, 1); // Remove used color from array
		box.style.color = '#ffffff';

		// Reset colors array when all colors have been used
		if (colors.length === 0) {
    		colors = ['#fa6b6b', '#677af5', '#5bbb5b', '#00abab', 'rosybrown', 'tan', 'plum', '#cb6d2a', '#abb56f', '#9b83e7', '#d5a448'];
  		}
  	});
</script>

	<script>
        function updateImage() {
            let currentHour = new Date().getHours();
            let imageElement = document.getElementById("timeImage");
            let greetingText = document.getElementById("greeting");

            let images = {
                0: "assets/img/SunMoon/12AM.png",  
				1: "assets/img/SunMoon/1AM.png",  
				2: "assets/img/SunMoon/2AM.png",
                3: "assets/img/SunMoon/3AM.png",  
				4: "assets/img/SunMoon/4AM.png",  
				5: "assets/img/SunMoon/5AM.png",
                6: "assets/img/SunMoon/6AM.png",  
				7: "assets/img/SunMoon/7AM.png",  
				8: "assets/img/SunMoon/8AM.png",
                9: "assets/img/SunMoon/9AM.png",  
				10:"assets/img/SunMoon/10AM.png",  
				11:"assets/img/SunMoon/11AM.png",
                12:"assets/img/SunMoon/12PM.png",  
				13:"assets/img/SunMoon/1PM.png",  
				14:"assets/img/SunMoon/2PM.png",
                15:"assets/img/SunMoon/3PM.png",  
				16:"assets/img/SunMoon/4PM.png",  
				17:"assets/img/SunMoon/5PM.png",
                18:"assets/img/SunMoon/6PM.png",  
				19:"assets/img/SunMoon/7PM.png",  
				20:"assets/img/SunMoon/8PM.png",
                21:"assets/img/SunMoon/9PM.png",  
				22:"assets/img/SunMoon/10PM.png",  
				23:"assets/img/SunMoon/11PM.png"
            };

            // let greetings = {
            //     0: "Good Night 🌙", 1: "Good Night 🌙", 2: "Good Night 🌙",
            //     3: "Good Night 🌙", 4: "Good Night 🌙", 5: "Good Morning ☀️",
            //     6: "Good Morning ☀️", 7: "Good Morning ☀️", 8: "Good Morning ☀️",
            //     9: "Good Morning ☀️", 10: "Good Morning ☀️", 11: "Good Morning ☀️",
            //     12: "Good Afternoon 🌤️", 13: "Good Afternoon 🌤️", 14: "Good Afternoon 🌤️",
            //     15: "Good Afternoon 🌤️", 16: "Good Afternoon 🌤️", 17: "Good Afternoon 🌤️",
            //     18: "Good Evening 🌆", 19: "Good Evening 🌆", 20: "Good Evening 🌆",
            //     21: "Good Evening 🌆", 22: "Good Night 🌙", 23: "Good Night 🌙"
            // };

			let greetings = {
                0: "Good Night!", 1: "Good Night!", 2: "Good Night!",
                3: "Good Night!", 4: "Good Night!", 5: "Good Morning!",
                6: "Good Morning!", 7: "Good Morning!", 8: "Good Morning!",
                9: "Good Morning!", 10: "Good Morning!", 11: "Good Morning!",
                12: "Good Afternoon!", 13: "Good Afternoon!", 14: "Good Afternoon!",
                15: "Good Afternoon!", 16: "Good Afternoon!", 17: "Good Afternoon!",
                18: "Good Evening!", 19: "Good Evening!", 20: "Good Evening!",
                21: "Good Evening!", 22: "Good Night!", 23: "Good Night!"
            };
			

            imageElement.src = images[currentHour];
            greetingText.innerText = greetings[currentHour];
        }

        setInterval(updateImage, 3600000);
    </script>

	<script>
        function updateTime() {
            let now = new Date();
            let options = { timeZone: "Asia/Kolkata", hour12: false };
            let timeString = now.toLocaleTimeString("en-GB", options);
            let dateString = now.toLocaleDateString("en-GB", options);
            document.getElementById("timeing").innerHTML = "<b>"+ dateString + "</b> " + timeString;
        }

        setInterval(updateTime, 1000); 
    </script>